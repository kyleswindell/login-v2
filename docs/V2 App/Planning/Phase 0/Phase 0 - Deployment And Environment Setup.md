# Phase 0 - Deployment And Environment Setup

## Purpose

Capture the pre-application setup work needed before the core app grows further.

Phase 0 exists to reduce deployment and infrastructure risk early, while the application is still small enough to validate cleanly.

## Goal

Establish a reliable Git and deployment workflow, verify the production server stack, and make the DigitalOcean server ready to receive and run the app safely.

## In Scope

* Git remote setup and multi-device workflow
* server package and runtime verification
* deployment directory strategy
* environment and permissions readiness
* initial Laravel deployment validation
* documentation of the deployment path

## Out Of Scope

* full application feature rollout
* tenant provisioning implementation
* production-hardening every future service immediately
* CI/CD automation beyond the minimal documented workflow

## Why This Phase Exists

This phase should happen now because it is much easier to debug:

* server setup
* deploy permissions
* PHP/runtime issues
* Composer/build issues
* environment configuration

while the app is still small than after the core app becomes large and feature-rich.

It also supports multi-device development by making Git the source of truth early.

## Current Direction

Preferred flow:

* local repo is the working copy
* GitHub private repo is the remote source of truth
* the DigitalOcean server pulls from Git for deployment

## Verified Current State

As of the completed Phase 0 validation pass:

* GitHub remote is configured and `main` has been pushed
* WSL SSH can authenticate to GitHub
* WSL SSH can connect to `platform-prod-wsl`
* remote host is `platform-prod-01`
* server OS is Ubuntu 24.04.4 LTS
* Apache is installed and active
* PHP 8.3 CLI and PHP-FPM are installed
* Composer is installed
* PostgreSQL 16 is installed and active
* Redis 7 is installed and active
* required PHP extensions checked so far are present
* Node.js and npm are installed
* release-based deploy root exists at `/var/www/login-v2`
* release directories and shared directory exist
* the first release has been cloned from GitHub
* `/var/www/login-v2/current` points to the first release
* Composer install has completed successfully inside the current release
* shared server `.env` exists at `/var/www/login-v2/shared/.env`
* the current release reads `.env` through a symlink
* `APP_KEY` has been generated successfully on the server
* `php artisan about` runs successfully from the current release
* Apache is serving the Laravel vhost from `/var/www/login-v2/current/public`
* Node.js has been upgraded to a Vite-compatible version
* frontend assets build successfully in the current release
* `curl -I http://127.0.0.1` returns `200 OK`

## Immediate Phase 0 Gaps

Current gaps still to resolve:

* replace temporary staging-oriented `.env` values with real deployment secrets and service endpoints
* decide whether server-side Node builds are temporary validation only or part of the long-term deploy flow
* move writable-path handling from one-time fix into a documented repeatable deploy step
* decide when to add SSL, domain, and Apache hardening beyond the minimal validation setup

## Candidate Deliverables

* verified remote Git workflow
* verified server stack checklist
* documented deployment directory structure
* documented environment variable handling
* first successful server-side application bootstrap
* first successful Apache-served HTTP response from the deployed Laravel app

## Related

* [[V2 App/Planning/Phase 0/Phase 0 Index]] | [Phase 0 Index](Phase%200%20Index.md)
* [[V2 App/Planning/Phase 0/Server Bootstrap Checklist]] | [Server Bootstrap Checklist](Server%20Bootstrap%20Checklist.md)
* [[V2 App/Planning/Phase 0/Deployment Workflow]] | [Deployment Workflow](Deployment%20Workflow.md)
* [[V2 App/Planning/Phase 0/Git Remote And Multi-Device Workflow]] | [Git Remote And Multi-Device Workflow](Git%20Remote%20And%20Multi-Device%20Workflow.md)
