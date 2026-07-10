# Software Supply Chain Security Planning

Status: Planning

## Purpose

Plan software supply chain security as a Core Security capability for dependency inventory, SBOM metadata, build artifact identity, release evidence, and supply-chain release gates.

This document owns implementation sequencing and intent only. Final standards, architecture contracts, schema contracts, CI contracts, operational procedures, and release commands must be promoted into their owning docs before implementation.

## Direction

Software supply chain security is not a business module and should not be implemented as `Modules/SupplyChain`, `Modules/Dependencies`, or `Modules/SBOM`.

Target placement:

```text
app/Core/Security/SupplyChain
```

The capability should answer this release question:

```text
Every release must know exactly what source, dependencies, build artifacts, scans, tests, secrets checks, SBOMs, approvals, and accepted risks produced it.
```

Start with docs, checks, generated evidence, release gates, and accepted-risk rules. Do not build a persistent dashboard, artifact-signing automation, or SBOM lifecycle UI before the inventory and evidence sources exist.

## Ownership Split

| Owner | Responsibility |
| --- | --- |
| `app/Core/Security/SupplyChain` | Dependency inventory, SBOM metadata, build artifact inventory, artifact identity, source/build/deploy evidence model, dependency review policy, supply-chain release gates, and supply-chain accepted-risk metadata. |
| `app/Core/Security/VulnerabilityManagement` | Findings, severity/risk, SLAs, accepted risk lifecycle, critical/high release blocking, patch/remediation status, and reporting. |
| `app/Core/Security/Secrets` | Secret leak patterns, detect-secrets baseline, secret rotation policy, token/credential redaction, and leak response requirements. |
| `app/Core/Security/Deployment` | Deployment readiness checks, deployment evidence contracts, and release readiness support where app-level deployment checks are implemented. |
| `app/Core/Audit` | Release approvals, supply-chain risk acceptance, dependency updates, artifact promotion evidence, and emergency patch decisions. |
| `app/Core/Monitoring` | Supply-chain check failures, scanner failures, missing CI evidence, stale dependency inventory, unpatched critical package signals, and artifact mismatch signals. |
| `app/Core/Notifications` | Blocked release, critical supply-chain finding, SBOM failure, secret detection, accepted-risk expiration, and artifact mismatch notifications. |
| Runbooks and CI/CD | Dependency patching, SBOM generation, package compromise response, release evidence collection, build artifact rollback, and external scan execution. |

`SupplyChain` should not own runtime authorization, Auth/session behavior, business module behavior, raw scanner implementation, raw deployment execution, or infrastructure provisioning.

## Scope

Supply chain security covers everything that can enter, build, configure, or deploy the app:

- source code
- Composer packages
- npm packages
- Laravel, Filament, Livewire, Vite, and build tooling dependencies
- Docker/base images
- PHP extensions and OS packages
- CI/CD scripts and local release scripts
- PowerShell/server scripts
- Apache/systemd/deployment config
- `.env.example` and runtime configuration expectations
- compiled frontend assets
- database migrations, seeders, and factories
- business module templates
- third-party integrations and scripts
- secrets and build credentials
- deployment artifacts and release evidence

## Target Structure

Eventual structure:

```text
app/Core/Security/SupplyChain/
  Actions/
  Data/
  Enums/
  Models/
  Queries/
  Services/
  Support/
  Routes/
```

MVP structure, only when implementation begins:

```text
app/Core/Security/SupplyChain/
  Data/
  Enums/
  Services/
    DependencyInventoryService.php
    SupplyChainReleaseGate.php
    SupplyChainEvidenceService.php
  Support/
```

Likely later classes:

- `GenerateDependencyInventory`
- `GenerateSbom`
- `RecordBuildArtifact`
- `RecordSupplyChainEvidence`
- `ValidateBuildArtifact`
- `RecordDependencyReview`
- `RecordAcceptedSupplyChainRisk`
- `DependencyInventoryService`
- `ComposerInventoryReader`
- `NpmInventoryReader`
- `SbomService`
- `BuildArtifactInventory`
- `ArtifactIntegrityService`
- `SupplyChainReleaseGate`
- `SupplyChainEvidenceService`
- `PackageRiskPolicy`

