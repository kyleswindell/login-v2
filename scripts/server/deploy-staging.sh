#!/usr/bin/env bash

set -euo pipefail

# Allow a small amount of environment override so the same script can be reused
# for staging adjustments without editing the file on the server.
APP_ROOT="${APP_ROOT:-/var/www/platform/current}"
PHP_BIN="${PHP_BIN:-php}"
COMPOSER_BIN="${COMPOSER_BIN:-composer}"
NPM_BIN="${NPM_BIN:-npm}"
GIT_BIN="${GIT_BIN:-git}"
TARGET_BRANCH="${TARGET_BRANCH:-main}"

cd "${APP_ROOT}"

echo "==> Pulling latest ${TARGET_BRANCH}"
"${GIT_BIN}" pull origin "${TARGET_BRANCH}"

echo "==> Installing Composer dependencies"
"${COMPOSER_BIN}" install --no-interaction --prefer-dist --optimize-autoloader

echo "==> Installing Node dependencies"
if [[ -f package-lock.json ]]; then
    "${NPM_BIN}" ci
else
    "${NPM_BIN}" install
fi

echo "==> Building frontend assets"
"${NPM_BIN}" run build

echo "==> Clearing and rebuilding Laravel caches"
"${PHP_BIN}" artisan config:clear
"${PHP_BIN}" artisan migrate --force
"${PHP_BIN}" artisan optimize:clear

echo "==> Attempting zero-prompt service reloads"
# Keep the deploy script non-interactive. If limited passwordless sudo is not
# configured yet, the deploy should still finish and report the skipped step.
if sudo -n systemctl reload php8.3-fpm 2>/dev/null; then
    echo "Reloaded php8.3-fpm"
else
    echo "Skipping php8.3-fpm reload: passwordless sudo is not configured for deploy"
fi

if sudo -n systemctl reload apache2 2>/dev/null; then
    echo "Reloaded apache2"
else
    echo "Skipping apache2 reload: passwordless sudo is not configured for deploy"
fi

echo "==> Deployment complete"
