<?php

namespace App\Http\Requests\Platform;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StorePlatformUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', Password::defaults()],
            'is_active' => ['nullable', 'boolean'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function validatedExceptRoles(): array
    {
        $validated = $this->validated();
        unset($validated['roles']);
        $validated['is_active'] = $this->boolean('is_active', true);

        return $validated;
    }

    /**
     * @return list<string>
     */
    public function validatedRoles(): array
    {
        return array_values($this->validated('roles', []));
    }
}
