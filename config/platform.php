<?php

return [
    'security' => [
        'runtime' => [
            'tls_termination' => env('PLATFORM_TLS_TERMINATION', 'direct'),
            'trusted_proxies' => env('PLATFORM_TRUSTED_PROXIES', ''),
            'expect_https' => (bool) env('PLATFORM_EXPECT_HTTPS', false),
        ],

        'headers' => [
            'enabled' => (bool) env('PLATFORM_SECURITY_HEADERS_ENABLED', true),
            'hsts_enabled' => (bool) env('PLATFORM_HSTS_ENABLED', false),
            'defaults' => [
                'X-Content-Type-Options' => 'nosniff',
                'Referrer-Policy' => 'strict-origin-when-cross-origin',
                'X-Frame-Options' => 'DENY',
                'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), payment=(), usb=()',
            ],
            'content_security_policy' => "frame-ancestors 'none'",
            'strict_transport_security' => 'max-age=31536000; includeSubDomains',
        ],

        'suspicious_auth' => [
            'enabled' => env('PLATFORM_SUSPICIOUS_AUTH_ENABLED', true),
            'mode' => env('PLATFORM_SUSPICIOUS_AUTH_MODE', 'audit_only'),
            'signals' => [
                'login_throttle_repeated' => [
                    'enabled' => true,
                    'threshold' => 2,
                    'window_minutes' => 30,
                    'dedupe_minutes' => 30,
                    'recommended_response' => 'review_login_abuse',
                ],
                'password_spray_ip' => [
                    'enabled' => true,
                    'threshold' => 10,
                    'distinct_identifier_threshold' => 5,
                    'window_minutes' => 30,
                    'dedupe_minutes' => 30,
                    'recommended_response' => 'review_password_spray',
                ],
                'inactive_user_probe' => [
                    'enabled' => true,
                    'threshold' => 3,
                    'window_minutes' => 30,
                    'dedupe_minutes' => 30,
                    'recommended_response' => 'review_disabled_account_access',
                ],
                'mfa_rate_limit_repeated' => [
                    'enabled' => true,
                    'threshold' => 2,
                    'window_minutes' => 30,
                    'dedupe_minutes' => 30,
                    'recommended_response' => 'review_mfa_compromise_risk',
                ],
                'breached_password_repeated' => [
                    'enabled' => true,
                    'threshold' => 3,
                    'window_minutes' => 1440,
                    'dedupe_minutes' => 1440,
                    'recommended_response' => 'review_password_policy_training',
                ],
            ],
        ],

        'passwords' => [
            'breached' => [
                'mode' => env('PLATFORM_BREACHED_PASSWORD_MODE', 'disabled'),
                'provider' => env('PLATFORM_BREACHED_PASSWORD_PROVIDER', 'hibp'),
                'fail_closed' => (bool) env('PLATFORM_BREACHED_PASSWORD_FAIL_CLOSED', true),
                'hibp' => [
                    'endpoint' => env('PLATFORM_HIBP_PASSWORDS_ENDPOINT', 'https://api.pwnedpasswords.com/range'),
                    'timeout_seconds' => (int) env('PLATFORM_HIBP_PASSWORDS_TIMEOUT_SECONDS', 5),
                    'cache_ttl_seconds' => (int) env('PLATFORM_HIBP_PASSWORDS_CACHE_TTL_SECONDS', 86400),
                ],
            ],
        ],
    ],

    'active_batch_review' => [
        'active_batch_review_source_path' => base_path('docs/08-active/change-queue.md'),
        'active_batch_review_manifest_path' => storage_path('framework/cache/data/active-batch-review-manifest.json'),
    ],
];
