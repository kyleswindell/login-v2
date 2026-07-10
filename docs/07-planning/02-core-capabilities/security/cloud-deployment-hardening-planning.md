# Cloud And Deployment Hardening Planning

Status: Planning

## Purpose

Plan deployment and runtime security hardening for Login 2.0.

This planning document covers environment separation, production deployment safety, server/web/database/storage hardening, release gates, rollback, backup/recovery readiness, configuration drift review, and deployment evidence.

It does not create final standards, runbooks, schema, runtime folders, dashboards, or active batch state.

## Direction

Deployment security should not be treated as "set `APP_DEBUG=false`." It must cover:

- environment separation
- deploy pipeline controls
- server, web, and database hardening
- secret handling
- private storage
- TLS
- backup and recovery
- audit and monitoring
- dependency, package, and image scanning
- rollback
- configuration drift
- evidence collection

Final rule:

```text
Every environment and deployment must be reproducible, least-privileged, encrypted, monitored, auditable, recoverable, and checked for misconfiguration before and after release.
```

## Ownership

Do not create:

```text
Modules/Deployment
Modules/Infrastructure
Modules/CloudSecurity
```

Use this ownership split:

| Owner | Responsibility |
| --- | --- |
| `app/Core/Security` | Deployment hardening checks, environment safety checks, security headers, trusted proxy/HTTPS expectations, safe config validation, public exposure checks, storage exposure checks, release gate checks. |
| `app/Core/Security/Deployment` | Optional future deployment readiness checks, environment profile DTOs, public exposure scanning, storage safety checks, deployment evidence contracts. |
| `app/Core/Security/OffensiveTesting` | Staging DAST readiness, authorized test windows, scan-safe environment expectations, and private test evidence contracts. |
| `app/Core/Security/SupplyChain` | Dependency inventory, SBOM metadata, build artifact identity, artifact integrity evidence, lockfile drift, and supply-chain release-gate inputs. |
| `app/Core/Security/VulnerabilityManagement` | Dependency/image/package findings, release block thresholds, accepted risk, patch status. |
| `app/Core/Monitoring` | Health checks, failed jobs, backup check state, deployment/runtime anomalies, configuration drift signals. |
| `app/Core/Audit` | Deployment events, config changes, release approvals, emergency deployments, rollback events. |
| `app/Core/Notifications` | Deployment failure, backup failure, critical vulnerability, config drift, production safety alerts. |
| `app/Core/Settings` | App-owned deployment/security policy values, not raw environment secrets. |
| `app/Core/DataProtection` | Private storage, export/download safety, data residency/retention expectations. |
| `app/Core/Security/Secrets` | Environment secret handling, rotation, redaction, deploy credential inventory. |
| `app/Platform/Console` | Optional internal evidence views after checks exist. |
| Infrastructure/runbooks | Actual server, cloud, networking, user, backup, and deployment operations. |

Laravel may define required checks, run app-level safety checks, record safe evidence, emit audit/monitoring events, notify owners, and block release through scripts/CI where possible. Laravel must not become a cloud control plane.

## Planned Source Documents

Content accepted from this planning pass should be promoted into the correct owner branches before implementation:

| Needed Document | Branch Responsibility | Purpose |
| --- | --- | --- |
| `docs/02-standards/security/deployment-security.md` | Standards | Parent deployment and runtime security rules. |
| `docs/02-standards/security/infrastructure-hardening.md` | Standards | Server, web, database, network, storage, and hardened baseline rules. |
| `docs/02-standards/security/environment-management.md` | Standards | Local/testing/staging/production environment contracts. |
| `docs/02-standards/security/configuration-management.md` | Standards | Versioned configuration, drift review, and reproducible deployment expectations. |
| `docs/02-standards/security/database-deployment-security.md` | Standards | DB exposure, least-privilege users, backup, encryption, and admin access rules. |
| `docs/10-runbooks/production-deployment-security.md` | Runbooks | Production deploy safety checks, evidence, and approval workflow. |
| `docs/10-runbooks/server-hardening.md` | Runbooks | Host, webserver, PHP-FPM/Apache/Nginx, database exposure, file permission, and admin access checks. |
| `docs/10-runbooks/deployment-rollback.md` | Runbooks | Code/config/cache/queue/asset/migration rollback procedure. |
| `docs/10-runbooks/configuration-drift-review.md` | Runbooks | Server/config drift comparison and review procedure. |
| `docs/10-runbooks/environment-restore.md` | Runbooks | Environment restore steps and validation. |