## Supply Chain Assets

Track immutable asset identity wherever possible. Do not rely only on mutable tags such as `latest`, `staging`, `production`, or `v1-current`.

Suggested asset types:

- `source_commit`
- `composer_lock`
- `package_lock`
- `dockerfile`
- `docker_image`
- `vite_build`
- `compiled_public_build`
- `migration_set`
- `deployment_config`
- `apache_config`
- `systemd_config`
- `release_bundle`
- `sbom`
- `pipeline_run`

Suggested asset keys:

```text
source:git:<commit-sha>
composer:lock:<hash>
npm:lock:<hash>
docker:image:<digest>
vite:build:<manifest-hash>
migration:set:<hash>
deploy:config:<hash>
sbom:cyclonedx:<hash>
pipeline:run:<id>
```

## Dependency Inventory

Composer inventory should track:

- `composer.json`
- `composer.lock`
- package name and version
- direct versus transitive dependency
- license
- abandoned status
- source/dist URL
- security advisories
- update availability

Composer checks:

- `composer validate`
- `composer audit`
- `composer outdated --direct`
- production builds use `composer install --no-dev --optimize-autoloader`

npm inventory should track:

- `package.json`
- `package-lock.json`
- package name and version
- direct versus transitive dependency
- license
- known vulnerabilities
- build-only versus runtime relevance

npm checks:

- `npm ci`
- `npm audit`
- `npm outdated`
- `npm run build`

Docker/image inventory should track:

- base image
- image digest
- PHP version
- Node version
- OS packages
- PostgreSQL image version
- image vulnerability scan result

## SBOM Planning

Use CycloneDX as the preferred SBOM format for app security and component analysis. SPDX can remain optional later.

Generate SBOM metadata from:

- Composer dependencies
- npm dependencies
- Docker/base images later
- release artifact metadata

Store SBOM output as private build/release evidence first. Persist only metadata later if release reporting or admin visibility requires it.

Suggested private evidence paths:

```text
storage/app/private/release-evidence/{release}/sbom.cyclonedx.json
storage/app/private/release-evidence/{release}/composer-audit.json
storage/app/private/release-evidence/{release}/npm-audit.json
storage/app/private/release-evidence/{release}/test-results.xml
storage/app/private/release-evidence/{release}/build-manifest.json
```

Do not store release evidence in public storage.

## Artifact Integrity

MVP integrity controls:

- record git commit SHA
- record `composer.lock` hash
- record `package-lock.json` hash
- record Vite build manifest hash
- record migration set hash
- record build timestamp
- record build environment
- record test and audit results

Later controls:

- sign build artifacts
- verify signatures before deployment
- pin image digests
- deploy only from a build artifact, not ad-hoc server edits
- maintain release inventory with immutable artifact IDs

## Release Evidence Model

Start with generated files and a release checklist. Add persistence only when reporting, release history, or admin visibility requires it.

Future optional table: `supply_chain_evidence_records`

Candidate columns:

```text
id
release_id
asset_type
asset_key
evidence_type
tool
result
summary
artifact_path
metadata
created_at
updated_at
```

Evidence types:

- `unit_tests`
- `feature_tests`
- `browser_tests`
- `static_analysis`
- `composer_audit`
- `npm_audit`
- `sbom`
- `detect_secrets`
- `security_routes_check`
- `security_headers_check`
- `build_manifest`
- `artifact_digest`
- `migration_review`
- `manual_approval`
- `accepted_risk`

## Release Gates

Phase 1 gates:

- `composer validate`
- `composer audit`
- `npm audit`
- `npm ci`
- `npm run build`
- `php artisan test`
- `vendor/bin/pint --test`
- static analysis when available
- production profile has `APP_DEBUG=false`
- no public sensitive files
- no state-changing GET route
- no unaccepted critical/high vulnerability

Phase 2 gates:

- SBOM generated
- dependency inventory generated
- detect-secrets scan
- lockfile drift check
- security route checks
- private storage/export checks
- migration review checklist
- artifact hash recorded

Phase 3 gates:

- artifact signing
- DAST scan against staging
- release evidence bundle
- continuous compliance scan
- dependency reachability review
- deployment inventory

Release gate rule:

