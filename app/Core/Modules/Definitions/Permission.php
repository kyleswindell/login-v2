<?php
/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/Definitions/Permission.php
| Purpose: Defines structured module-owned permission metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Core\Modules\Definitions;

use InvalidArgumentException;

final class Permission
{
    public const ACTION_VIEW = 'view';
    public const ACTION_CREATE = 'create';
    public const ACTION_UPDATE = 'update';
    public const ACTION_DELETE = 'delete';
    public const ACTION_MANAGE = 'manage';

    private const VALID_DEFAULT_ROLES = [
        'super_admin',
        'admin',
        'manager',
        'user',
        'default',
    ];

    /**
     * @param  list<string>  $defaultRoles
     */
    public function __construct(
        public readonly string $key,
        public readonly string $label,
        public readonly string $description,
        public readonly string $groupKey,
        public readonly string $groupLabel,
        public readonly bool $elevated = false,
        public readonly array $defaultRoles = ['super_admin', 'admin'],
        public readonly ?string $action = null,
        public readonly bool $destructive = false,
    ) {
        foreach (['key' => $key, 'label' => $label, 'description' => $description, 'groupKey' => $groupKey, 'groupLabel' => $groupLabel] as $field => $value) {
            if ($value === '' || $value !== trim($value)) {
                throw new InvalidArgumentException("Permission definition field [{$field}] must be a non-empty trimmed string.");
            }
        }

        if (str_contains($key, ' ')) {
            throw new InvalidArgumentException("Permission definition key [{$key}] must not contain spaces.");
        }

        foreach ($defaultRoles as $role) {
            if (! in_array($role, self::VALID_DEFAULT_ROLES, true)) {
                throw new InvalidArgumentException("Permission definition [{$key}] references unsupported default role [{$role}].");
            }
        }

        if ($action !== null && ! preg_match('/\A[a-z][a-z0-9_-]*\z/', $action)) {
            throw new InvalidArgumentException("Permission definition [{$key}] has invalid action [{$action}].");
        }
    }

    public function action(): string
    {
        return $this->action
            ?? str($this->key)->afterLast('.')->toString();
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
            'group_key' => $this->groupKey,
            'group_label' => $this->groupLabel,
            'elevated' => $this->elevated,
            'default_roles' => $this->defaultRoles,
            'action' => $this->action(),
            'destructive' => $this->destructive,
        ];
    }
}
