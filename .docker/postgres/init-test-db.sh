#!/bin/sh
set -eu

TEST_DATABASE="${POSTGRES_TEST_DB:-login_v2_test}"

if [ "$TEST_DATABASE" = "$POSTGRES_DB" ]; then
    exit 0
fi

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname postgres <<SQL
SELECT 'CREATE DATABASE "$TEST_DATABASE" OWNER "$POSTGRES_USER"'
WHERE NOT EXISTS (
    SELECT FROM pg_database WHERE datname = '$TEST_DATABASE'
) \gexec
SQL