```text
No production deployment if a critical/high supply-chain finding is open and unaccepted.
```

## Lockfile Policy

`composer.lock` and `package-lock.json` are security artifacts.

Required rules:

- lockfiles must be committed
- lockfile changes require review
- no package update hidden inside an unrelated feature PR
- dependency update PRs should state why the update is needed
- production builds use lockfiles, not floating installs
- abandoned packages require a replacement plan or accepted risk

Future check: `LockfileDriftCheck`

It should flag:

- `composer.json` changed without `composer.lock`
- `package.json` changed without `package-lock.json`
- lockfile changed without a dependency-review note

## License Policy

Start with review rules before overbuilding license automation.

MVP license posture:

| Status | Licenses |
| --- | --- |
| Allowed | MIT, BSD, Apache-2.0, ISC |
| Review required | GPL, AGPL, LGPL, unknown, custom commercial, no license |

## Secret Scanning

Supply-chain release gates should include secret scanning, while `Core/Security/Secrets` owns the actual secret handling and rotation policy.

Detect:

- committed `.env`
- `APP_KEY`
- database passwords
- API tokens
- webhook secrets
- OAuth secrets
- private keys
- session cookies
- recovery codes

Response:

- block release
- rotate exposed secret
- audit accepted risk if not immediately fixed
- notify security owner

## Dependency Update Workflow

Operational dependency patching belongs in `docs/10-runbooks/dependency-patching.md`.

The intended workflow:

1. Identify update source: Composer audit, npm audit, vendor advisory, Laravel/security advisory, or manual review.
2. Categorize: security patch, bug fix, minor feature, major upgrade, or abandoned package replacement.
3. Review risk: direct/transitive, runtime/build-only, auth/access/data/security impact, known exploit, and package maintenance.
4. Update in an isolated branch, update lockfiles, run tests/build/audits, and note migrations or breaking changes.
5. Verify test suite, security tests, build, and manual smoke where needed.
6. Record dependency review, audit evidence, and accepted risk if deferred.

## Compromised Package Response

Operational response belongs in `docs/10-runbooks/compromised-package-response.md`.

Runbook intent:

1. Identify affected package/version.
2. Check if installed in `composer.lock` or `package-lock.json`.
3. Check whether runtime uses it.
4. Check environments where deployed.
5. Pause deployments if needed.
6. Patch, remove, or downgrade.
7. Rotate secrets if package could access secrets.
8. Review audit and monitoring logs.
9. Rebuild artifact.
10. Redeploy from clean artifact.
11. Record incident/evidence.

Treat compromised npm/Vite build dependencies seriously because they can affect compiled frontend assets.

## Business Module Template Requirements

Do not use the business module template for core capabilities. When the business template is updated, it should lightly require each business module to declare:

- external package dependencies, if any
- external service dependencies, if any
- build/runtime assets contributed
- public assets contributed
- migrations contributed
- seeders/factories contributed
- export/download behavior

Potential future template files:

```text
Modules/_Template/docs/supply-chain.md
Modules/_Template/Definitions/ModuleDependencies.php
Modules/_Template/tests/Feature/Security/SupplyChainTest.php
```

## Monitoring, Notifications, And Audit

Monitoring signals:

- `DET-SUPPLY-001` critical dependency vulnerability
- `DET-SUPPLY-002` lockfile drift
- `DET-SUPPLY-003` SBOM generation failed
- `DET-SUPPLY-004` detect-secrets failure
- `DET-SUPPLY-005` artifact integrity mismatch
- `DET-SUPPLY-006` scanner unavailable
- `DET-SUPPLY-007` accepted risk expired
- `DET-SUPPLY-008` abandoned package detected

Notification type candidates:

- `security.supply_chain.critical_finding`
- `security.supply_chain.release_blocked`
- `security.supply_chain.sbom_failed`
- `security.supply_chain.secret_detected`
- `security.supply_chain.accepted_risk_expired`
- `security.supply_chain.artifact_mismatch`

Audit event candidates:

- `supply_chain.sbom_generated`
- `supply_chain.artifact_recorded`
- `supply_chain.release_gate_failed`
- `supply_chain.release_gate_passed`
- `supply_chain.risk_accepted`
- `supply_chain.dependency_updated`
- `supply_chain.secret_detected`
- `supply_chain.artifact_promoted`

