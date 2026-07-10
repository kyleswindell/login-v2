<!--
DOC-META
title: Transport Session And Browser Security Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Transport Session And Browser Security Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines HTTPS, trusted-proxy, session, cookie, browser-header, CSP, service-transport, and runtime-exposure requirements.
-->

# Transport Session And Browser Security Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. HTTPS](#2-https)
- [3. Trusted Proxies](#3-trusted-proxies)
- [4. Sessions](#4-sessions)
- [5. Cookies](#5-cookies)
- [6. Browser Headers](#6-browser-headers)
- [7. CSP](#7-csp)
- [8. Service Transport](#8-service-transport)
- [9. Runtime Exposure](#9-runtime-exposure)
- [10. Runtime Verification](#10-runtime-verification)
- [11. Verification](#11-verification)
- [12. Related](#12-related)

## 1. Purpose

Define runtime hardening for transport, trusted proxies, sessions, cookies, browser responses, service communication, and deployed exposure.

## 2. HTTPS

Authenticated staging and production traffic must use HTTPS.

Production must fail safely when required transport protections are absent.

HSTS may be enabled only after confirming HTTPS coverage for every included host.

## 3. Trusted Proxies

Trusted proxy behavior must:

- match the deployed topology
- trust exact approved IP or CIDR entries
- reject wildcard or all-network trust
- preserve correct scheme, host, and client-address interpretation
- be verified from the deployed environment

Use `PLATFORM_TLS_TERMINATION=direct` for direct TLS, `PLATFORM_TLS_TERMINATION=trusted_proxy` for approved proxy termination, explicit `PLATFORM_TRUSTED_PROXIES`, and `PLATFORM_EXPECT_HTTPS=true` on staging and production.

## 4. Sessions

Authenticated session controls must include:

- identifier regeneration after login
- regeneration after privilege elevation
- invalidation on logout
- invalidation for suspension or deactivation
- defined invalidation after forced password or MFA reset
- bounded lifetime
- privilege-sensitive remember behavior
- separate login-time MFA and recent-auth timestamps
- short-lived elevated-access state

Session data containing privileged context should use encrypted storage when supported.

## 5. Cookies

Production authenticated cookies must be Secure, HttpOnly, intentionally configured for SameSite, narrowly scoped by domain and path, and protected from insecure local defaults.

Expected production values include `SESSION_SECURE_COOKIE=true`, `SESSION_ENCRYPT=true`, and `SESSION_SAME_SITE=lax` unless a documented integration requires another value.

## 6. Browser Headers

The baseline must include:

- `X-Content-Type-Options: nosniff`
- `Referrer-Policy: strict-origin-when-cross-origin`
- frame protection through CSP `frame-ancestors` and/or `X-Frame-Options`
- a deliberate Permissions Policy
- HSTS when confirmed safe
- a tested Content Security Policy

Do not broaden CSP without testing Blade, Livewire, Vite assets, dialogs, realtime connections, and approved integrations.

## 7. CSP

New code should avoid inline scripts and styles where practical.

CSP changes must be route tested, build tested, browser reviewed, compatible with approved third parties, and documented with required origins and directives.

## 8. Service Transport

Database, cache, queue, realtime, mail, and integration traffic crossing a host or trust boundary must use approved encrypted and authenticated transport.

Internal network location alone is not trust.

## 9. Runtime Exposure

Production must disable debug output, suppress stack traces from users, avoid diagnostic headers, avoid local test accounts and shortcuts, verify HTTPS and headers from the deployed URL, restrict infrastructure ports, and protect log and storage paths from web access.

## 10. Runtime Verification

Deployment review must use the current runtime security checker where available.

Checker output supports configuration evidence but does not replace certificate review, proxy review, firewall review, cookie inspection, server review, or penetration testing.

## 11. Verification

Tests and deployment checks must cover secure-request detection, proxy trust boundaries, session regeneration, logout invalidation, recent-auth expiration, secure-cookie posture, header coverage, CSP behavior, and debug-disabled behavior.

## 12. Related

- [Identity And Account Security Standards](Identity%20And%20Account%20Security%20Standards.md)
- [Deployment Environment And Infrastructure Security Standards](Deployment%20Environment%20And%20Infrastructure%20Security%20Standards.md)
- [Application Security Verification And Secure Delivery Standards](Application%20Security%20Verification%20And%20Secure%20Delivery%20Standards.md)
