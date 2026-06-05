# config AGENTS.md

## Purpose

Laravel configuration. This folder owns application, service, cache, queue, auth, database, and package configuration.

## Read Order

1. Open only the config file named by the task or error.
2. Cross-check runbooks for deployment/runtime implications.
3. Cross-check standards before changing security, tenancy, auth, queue, cache, or logging config.

## Avoid

- Do not inspect all config files for a targeted config change.
- Do not change environment-sensitive defaults without documenting operational impact.
