<!--
DOC-META
title: File Upload Download And Export Security Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/File Upload Download And Export Security Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines untrusted-file validation, private storage, signed access, generated exports, reauthorization, retention, and file evidence requirements.
-->

# File Upload Download And Export Security Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Storage Classes](#2-storage-classes)
- [3. Upload Validation](#3-upload-validation)
- [4. Storage](#4-storage)
- [5. Scanning And Quarantine](#5-scanning-and-quarantine)
- [6. Download Authorization](#6-download-authorization)
- [7. Generated Exports](#7-generated-exports)
- [8. Imports](#8-imports)
- [9. Response Safety](#9-response-safety)
- [10. Retention And Deletion](#10-retention-and-deletion)
- [11. Evidence](#11-evidence)
- [12. Tests](#12-tests)
- [13. Related](#13-related)

## 1. Purpose

Protect file upload, storage, generation, preview, download, export, import, and deletion workflows.

## 2. Storage Classes

Use explicit storage classes:

- public assets
- private files
- generated exports
- imports
- quarantine
- evidence

Only intentionally public assets may use public storage.

## 3. Upload Validation

Uploads must validate maximum size, expected MIME type, allowed extension, content signature where practical, filename safety, target scope, caller permission, expected count, and archive handling when applicable.

Do not trust the original filename, browser MIME value, or extension alone.

## 4. Storage

Untrusted and sensitive files must stay outside the public web root, receive server-generated names, use scoped storage paths, avoid executable permissions, use least-privilege filesystem access, and avoid predictable public URLs.

## 5. Scanning And Quarantine

High-risk file types or sources should support quarantine, malware scanning, processing only after acceptance, failure evidence, and retention limits.

Do not claim scanning when only extension validation exists.

## 6. Download Authorization

Every sensitive download must authenticate the actor, authorize the action and target, revalidate current scope, check file status, use a signed and expiring route when appropriate, use non-guessable identifiers, and audit sensitive access.

Possession of a URL does not grant access.

## 7. Generated Exports

Exports must require permission separate from ordinary view, evaluate classification and DLP policy, require reason or stronger assurance when policy requires, use private storage, expire, support revocation, reauthorize on download, and record request, approval, generation, download, expiration, and deletion.

## 8. Imports

Imports must validate structure and scope, limit rows and size, stage before destructive application, provide dry-run or preview where risk warrants, use transactions or resumable design, preserve safe evidence, and prevent formula or CSV injection in generated review artifacts.

## 9. Response Safety

Set safe content type and disposition.

Do not reflect untrusted filenames directly into headers.

Prevent path traversal and alternate stream interpretation.

## 10. Retention And Deletion

Files must have owner, purpose, classification, retention rule, deletion behavior, and legal-hold exception where applicable.

Deletion must not destroy required incident evidence.

## 11. Evidence

Evidence may include hashes, size, safe filename, storage reference, actor, target, classification, timestamps, and result.

Do not put raw restricted content into logs or tickets.

## 12. Tests

Verify invalid type and size denial, traversal denial, wrong-scope denial, private-path protection, signed-link expiration, revocation, download reauthorization, export permission separation, safe headers, and cleanup behavior.

## 13. Related

- [Data Protection And Data Loss Prevention Standards](Data%20Protection%20And%20Data%20Loss%20Prevention%20Standards.md)
- [Secure Coding And Request Handling Standards](Secure%20Coding%20And%20Request%20Handling%20Standards.md)
- [Digital Forensics Readiness And Evidence Handling Standards](Digital%20Forensics%20Readiness%20And%20Evidence%20Handling%20Standards.md)
