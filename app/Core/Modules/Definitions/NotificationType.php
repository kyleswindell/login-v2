<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/Definitions/NotificationType.php
| Purpose: Defines structured module-owned notification type metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Core\Modules\Definitions;

use InvalidArgumentException;

final class NotificationType
{
    public const SEVERITY_INFO = 'info';
    public const SEVERITY_NOTICE = 'notice';
    public const SEVERITY_SUCCESS = 'success';
    public const SEVERITY_WARNING = 'warning';
    public const SEVERITY_ERROR = 'error';
    public const SEVERITY_URGENT = 'urgent';

    private const VALID_SEVERITIES = [
        self::SEVERITY_INFO,
        self::SEVERITY_NOTICE,
        self::SEVERITY_SUCCESS,
        self::SEVERITY_WARNING,
        self::SEVERITY_ERROR,
        self::SEVERITY_URGENT,
    ];

    public function __construct(
        public readonly string $key,
        public readonly string $label,
        public readonly string $description,
        public readonly string $category,
        public readonly string $defaultSeverity = self::SEVERITY_INFO,
        public readonly bool $database = true,
        public readonly bool $emailEligible = false,
        public readonly bool $digestEligible = false,
        public readonly NotificationAudience $audience = NotificationAudience::ExplicitRecipient,
        public readonly ?string $actionRoute = null,
        public readonly ?string $groupKey = null,
        public readonly ?string $dedupeKey = null,
    ) {
        foreach (['key' => $key, 'label' => $label, 'description' => $description, 'category' => $category] as $field => $value) {
            if ($value === '' || $value !== trim($value)) {
                throw new InvalidArgumentException("Notification type field [{$field}] must be a non-empty trimmed string.");
            }
        }

        if (! preg_match('/\A[a-z][a-z0-9_-]*(?:\.[a-z][a-z0-9_-]*)+\z/', $key)) {
            throw new InvalidArgumentException("Notification type key [{$key}] must be dot-delimited and module-owned.");
        }

        if (! preg_match('/\A[a-z][a-z0-9_-]*\z/', $category)) {
            throw new InvalidArgumentException("Notification type [{$key}] has invalid category [{$category}].");
        }

        if (! in_array($defaultSeverity, self::VALID_SEVERITIES, true)) {
            throw new InvalidArgumentException("Notification type [{$key}] has invalid default severity [{$defaultSeverity}].");
        }

        foreach (['actionRoute' => $actionRoute, 'groupKey' => $groupKey, 'dedupeKey' => $dedupeKey] as $field => $value) {
            if ($value !== null && ($value === '' || $value !== trim($value) || str_contains($value, ' '))) {
                throw new InvalidArgumentException("Notification type [{$key}] has invalid [{$field}].");
            }
        }
    }

    public function moduleKey(): string
    {
        return str($this->key)->before('.')->toString();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'label' => $this->label,
            'description' => $this->description,
            'category' => $this->category,
            'default_severity' => $this->defaultSeverity,
            'database' => $this->database,
            'email_eligible' => $this->emailEligible,
            'digest_eligible' => $this->digestEligible,
            'audience' => $this->audience->value,
            'action_route' => $this->actionRoute,
            'group_key' => $this->groupKey,
            'dedupe_key' => $this->dedupeKey,
        ];
    }
}
