<!--
DOC-META
title: Software Supply Chain Security Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Software Supply Chain Security Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines dependency inventory, lockfile, review, license, SBOM, CI, third-party script, build-artifact, provenance, secret-scan, and supply-chain release requirements.
-->

# Software Supply Chain Security Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Inventory](#2-inventory)
- [3. Lockfiles](#3-lockfiles)
- [4. New Dependencies](#4-new-dependencies)
- [5. Updates](#5-updates)
- [6. Abandoned Components](#6-abandoned-components)
- [7. SBOM And Component Evidence](#7-sbom-and-component-evidence)
- [8. Build Artifact Integrity](#8-build-artifact-integrity)
- [9. CI And Third-Party Actions](#9-ci-and-third-party-actions)
- [10. Secret Scanning](#10-secret-scanning)
- [11. Licenses](#11-licenses)
- [12. Release Gates](#12-release-gates)
- [13. Evidence And Response](#13-evidence-and-response)
- [14. Tests And Checks](#14-tests-and-checks)
- [15. Related](#15-related)

## 1. Purpose

Protect source, dependencies, build tooling, CI, images, third-party resources, and release artifacts from unreviewed or compromised inputs.

## 2. Inventory

Maintain an inventory of applicable Composer packages, npm packages, Docker and base-image inputs, CI actions and reusable workflows, third-party scripts and hosted resources, build tools, and generated artifacts.

Direct and transitive components must be distinguishable when evidence supports it.

## 3. Lockfiles

Commit and review lockfiles.

Manifest changes without matching lockfile changes, or unexplained lockfile changes, must block release.

Do not regenerate lockfiles casually during unrelated work.

## 4. New Dependencies

A new dependency requires owner, purpose, alternatives considered when risk is material, maintenance assessment, license review, advisory review, scope and permissions review, and a removal plan when temporary.

Prefer the smallest practical dependency set.

## 5. Updates

Updates require changelog or release review, security advisory review, compatibility tests, lockfile review, build verification, migration or configuration review, and rollback or remediation planning.

## 6. Abandoned Components

Abandoned, unmaintained, or unknown-license components require replacement planning or explicit accepted risk.

## 7. SBOM And Component Evidence

Release processes should be able to generate or derive an SBOM or equivalent inventory when required.

Evidence should identify release, commit, component, version, ecosystem, direct or transitive status, source, generated time, and digest or evidence hash.

Store detailed evidence privately when it exposes internal architecture.

## 8. Build Artifact Integrity

Record applicable commit SHA, lockfile hashes, build manifest hash, migration-set identity, artifact digest, build environment, and generated time.

Deployment must not promote an artifact whose identity conflicts with release evidence.

## 9. CI And Third-Party Actions

Pin and review security-sensitive actions and external tooling.

Limit permissions and secret exposure.

Do not allow pull-request code from untrusted contexts to access production secrets.

## 10. Secret Scanning

Scan source and release candidates.

A likely credential exposure blocks release and triggers secret rotation review.

## 11. Licenses

Classify licenses as allowed, review required, prohibited, or unknown.

Unknown or missing licenses require review.

## 12. Release Gates

Block release for applicable critical advisory, compromised package, secret finding, lockfile drift, artifact mismatch, required scanner failure, missing SBOM when required, or expired accepted risk.

## 13. Evidence And Response

Supply-chain findings must link to Vulnerability Management and response runbooks.

## 14. Tests And Checks

Automate package audits, lockfile checks, secret scans, artifact checks, and evidence generation where practical.

## 15. Related

- [Vulnerability Management Standards](Vulnerability%20Management%20Standards.md)
- [Application Security Verification And Secure Delivery Standards](Application%20Security%20Verification%20And%20Secure%20Delivery%20Standards.md)
- [Software Supply Chain Security Planning](../../07-planning/02-core-capabilities/security/software-supply-chain-security-planning.md)
