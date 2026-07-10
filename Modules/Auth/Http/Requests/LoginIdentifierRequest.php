<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Http/Requests/LoginIdentifierRequest.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginIdentifierRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string', 'max:255'],
            'remember_identifier' => ['nullable', 'boolean'],
            'timezone' => ['nullable', 'timezone'],
        ];
    }
}
