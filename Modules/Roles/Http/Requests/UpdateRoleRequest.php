<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Requests/UpdateRoleRequest.php
| Purpose: Validates role metadata and permission update requests.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Requests;

use App\Modules\Roles\Services\MutationGuard;
use App\Modules\Roles\Services\PermissionCatalog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

final class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        $role = $this->role();

        return $role instanceof Role
            && app(MutationGuard::class)->canSubmitPermissionsForRole($this->user(), $role, $this->submittedPermissionKeys());
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'key' => ['prohibited'],
            'name' => ['prohibited'],
            'label' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(app(PermissionCatalog::class)->all())],
        ];
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
        $role = $this->role();
        $permissions = $this->submittedPermissionKeys();

        if (! $role instanceof Role) {
            return $permissions;
        }

        return app(MutationGuard::class)->preservedElevatedPermissions($this->user(), $role, $permissions);
    }

    private function role(): ?Role
    {
        $role = $this->route('role');

        return $role instanceof Role ? $role : null;
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
