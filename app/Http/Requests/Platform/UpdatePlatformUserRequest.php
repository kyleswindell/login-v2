<?php

namespace App\Http\Requests\Platform;

use App\Support\InternalPhoneFormatter;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdatePlatformUserRequest extends FormRequest
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
        /** @var User $user */
        $user = $this->route('user');

        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', Password::defaults()],
            'hourly_rate' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'phone' => ['nullable', 'string', 'max:50'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'skype' => ['nullable', 'string', 'max:255'],
            'default_language' => ['nullable', 'string', 'max:10'],
            'email_signature' => ['nullable', 'string', 'max:5000'],
            'direction' => ['nullable', 'in:ltr,rtl'],
            'send_welcome_email' => ['nullable', 'boolean'],
            'is_administrator' => ['nullable', 'boolean'],
            'is_staff_member' => ['nullable', 'boolean'],
            'not_staff_member' => ['nullable', 'boolean'],
            'profile_image' => ['nullable', 'image', 'max:5120'],
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
        /** @var User $user */
        $user = $this->route('user');

        $validated = $this->validated();
        unset($validated['roles']);
        unset($validated['password']);
        unset($validated['profile_image']);
        unset($validated['not_staff_member']);
        $validated['name'] = trim(($validated['first_name'] ?? '').' '.($validated['last_name'] ?? ''));
        $validated['hourly_rate'] = (float) ($validated['hourly_rate'] ?? 0);
        $validated['phone'] = InternalPhoneFormatter::normalize($validated['phone'] ?? null);
        $validated['direction'] = $validated['direction'] ?? 'ltr';
        $validated['send_welcome_email'] = $this->boolean('send_welcome_email');
        $validated['is_administrator'] = $this->boolean('is_administrator');
        $validated['is_staff_member'] = ! $this->boolean('not_staff_member');

        // Keep current activation state when the checkbox is omitted.
        if ($this->has('is_active')) {
            $validated['is_active'] = $this->boolean('is_active');
        } else {
            $validated['is_active'] = $user->is_active;
        }

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
