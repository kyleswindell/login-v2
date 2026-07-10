<!--
DOC-META
title: Server Readiness
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/server-readiness.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Defines pre-deployment server capability, service, extension, network, permission, environment, and application hardening checks.
-->

# Server Readiness

Parent: [Runbook Index](index.md)

## Purpose

Verify that a target server can safely host the current Login 2.0 staging runtime.

## Use When

Use before:

- first application bootstrap
- significant runtime upgrade
- deployment troubleshooting
- declaring a server deployment-ready

## Prerequisites

- authorized SSH access
- configured SSH alias
- sudo access for approved checks
- target environment identified
- no secrets copied into evidence

Set:

    SERVER_ALIAS=<configured-ssh-alias>

Connect:

    ssh "$SERVER_ALIAS"

## Host Identity

Run:

    hostnamectl
    uname -a
    lsb_release -a

Confirm the expected host and environment before continuing.

## Runtime Versions

Run:

    php -v
    composer --version
    node --version
    npm --version
    psql --version
    redis-server --version
    apache2 -v

Confirm versions match current architecture and support policy.

## Service Status

Run:

    systemctl is-active apache2
    systemctl is-active php8.3-fpm
    systemctl is-active postgresql
    systemctl is-active redis-server

All required services must report active.

## PHP Extensions

Run:

    php -m | sort

Confirm:

- bcmath
- curl
- fileinfo
- intl
- mbstring
- pdo_pgsql
- pgsql
- redis
- xml
- zip

Add image-processing extensions when current features require them.

## Apache

Run:

    sudo apache2ctl configtest
    sudo apache2ctl -M

Confirm:

- configuration syntax passes
- rewrite is enabled
- headers is enabled
- proxy and proxy_fcgi are enabled
- SSL modules are available when HTTPS is required

## PostgreSQL

Run:

    systemctl status postgresql --no-pager
    sudo -u postgres psql -c "select version();"

Do not expose PostgreSQL publicly.

## Redis

Run:

    redis-cli ping
    ss -lntp | grep 6379 || true

Expected response:

    PONG

Confirm Redis is bound only to approved interfaces.

## Filesystem

Confirm application paths:

    ls -ld /var/www/platform
    ls -ld /var/www/platform/releases
    ls -ld /var/www/platform/shared
    readlink -f /var/www/platform/current

Confirm deploy and web-service users can access required paths.

## Network And Firewall

Run approved checks:

    sudo ufw status verbose
    ss -lntup

Confirm only required ports are exposed.

## Environment

From the deployed application root, confirm required values exist without printing secrets:

    php artisan about
    php artisan config:show app.name
    php artisan config:show app.env
    php artisan config:show app.debug

Do not print the full environment file.

## Security Runtime Check

On an HTTPS staging surface:

    php artisan platform:security-runtime-check --target=staging --url=https://staging.parasolutions.com

The check must pass before the environment is used as security-hardening evidence.

## Failure Handling

When a check fails:

- record the command and sanitized output
- identify the owning service
- do not continue to deployment when the failure affects data, security, runtime compatibility, or rollback
- create a bounded issue
- rerun the failed check after correction

## Completion Criteria

The server is ready when:

- host identity is correct
- runtime versions are supported
- required services are active
- extensions are present
- Apache configuration passes
- PostgreSQL and Redis are reachable locally
- filesystem ownership is correct
- firewall exposure is approved
- application bootstrap works
- security runtime check passes when HTTPS is enabled

## Related

- [Deployment](deployment.md)
- [Server Bootstrap](server-bootstrap.md)
- [Staging Deployment](staging-deployment.md)