If the standards branch needs fewer files first, start with `deployment-security.md` as the parent and split the others later.

## Deployment Planes

Use three planes when reasoning about deployment hardening:

| Plane | Scope |
| --- | --- |
| Edge plane | DNS, TLS certificate, reverse proxy, Apache/Nginx, firewall/security groups, public HTTP ingress, CDN/WAF later. |
| Management plane | SSH/admin access, deployment user, CI/CD credentials, database admin access, backup/restore access, logs/monitoring access, secrets/env management. |
| Workload plane | Laravel app, PHP-FPM/Apache runtime, queue workers, scheduler, database access from app user, storage, cache, session, mail services. |

Planning rule:

```text
The public web workload must not also be the unrestricted management plane.
```

Required implications:

- web user cannot write the codebase except storage/cache paths where required
- deploy user is separate from web runtime user
- DB app user is not DB root/admin
- backups are not stored in public web-accessible directories
- logs are not web-accessible
- `.env` is not web-accessible
- `storage/app/private` is never served directly
- admin/deployment credentials are not reused as app credentials

## Environment Contracts

Planned environments:

```text
local
testing
staging
production
```

Each environment needs a documented contract:

```text
Environment:
Purpose:
Allowed data:
Allowed secrets:
Allowed mail behavior:
Allowed queue behavior:
Allowed debug behavior:
Allowed storage disks:
Allowed external integrations:
Backup requirements:
Monitoring requirements:
Who can access:
```

Baseline rules:

| Environment | Rules |
| --- | --- |
| Local | Fake/test data allowed, debug mode allowed, no production secrets, no production database copy unless masked. |
| Testing | CI-only, fake mail/notifications, no production secrets, disposable database. |
| Staging | Production-like config, `APP_DEBUG=false`, no real customer secrets unless explicitly approved, mail sandboxed or restricted, release validation surface. |
| Production | `APP_DEBUG=false`, HTTPS only, secure cookies, real secrets only from protected environment/vault, private exports only, backups enabled, monitoring enabled, audit enabled. |

## Laravel Production Configuration

Production `.env` expectations:

```text
APP_ENV=production
APP_DEBUG=false
APP_URL=https://...
LOG_LEVEL=warning or appropriate production level
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax or strict based on app behavior
QUEUE_CONNECTION configured
CACHE_STORE configured
MAIL_MAILER production-safe
FILESYSTEM_DISK not public for protected files
```

Do not place raw secrets in docs, tickets, screenshots, seeders, factories, committed config, or release evidence.

Required deployment command intent:

```text
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan config:cache
php artisan route:cache, if compatible
php artisan view:cache
php artisan migrate --force
php artisan queue:restart
```

Pre-deploy must-checks:

- `APP_DEBUG=false`
- `APP_ENV=production`
- `APP_KEY` exists and is not regenerated accidentally
- migrations reviewed
- config cache builds
- route cache builds if used
- Vite build exists
- storage links verified
- private storage is not public
- `public/build` has only compiled assets
- no `.env` in public
- no backup/archive file in public
- no test/debug route enabled
- no Telescope/debugbar-style tooling exposed

## Web Server Hardening

Public web root must be:

```text
public/
```

Never:

```text
project root
storage/
database/
vendor/
.env accessible path
```

Sensitive paths that must not be web-accessible:

```text
.env
.git
composer.json
composer.lock
package.json
package-lock.json
vite.config.*
phpunit.xml
storage/
database/
resources/
routes/
app/
Modules/
docs/
ops/
scripts/
vendor/
node_modules/
```

Apache/Nginx baseline:

- HTTPS enforced
- HTTP redirects to HTTPS
- HSTS in production
- no directory listing
- no public `server-status`
- no PHP execution in upload directories
- request body size limits
- timeout limits
- security headers
- logs enabled and rotated

If deployment config files are stored, use environment-owned paths such as:

```text
ops/staging/apache/
ops/staging/systemd/
ops/production/apache/
ops/production/systemd/
```

## TLS And Encryption

In transit:

- HTTPS only in production
- TLS 1.2+ minimum
- secure cookies
- HSTS
- no mixed content

At rest:

- database/server/disk backup encryption at infrastructure layer
- Laravel encrypted casts for secrets the app must read
- hashes for tokens/codes
- private storage for exports/uploads

Do not encrypt every column by default. Use DataProtection classifications:

| Classification | Direction |
| --- | --- |
| Restricted | Strong encryption/hash where applicable, strict audit, no direct export. |
| Confidential | Access controls, private storage, audit, protected backups. |
| Internal | Normal app protection. |
| Public | Public assets only. |

