<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Login/ProgressiveLoginSession.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Login;

use Illuminate\Http\Request;

class ProgressiveLoginSession
{
    public const SESSION_KEY = 'auth.progressive_login';

    public const REMEMBERED_IDENTIFIER_COOKIE = 'auth_remembered_identifier';

    public const REMEMBERED_IDENTIFIER_MINUTES = 60 * 24 * 30;

    /**
     * @return array{identifier: string, timezone: string|null, intended_url: string|null, remember_identifier: bool}|null
     */
    public function state(Request $request): ?array
    {
        $state = $request->session()->get(self::SESSION_KEY);

        if (! is_array($state) || ! isset($state['identifier']) || ! is_string($state['identifier'])) {
            $this->clear($request);

            return null;
        }

        $identifier = trim($state['identifier']);

        if ($identifier === '') {
            $this->clear($request);

            return null;
        }

        return [
            'identifier' => $identifier,
            'timezone' => isset($state['timezone']) && is_string($state['timezone']) && $state['timezone'] !== ''
                ? $state['timezone']
                : null,
            'intended_url' => isset($state['intended_url']) && is_string($state['intended_url']) && $state['intended_url'] !== ''
                ? $state['intended_url']
                : null,
            'remember_identifier' => (bool) ($state['remember_identifier'] ?? false),
        ];
    }

    public function store(Request $request, string $identifier, ?string $timezone, bool $rememberIdentifier): void
    {
        $request->session()->put(self::SESSION_KEY, [
            'identifier' => trim($identifier),
            'timezone' => filled($timezone) ? $timezone : null,
            'intended_url' => $request->session()->get('url.intended'),
            'remember_identifier' => $rememberIdentifier,
        ]);
    }

    public function clear(Request $request): void
    {
        $request->session()->forget(self::SESSION_KEY);
    }

    public function rememberedIdentifier(Request $request): string
    {
        $identifier = $request->cookie(self::REMEMBERED_IDENTIFIER_COOKIE);

        return is_string($identifier) ? substr($identifier, 0, 255) : '';
    }
}
