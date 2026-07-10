<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Http/Requests/LoginRequest.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
            'timezone' => ['nullable', 'timezone'],
        ];
    }
}