## Database Hardening

Baseline:

- app runtime DB user is least-privileged
- no DB root/admin credentials in app `.env`
- migration/admin DB access separated later if possible
- backup user separated if needed
- database is not publicly accessible
- database accepts app host/network only
- no direct external access except approved management path
- database logs monitored
- backups encrypted
- production data not copied to local/staging unless masked

## Storage Hardening

Storage classes:

| Class | Purpose |
| --- | --- |
| Public | Compiled assets and intentionally public files only. No secrets, exports, backups, logs, or protected attachments. |
| Private | Generated exports, protected uploads, internal attachments, temporary generated files. |
| Quarantine | Untrusted uploads before validation/scanning later. |
| Backups | Outside web root, encrypted, restricted access. |

Rules:

- never store exports on public disk
- signed expiring downloads only
- downloads re-check authorization
- uploads validate MIME, extension, and size
- no PHP/script execution from uploads
- original filenames are metadata only
- generated filenames are server-side
- cleanup jobs for expired exports/temp files

## Network And Access Hardening

Network ingress:

- only HTTP/HTTPS public
- SSH restricted by IP/VPN/admin network where possible
- database not public
- cache/queue not public
- mail/API credentials protected

Management access:

- MFA on hosting/cloud/admin accounts
- unique admin users
- no shared SSH/admin accounts where possible
- deploy key limited to deployment needs
- password SSH disabled if key-based SSH is used
- keys rotated on user departure

Application segmentation:

- public routes
- authenticated routes
- admin routes
- sensitive admin routes
- export/download routes
- service/webhook routes

## Configuration Drift

Deployment configuration should be versioned, reviewed, reproducible, and checkable.

Track:

- `ops/staging/apache`
- `ops/staging/systemd`
- future `ops/production/apache`
- future `ops/production/systemd`
- Docker Compose files
- Dockerfiles
- `.env.example`
- filesystem permission notes
- cron/scheduler setup
- queue worker setup
- backup config

Configuration drift review should check:

- server config compared to repo config
- public web root
- env values
- services running
- queue/scheduler
- backup jobs
- TLS certificate status
- firewall rules
- no public sensitive files

## Release Gates

Pre-merge gates:

- tests pass
- security tests pass
- code formatting passes
- static analysis passes when available
- DAST/staging offensive scan completed when required for the release class
- Composer audit reviewed
- npm audit reviewed
- lockfile drift reviewed
- SBOM/release evidence generated when the supply-chain gate is enabled
- no protected route without policy
- no state-changing GET
- no raw secret in testable logs/config

Pre-deploy gates:

- build artifact generated
- migrations reviewed
- config cache succeeds
- route cache succeeds if used
- `APP_DEBUG=false` for production
- private storage checks pass
- public sensitive file check passes
- open critical/high vulnerability findings = 0 unless accepted
- backup available or deployment rollback plan confirmed

Deploy evidence:

```text
test result
dependency audit summary
SBOM path/hash
lockfile hashes
build hash/version
migration list
release notes
approver
deployment time
rollback plan
```

## Optional App Folder Direction

Optional later structure:

```text
app/Core/Security/Deployment/
  Actions/
  Data/
  Enums/
  Services/
  Support/
```

Potential services:

- `DeploymentReadinessService`
- `EnvironmentConfigurationInspector`
- `PublicExposureScanner`
- `StorageSafetyChecker`
- `DeploymentEvidenceService`

Do this only after docs/checklists exist.

## Vulnerability And Posture Stages

Stage 1, app-level checks:

- Composer audit
- npm audit
- route safety checks
- storage exposure checks
- `APP_DEBUG` check
- public sensitive file check
- migration review checklist

Stage 2, host-level checks:

- OS patch status
- PHP version
- database version
- web server version
- TLS certificate expiry
- disk free
- queue worker health
- cron/scheduler health
- backup age

Stage 3, cloud/provider checks:

- firewall/security group rules
- database public exposure
- object storage public exposure
- IAM/admin account MFA
- backup location and encryption
- audit log forwarding

Use CIS benchmarks as future server-hardening reference where applicable. Do not invent every low-level hardening rule from scratch.

## Monitoring Checks

Planned checks:

```text
AppHealthCheck
QueueWorkerHealthCheck
SchedulerHealthCheck
StorageWritableCheck
PrivateStorageExposureCheck
BackupFreshnessCheck
TlsCertificateExpiryCheck
DiskSpaceCheck
MailDeliveryCheck
```