Digital forensics readiness is tracked in [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md) and the [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md). SupplyChain should produce release and build evidence that can be referenced by Audit/Forensics during incident reconstruction, but Audit/Forensics owns evidence package manifests, chain-of-custody records, and formal investigation exports.

## Admin UI Later

Do not build supply-chain admin UI first. Later, Admin > Security may include:

```text
Security
  Supply chain
    Overview
    Dependencies
    SBOMs
    Build artifacts
    Release evidence
    Accepted risks
```

Only add UI after release evidence and checks exist.

## Implementation Sequence

### 1. Docs And Check-First Baseline

- Promote this planning direction into standards/runbook targets.
- Add the supply-chain source planning row to the core service matrix.
- Decide which checks are documentation-only, script-backed, CI-backed, or Laravel service-backed.

### 2. Release Gate Baseline

- Add `SupplyChainReleaseGate`.
- Add `ComposerInventoryReader`.
- Add `NpmInventoryReader`.
- Add lockfile drift check.
- Add Composer audit and npm audit evidence expectations.
- Add secret scan placeholder/check.
- Add release checklist output.

### 3. SBOM And Evidence

- Generate SBOM file.
- Store SBOM in private release evidence path.
- Record build artifact metadata.
- Record commit SHA and lockfile hashes.
- Link evidence to release/deployment checklist.

### 4. Vulnerability Integration

- Feed dependency findings into Vulnerability Management.
- Apply severity/risk scoring.
- Block release on unaccepted critical/high findings.
- Add accepted risk expiration.
- Notify security owner.

### 5. Optional Admin UI

- Add supply chain overview.
- Add dependency inventory.
- Add release evidence.
- Add accepted risk list.

## Standards And Runbooks To Add Later

Standards candidates:

- `docs/02-standards/security/software-supply-chain-security.md`
- `docs/02-standards/security/dependency-management.md`
- `docs/02-standards/security/sbom-and-artifact-inventory.md`
- `docs/02-standards/security/build-artifact-integrity.md`
- `docs/02-standards/security/dependency-license-policy.md`

Runbook candidates:

- `docs/10-runbooks/dependency-patching.md`
- `docs/10-runbooks/supply-chain-incident-response.md`
- `docs/10-runbooks/compromised-package-response.md`
- `docs/10-runbooks/build-artifact-rollback.md`
- `docs/10-runbooks/sbom-generation.md`

## Test Planning

Expected first tests once implemented:

- `ComposerLockfilePresentTest`
- `PackageLockfilePresentTest`
- `LockfileDriftTest`
- `ComposerAuditGateTest`
- `NpmAuditGateTest`
- `SbomGenerationEvidenceTest`
- `BuildArtifactEvidenceTest`
- `DetectSecretsGateTest`
- `CriticalSupplyChainFindingBlocksReleaseTest`
- `AcceptedSupplyChainRiskExpiresTest`
- `DependencyUpdateAuditTest`
- `ReleaseEvidenceStoredPrivatelyTest`

## Transition Rules

- Do not create `Modules/SupplyChain`, `Modules/Dependencies`, or `Modules/SBOM`.
- Do not build a full SBOM dashboard before SBOM files exist.
- Do not build artifact signing before artifact identity exists.
- Do not build a custom vulnerability database.
- Do not replace Composer audit or npm audit.
- Do not pursue SLSA certification before basic inventory, evidence, release gates, and accepted-risk workflow exist.
- Do not overbuild license automation before license review rules exist.
- Do not create release UI before release gates produce evidence.
- Do not store release evidence on a public disk.

## Open Decisions

- Which supply-chain gate is first: Composer audit, npm audit, lockfile drift, SBOM generation, detect-secrets, or build artifact evidence?
- Should the first release evidence live only as files, or also as `supply_chain_evidence_records`?
- Which SBOM generator and format version should be used first?
- Should SupplyChain own dependency inventory persistence, or should generated inventory reports remain file-first until admin UI is needed?
- Which licenses require formal accepted risk versus simple review?
- Which supply-chain notification types become persistent first?
- Should artifact identity be tied to Deployment evidence, Vulnerability findings, or both?

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
- [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md)
