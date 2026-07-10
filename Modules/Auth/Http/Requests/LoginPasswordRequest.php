<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Http/Requests/LoginPasswordRequest.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginPasswordRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string'],
            'timezone' => ['nullable', 'timezone'],
        ];
    }
}