## Backup, Recovery, And Rollback

Before deploy:

- backup exists
- rollback plan exists
- migrations reviewed for reversibility/data risk
- emergency deploy process defined

After deploy:

- app boots
- queues running
- scheduler running
- health checks pass
- logs clean
- key workflows smoke-tested

Rollback runbook should cover:

- code rollback
- config rollback
- migration rollback or forward fix
- cache clear/rebuild
- queue restart
- asset rebuild
- DB restore only as last resort

## Admin And Deployment Identity

Human deployment/admin users:

- individual accounts, not shared accounts
- MFA required
- least privilege
- production access separated from local dev
- access revoked on offboarding
- privileged actions audited

Service/deployment actors:

- CI/CD deploy token
- backup job actor
- scheduler actor
- queue worker actor
- integration actor

Future ownership:

| Owner | Responsibility |
| --- | --- |
| `Core/Auth` | Service credential verification. |
| `Core/Identity` | Service account records. |
| `Core/Access` | Service account permissions/scopes. |
| `Core/Audit` | Service actor evidence. |
| `Core/Security/Secrets` | Deploy token/secret inventory. |

## Test And Check Planning

Expected tests/checks:

| Area | Checks |
| --- | --- |
| Environment safety | Production profile has `APP_DEBUG=false`, valid `APP_ENV`, secure cookie settings. |
| Public exposure | `.env`, private storage, docs, scripts, ops, backups, archives, and source paths are not public. |
| Storage safety | Exports are private, signed links expire, upload disk cannot execute scripts. |
| Security headers | HSTS in production, content type nosniff, CSP baseline, frame protection. |
| Deployment readiness | Build artifact exists, config cache builds, route cache builds if enabled, pending migrations detected, queue health available. |
| Backup readiness | Latest backup age within policy, restore drill status recorded manually or through Monitoring later. |

## Implementation Sequence

### 1. Docs And Environment Contracts

- Add this planning document.
- Promote deployment security standards.
- Promote environment management standards.
- Promote production deployment and server hardening runbooks.
- Promote deployment rollback and configuration drift runbooks.
- Update the Core Service Build Plan Matrix.

### 2. Release Checklist Integration

- Extend security release checklist with deployment checks.
- Add deployment evidence section.
- Add migration review section.
- Add backup/rollback confirmation.
- Add open critical/high vulnerability check.

### 3. App-Level Automated Checks

- Add deployment readiness check service.
- Add environment profile DTO.
- Add public exposure scanner.
- Add storage safety checker.
- Add health/backup check integration.

### 4. Monitoring And Notifications

- Health check failed -> Monitoring event.
- Backup stale -> Monitoring event and Notification.
- TLS expiring -> Monitoring event and Notification.
- Deployment check failed -> Notification.
- Critical public exposure finding -> Vulnerability finding and Notification.

### 5. Optional Admin Evidence UI

Only after checks exist:

- Admin > Security > Deployment readiness
- Admin > Monitoring > Health checks
- Admin > Vulnerability Management > Deployment findings

## Transition Rules

- Do not create `Modules/Deployment`, `Modules/Infrastructure`, or `Modules/CloudSecurity`.
- Do not create `app/Core/Deployment` or `app/Core/Infrastructure` until a later architecture decision proves a runtime boundary is needed.
- Do not make Laravel provision cloud firewalls, manage OS users, store production root/admin credentials, or act as a vault.
- Do not build a dashboard before checks and evidence exist.
- Do not rely on manual checkboxes without evidence where automated checks are practical.
- Do not store raw deployment secrets or raw backup contents in app tables.

## Open Decisions

- Should deployment readiness checks live under `app/Core/Security/Deployment` or remain scripts/runbooks first?
- Should production deployment evidence be stored as generated artifacts, Audit events, or future `deployment_check_results` rows?
- Which checks block deployment first: `APP_DEBUG`, public exposure, storage exposure, critical vulnerabilities, backup freshness, or migration review?
- Which environment configuration fields may be visible in admin evidence without exposing secrets?
- When should production server configs under `ops/production/*` be added?
- Which deployment/admin actors should be modeled first as service actors?

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Offensive Security And Penetration Testing Planning](offensive-security-penetration-testing-planning.md)
- [Software Supply Chain Security Planning](software-supply-chain-security-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
- [Backup And Recovery Planning](backup-recovery-planning.md)
- [Incident Response Planning](incident-response-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md)
