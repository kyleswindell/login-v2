<?php

namespace App\Platform\Security;

use App\Models\SecurityRequirement;

class SecurityRequirementCatalog
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function groups(): array
    {
        return [
            [
                'slug' => 'asvs-baseline',
                'title' => 'ASVS baseline and evidence matrix',
                'summary' => 'Versioned ASVS adoption, applicability decisions, and release-scoped evidence tracking.',
                'asvs_family' => 'ASVS',
                'risk_level' => 'level_2',
                'sort_order' => 10,
                'requirements' => [
                    [
                        'slug' => 'asvs-evidence-matrix',
                        'title' => 'Create requirement-level ASVS evidence matrix',
                        'summary' => 'Map every applicable ASVS 5.0.0 Level 1 and Level 2 requirement to evidence, non-applicability, external control ownership, or accepted risk before external review.',
                        'asvs_refs' => ['ASVS 5.0.0 L1+L2'],
                        'canonical_docs' => [
                            ['label' => 'OWASP ASVS Level 2 Baseline', 'path' => 'docs/02-standards/security/OWASP ASVS Level 2 Baseline.md'],
                            ['label' => 'ASVS Level 2 Evidence Matrix', 'path' => 'docs/09-reference/security/asvs-level-2-evidence-matrix.md'],
                            ['label' => 'ASVS security review', 'path' => 'docs/11-ai/active-doc-reviews/doc-review-2026-07-01-asvs-level-2-security-baseline.md'],
                        ],
                        'alignment_status' => SecurityRequirement::ALIGNMENT_PARTIAL,
                        'work_status' => SecurityRequirement::WORK_PLANNED,
                        'priority' => 'critical',
                        'target_phase' => 'Security review readiness',
                    ],
                ],
            ],
            [
                'slug' => 'auth-mfa-assurance',
                'title' => 'Auth and MFA assurance',
                'summary' => 'Authentication, MFA, provider assurance, recovery, and privileged step-up behavior.',
                'asvs_family' => 'V6',
                'risk_level' => 'level_3_overlay',
                'sort_order' => 20,
                'requirements' => [
                    [
                        'slug' => 'auth-mfa-assurance-boundary',
                        'title' => 'Maintain explicit MFA assurance boundary',
                        'summary' => 'Track TOTP baseline coverage, recovery-code handling, step-up, provider assurance gaps, and high-risk phishing-resistant assurance decisions.',
                        'asvs_refs' => ['v5.0.0-V6', 'v5.0.0-V10'],
                        'canonical_docs' => [
                            ['label' => 'Identity And Account Security Standards', 'path' => 'docs/02-standards/security/Identity And Account Security Standards.md'],
                            ['label' => 'Authentication feature contract', 'path' => 'docs/04-features/auth/authentication.md'],
                            ['label' => 'MFA flow', 'path' => 'docs/05-flows/mfa-enrollment-and-challenge-flow.md'],
                            ['label' => 'MFA planning', 'path' => 'docs/07-planning/mfa-implementation-planning.md'],
                        ],
                        'alignment_status' => SecurityRequirement::ALIGNMENT_PARTIAL,
                        'work_status' => SecurityRequirement::WORK_IN_PROGRESS,
                        'priority' => 'critical',
                        'target_phase' => 'Phase 3 security carry-forward',
                    ],
                ],
            ],
            [
                'slug' => 'password-login-abuse',
                'title' => 'Password, login abuse, and suspicious auth',
                'summary' => 'Password controls, credential-stuffing defenses, account enumeration resistance, and suspicious-auth escalation.',
                'asvs_family' => 'V6',
                'risk_level' => 'level_2',
                'sort_order' => 30,
                'requirements' => [
                    [
                        'slug' => 'password-anti-automation-controls',
                        'title' => 'Add password and login anti-automation evidence',
                        'summary' => 'Track password policy evidence, breached-password checks, login throttling, generic failure behavior, and audit-only suspicious-auth telemetry.',
                        'asvs_refs' => [
                            'v5.0.0-2.4.1',
                            'v5.0.0-6.1.1',
                            'v5.0.0-6.2.1',
                            'v5.0.0-6.2.4',
                            'v5.0.0-6.2.9',
                            'v5.0.0-6.2.11',
                            'v5.0.0-6.2.12',
                            'v5.0.0-6.3.1',
                            'v5.0.0-16.3.1',
                        ],
                        'canonical_docs' => [
                            ['label' => 'Identity And Account Security Standards', 'path' => 'docs/02-standards/security/Identity And Account Security Standards.md'],
                            ['label' => 'Logging Standards', 'path' => 'docs/02-standards/logging/Logging Standards.md'],
                            ['label' => 'Authentication feature contract', 'path' => 'docs/04-features/auth/authentication.md'],
                            ['label' => 'Login Authentication Flow', 'path' => 'docs/05-flows/login-authentication-flow.md'],
                            ['label' => 'ASVS Level 2 Evidence Matrix', 'path' => 'docs/09-reference/security/asvs-level-2-evidence-matrix.md'],
                            ['label' => 'Security posture review', 'path' => 'docs/11-ai/active-doc-reviews/doc-review-0032.md'],
                        ],
                        'alignment_status' => SecurityRequirement::ALIGNMENT_PARTIAL,
                        'work_status' => SecurityRequirement::WORK_IN_PROGRESS,
                        'priority' => 'critical',
                        'target_phase' => 'Phase 3 security carry-forward',
                    ],
                ],
            ],
            [
                'slug' => 'authorization-tenancy',
                'title' => 'Authorization, RBAC, and tenant isolation',
                'summary' => 'Controller authorization, route/action permission-gate evidence, super-admin role escalation controls, future role policy refinement, tenant boundary behavior, and cross-tenant access controls.',
                'asvs_family' => 'V8',
                'risk_level' => 'level_3_overlay',
                'sort_order' => 40,
                'requirements' => [
                    [
                        'slug' => 'authorization-tenant-boundary-evidence',
                        'title' => 'Build authorization and tenant-boundary evidence',
                        'summary' => 'Track route/action permission-gate tests, super-admin role assignment protections, future role policy refinement, tenant isolation evidence, and cross-tenant access prevention.',
                        'asvs_refs' => ['v5.0.0-V8', 'v5.0.0-V14'],
                        'canonical_docs' => [
                            ['label' => 'Security Standards', 'path' => 'docs/02-standards/security/Security Standards.md'],
                            ['label' => 'Tenant Safety Standards', 'path' => 'docs/02-standards/security/Tenant Safety Standards.md'],
                            ['label' => 'Platform users and RBAC', 'path' => 'docs/04-features/users/platform-users-and-rbac.md'],
                            ['label' => 'ASVS Level 2 Evidence Matrix', 'path' => 'docs/09-reference/security/asvs-level-2-evidence-matrix.md'],
                        ],
                        'alignment_status' => SecurityRequirement::ALIGNMENT_PARTIAL,
                        'work_status' => SecurityRequirement::WORK_IN_PROGRESS,
                        'priority' => 'high',
                        'target_phase' => 'Phase 3 security carry-forward',
                    ],
                ],
            ],
            [
                'slug' => 'file-api-token-oauth',
                'title' => 'File, API, token, and OAuth coverage',
                'summary' => 'Applicability and evidence for file handling, APIs, self-contained tokens, OAuth/OIDC, and WebRTC non-applicability.',
                'asvs_family' => 'V4/V5/V9/V10/V17',
                'risk_level' => 'level_2',
                'sort_order' => 50,
                'requirements' => [
                    [
                        'slug' => 'file-api-token-oauth-applicability',
                        'title' => 'Document file/API/token/OAuth applicability',
                        'summary' => 'Track exposed capabilities, not-applicable decisions, and implementation evidence for file handling, API/web-service behavior, self-contained tokens, OAuth/OIDC, and WebRTC.',
                        'asvs_refs' => ['v5.0.0-V4', 'v5.0.0-V5', 'v5.0.0-V9', 'v5.0.0-V10', 'v5.0.0-V17'],
                        'canonical_docs' => [
                            ['label' => 'OWASP ASVS Level 2 Baseline', 'path' => 'docs/02-standards/security/OWASP ASVS Level 2 Baseline.md'],
                            ['label' => 'Customer access and OAuth flow', 'path' => 'docs/05-flows/customer-access-and-oauth-flow.md'],
                        ],
                        'alignment_status' => SecurityRequirement::ALIGNMENT_LACKING,
                        'work_status' => SecurityRequirement::WORK_PLANNED,
                        'priority' => 'high',
                        'target_phase' => 'Phase 3 security carry-forward',
                    ],
                ],
            ],
            [
                'slug' => 'secrets-crypto-data',
                'title' => 'Secrets, cryptography, and data protection',
                'summary' => 'Production secret storage, encryption expectations, credential rotation, and sensitive data handling.',
                'asvs_family' => 'V11/V14',
                'risk_level' => 'level_3_overlay',
                'sort_order' => 60,
                'requirements' => [
                    [
                        'slug' => 'secret-backed-settings-and-data-protection',
                        'title' => 'Implement secret-backed settings and data-protection evidence',
                        'summary' => 'Track production secret-management path, credential rotation, encrypted secret storage, and sensitive data handling evidence.',
                        'asvs_refs' => ['v5.0.0-V11', 'v5.0.0-V14'],
                        'canonical_docs' => [
                            ['label' => 'Identity And Account Security Standards', 'path' => 'docs/02-standards/security/Identity And Account Security Standards.md'],
                            ['label' => 'Security posture review', 'path' => 'docs/11-ai/active-doc-reviews/doc-review-0032.md'],
                        ],
                        'alignment_status' => SecurityRequirement::ALIGNMENT_PARTIAL,
                        'work_status' => SecurityRequirement::WORK_PLANNED,
                        'priority' => 'critical',
                        'target_phase' => 'Phase 3 prerequisite',
                    ],
                ],
            ],
            [
                'slug' => 'transport-session-browser-runtime',
                'title' => 'Transport, session, browser, and runtime hardening',
                'summary' => 'HTTPS, secure cookies, explicit TLS termination mode, trusted proxies, database transport, security-header baseline, HSTS gating, and production runtime posture.',
                'asvs_family' => 'V3/V7/V12/V13',
                'risk_level' => 'level_2',
                'sort_order' => 70,
                'requirements' => [
                    [
                        'slug' => 'transport-session-browser-hardening',
                        'title' => 'Validate transport/session/browser hardening',
                        'summary' => 'Track the implemented platform header middleware, runtime readiness command, HTML-only frame-ancestor CSP, opt-in HTTPS HSTS, secure/encrypted production session expectations, explicit proxy trust, database TLS, and production debug posture.',
                        'asvs_refs' => ['v5.0.0-V3', 'v5.0.0-V7', 'v5.0.0-V12', 'v5.0.0-V13'],
                        'canonical_docs' => [
                            ['label' => 'Transport Session And Browser Security Standards', 'path' => 'docs/02-standards/security/Transport Session And Browser Security Standards.md'],
                            ['label' => 'Platform Production Server Policy', 'path' => 'docs/02-standards/security/platform-production-server-policy.md'],
                            ['label' => 'Deployment runbook', 'path' => 'docs/10-runbooks/deployment.md'],
                            ['label' => 'Server Readiness runbook', 'path' => 'docs/10-runbooks/server-readiness.md'],
                            ['label' => 'ASVS Level 2 Evidence Matrix', 'path' => 'docs/09-reference/security/asvs-level-2-evidence-matrix.md'],
                        ],
                        'alignment_status' => SecurityRequirement::ALIGNMENT_PARTIAL,
                        'work_status' => SecurityRequirement::WORK_IMPLEMENTED_PENDING_REVIEW,
                        'priority' => 'high',
                        'target_phase' => 'Deployment hardening',
                    ],
                ],
            ],
            [
                'slug' => 'logging-error-audit',
                'title' => 'Logging, error handling, and audit evidence',
                'summary' => 'Security event coverage, safe metadata, request correlation, and error exposure controls.',
                'asvs_family' => 'V16',
                'risk_level' => 'level_2',
                'sort_order' => 80,
                'requirements' => [
                    [
                        'slug' => 'security-logging-error-evidence',
                        'title' => 'Complete security logging and error evidence',
                        'summary' => 'Track required auth, MFA, abuse-defense, identity-linking, policy-change, error-handling, and correlation evidence without exposing secrets.',
                        'asvs_refs' => ['v5.0.0-V16'],
                        'canonical_docs' => [
                            ['label' => 'Logging Standards', 'path' => 'docs/02-standards/logging/Logging Standards.md'],
                            ['label' => 'Event and error logging feature', 'path' => 'docs/04-features/logging/event-and-error-logging.md'],
                        ],
                        'alignment_status' => SecurityRequirement::ALIGNMENT_PARTIAL,
                        'work_status' => SecurityRequirement::WORK_IN_PROGRESS,
                        'priority' => 'high',
                        'target_phase' => 'Security review readiness',
                    ],
                ],
            ],
            [
                'slug' => 'secure-delivery-release-gates',
                'title' => 'Secure delivery and release gates',
                'summary' => 'Dependency checks, secret scanning, authenticated testing, release evidence, and penetration-test preparation.',
                'asvs_family' => 'V13/V15',
                'risk_level' => 'level_2',
                'sort_order' => 90,
                'requirements' => [
                    [
                        'slug' => 'release-gate-security-verification',
                        'title' => 'Create release-gate security verification package',
                        'summary' => 'Track SCA, secret scanning, authenticated DAST or manual verification, seeded review accounts, tenant-boundary test data, and production-hardening checks.',
                        'asvs_refs' => ['v5.0.0-V13', 'v5.0.0-V15'],
                        'canonical_docs' => [
                            ['label' => 'Application Security Verification And Secure Delivery Standards', 'path' => 'docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md'],
                            ['label' => 'ASVS security review', 'path' => 'docs/11-ai/active-doc-reviews/doc-review-2026-07-01-asvs-level-2-security-baseline.md'],
                        ],
                        'alignment_status' => SecurityRequirement::ALIGNMENT_LACKING,
                        'work_status' => SecurityRequirement::WORK_PLANNED,
                        'priority' => 'critical',
                        'target_phase' => 'Security review readiness',
                    ],
                ],
            ],
        ];
    }
}
