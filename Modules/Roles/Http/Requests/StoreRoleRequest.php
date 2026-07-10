<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Requests/StoreRoleRequest.php
| Purpose: Validates custom role creation requests.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Requests;

use App\Modules\Roles\Services\MutationGuard;
use App\Modules\Roles\Services\PermissionCatalog;
use App\Modules\Roles\Services\RoleCatalog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return app(MutationGuard::class)->canCreateWithPermissions($this->user(), $this->submittedPermissionKeys());
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $roles = app(RoleCatalog::class);

        return [
            'key' => [
                'required',
                'string',
                'regex:/\A[a-z][a-z0-9_]{2,63}\z/',
                'not_regex:/\Aplatform_/',
                Rule::notIn([...$roles->keys(), ...array_keys($roles->legacyMap())]),
                Rule::unique('roles', 'name')->where('guard_name', 'web'),
            ],
            'label' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(app(PermissionCatalog::class)->all())],
        ];
    }

    public function roleKey(): string
    {
        return (string) $this->validated('key');
    }

    public function roleLabel(): string
    {
        return (string) $this->validated('label');
    }

    public function roleDescription(): ?string
    {
        $description = $this->validated('description');

        return is_string($description) && filled($description)
            ? $description
            : null;
    }

    /**
     * @return list<string>
     */
    public function permissionKeys(): array
    {
        return $this->submittedPermissionKeys();
    }

    /**
     * @return list<string>
     */
    private function submittedPermissionKeys(): array
    {
        $permissions = $this->input('permissions', []);

        if (! is_array($permissions)) {
            return [];
        }

        return collect($permissions)
            ->filter(fn (mixed $permission): bool => is_string($permission))
            ->map(fn (string $permission): string => trim($permission))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
