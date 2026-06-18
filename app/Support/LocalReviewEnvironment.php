<?php

namespace App\Support;

use App\Models\User;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\PermissionRegistrar;
use Throwable;

class LocalReviewEnvironment
{
    public const APP_URL = 'http://localhost:8000';
    public const EMAIL = 'test@example.com';
    public const HTTP_TIMEOUT_SECONDS = 10;
    public const PASSWORD = 'password';
    public const REVERB_PORT = '8080';
    public const REVERB_SCHEME = 'http';
    public const REVERB_SERVER_HOST = '0.0.0.0';
    public const REVERB_SERVER_PORT = '8080';
    public const ROLE = 'platform_super_admin';
    public const VITE_DOCKER_CHECK_URL = 'http://host.docker.internal:5173';
    public const VITE_URL = 'http://localhost:5173';

    /**
     * @return array{
     *     app_url: string,
     *     checks: list<array{name: string, status: string, message: string}>,
     *     email: string,
     *     env_path: string,
     *     hot_path: string,
     *     password: string,
     *     reverb_host: string,
     *     reverb_port: string,
     *     reverb_scheme: string,
     *     role: string,
     *     vite_check_url: string,
     *     vite_url: string
     * }
     */
    public function prepare(
        ?string $envPath = null,
        ?string $hotPath = null,
        ?string $viteUrl = null,
        ?string $viteCheckUrl = null,
        ?string $appUrl = null,
        ?string $reverbHost = null,
        bool $skipHttpChecks = false,
    ): array {
        $envPath ??= base_path('.env');
        $envValues = $this->readEnvValues($envPath);
        $appUrl = $this->normalizeUrl($appUrl ?: ($envValues['APP_URL'] ?? (string) config('app.url', self::APP_URL)));
        $viteUrl = $this->normalizeUrl($viteUrl ?: ($envValues['VITE_DEV_SERVER_URL'] ?? (string) env('VITE_DEV_SERVER_URL', self::VITE_URL)));
        $viteCheckUrl = $this->normalizeUrl($viteCheckUrl ?: $this->defaultViteCheckUrl($viteUrl));
        $reverbHost = $this->normalizeHost($reverbHost ?: parse_url($appUrl, PHP_URL_HOST) ?: 'localhost');
        $reverbPort = $envValues['REVERB_PORT'] ?? (string) env('REVERB_PORT', self::REVERB_PORT);
        $reverbScheme = $envValues['REVERB_SCHEME'] ?? (string) env('REVERB_SCHEME', self::REVERB_SCHEME);
        $hotPath ??= public_path('hot');

        $this->writeHotFile($hotPath, $viteUrl);
        $this->writeLocalRealtimeEnvironment($envPath, $reverbHost, $reverbPort, $reverbScheme);
        $this->upsertReviewUser();

        $checks = [
            [
                'name' => 'public/hot',
                'status' => 'ok',
                'message' => "{$hotPath} => {$viteUrl}",
            ],
            [
                'name' => 'reverb browser host',
                'status' => 'ok',
                'message' => "{$envPath} => {$reverbHost}:{$reverbPort} ({$reverbScheme})",
            ],
            [
                'name' => 'local review user',
                'status' => 'ok',
                'message' => self::EMAIL.' has '.self::ROLE,
            ],
        ];

        if ($skipHttpChecks) {
            $checks[] = [
                'name' => 'vite',
                'status' => 'skipped',
                'message' => "{$viteUrl}/resources/js/app.js was not checked.",
            ];
            $checks[] = [
                'name' => 'app',
                'status' => 'skipped',
                'message' => "{$appUrl}/login was not checked.",
            ];
        } else {
            $checks[] = $this->verifyViteAsset($viteCheckUrl, $viteUrl, 'resources/js/app.js', 'vite js');
            $checks[] = $this->verifyViteAsset($viteCheckUrl, $viteUrl, 'resources/css/app.css', 'vite css');
            $checks[] = $this->verifyReverb($reverbHost, $reverbPort);
            $checks[] = $this->verifyApp($appUrl);
        }

        return [
            'app_url' => $appUrl,
            'checks' => $checks,
            'email' => self::EMAIL,
            'env_path' => $envPath,
            'hot_path' => $hotPath,
            'password' => self::PASSWORD,
            'reverb_host' => $reverbHost,
            'reverb_port' => $reverbPort,
            'reverb_scheme' => $reverbScheme,
            'role' => self::ROLE,
            'vite_check_url' => $viteCheckUrl,
            'vite_url' => $viteUrl,
        ];
    }

    private function normalizeUrl(string $url): string
    {
        return rtrim($url, '/');
    }

    private function normalizeHost(string $host): string
    {
        return trim($host, " \t\n\r\0\x0B\"'");
    }

    private function defaultViteCheckUrl(string $viteUrl): string
    {
        if ($viteUrl === self::VITE_URL && File::exists('/.dockerenv')) {
            return self::VITE_DOCKER_CHECK_URL;
        }

        return $viteUrl;
    }

    private function writeHotFile(string $hotPath, string $viteUrl): void
    {
        File::ensureDirectoryExists(dirname($hotPath));

        try {
            File::put($hotPath, $viteUrl);

            return;
        } catch (Throwable $exception) {
            if (File::exists($hotPath) && @unlink($hotPath)) {
                File::put($hotPath, $viteUrl);

                return;
            }

            throw $exception;
        }
    }

    private function writeLocalRealtimeEnvironment(string $envPath, string $reverbHost, string $reverbPort, string $reverbScheme): void
    {
        if (! File::exists($envPath)) {
            return;
        }

        $env = File::get($envPath);
        $env = $this->upsertEnvValue($env, 'BROADCAST_CONNECTION', 'reverb');
        $env = $this->upsertEnvValue($env, 'REVERB_SERVER_HOST', self::REVERB_SERVER_HOST);
        $env = $this->upsertEnvValue($env, 'REVERB_SERVER_PORT', self::REVERB_SERVER_PORT);
        $env = $this->upsertEnvValue($env, 'REVERB_HOST', $reverbHost);
        $env = $this->upsertEnvValue($env, 'REVERB_PORT', $reverbPort);
        $env = $this->upsertEnvValue($env, 'REVERB_SCHEME', $reverbScheme);
        $env = $this->upsertEnvValue($env, 'VITE_REVERB_HOST', '${REVERB_HOST}');
        $env = $this->upsertEnvValue($env, 'VITE_REVERB_PORT', '${REVERB_PORT}');
        $env = $this->upsertEnvValue($env, 'VITE_REVERB_SCHEME', '${REVERB_SCHEME}');

        File::put($envPath, $env);
    }

    /**
     * @return array<string, string>
     */
    private function readEnvValues(string $envPath): array
    {
        if (! File::exists($envPath)) {
            return [];
        }

        $values = [];

        foreach (preg_split('/\R/', File::get($envPath)) ?: [] as $line) {
            if ($line === '' || str_starts_with(ltrim($line), '#') || ! str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $values[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
        }

        return $values;
    }

    private function upsertEnvValue(string $env, string $key, string $value): string
    {
        $line = "{$key}=".$this->formatEnvValue($value);

        if (preg_match("/^{$key}=.*$/m", $env) === 1) {
            return preg_replace("/^{$key}=.*$/m", $line, $env) ?? $env;
        }

        return rtrim($env).PHP_EOL.$line.PHP_EOL;
    }

    private function formatEnvValue(string $value): string
    {
        if (str_starts_with($value, '${') && str_ends_with($value, '}')) {
            return $value;
        }

        if (preg_match('/^[A-Za-z0-9_.:-]+$/', $value) === 1) {
            return $value;
        }

        return '"'.str_replace('"', '\"', $value).'"';
    }

    private function upsertReviewUser(): User
    {
        app(PlatformRolesAndPermissionsSeeder::class)->run();

        $user = User::query()->updateOrCreate(
            ['email' => self::EMAIL],
            [
                'name' => 'Local Review User',
                'first_name' => 'Local',
                'last_name' => 'Review',
                'password' => self::PASSWORD,
                'is_active' => true,
            ],
        );

        $user->forceFill(['email_verified_at' => $user->email_verified_at ?? now()])->save();
        $user->syncRoles([self::ROLE]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return $user;
    }

    /**
     * @return array{name: string, status: string, message: string}
     */
    private function verifyViteAsset(string $viteCheckUrl, string $viteUrl, string $assetPath, string $name): array
    {
        $headers = [];

        if ($viteCheckUrl !== $viteUrl) {
            $host = parse_url($viteUrl, PHP_URL_HOST);
            $port = parse_url($viteUrl, PHP_URL_PORT);
            $headers['Host'] = $port ? "{$host}:{$port}" : $host;
        }

        return $this->verifyUrl(
            $name,
            "{$viteCheckUrl}/{$assetPath}",
            fn (int $status): bool => $status >= 200 && $status < 300,
            $headers,
        );
    }

    /**
     * @return array{name: string, status: string, message: string}
     */
    private function verifyApp(string $appUrl): array
    {
        return $this->verifyUrl(
            'app',
            "{$appUrl}/login",
            fn (int $status): bool => $status >= 200 && $status < 500,
        );
    }

    /**
     * @return array{name: string, status: string, message: string}
     */
    private function verifyReverb(string $reverbHost, string $reverbPort): array
    {
        $checkHost = File::exists('/.dockerenv') ? 'reverb' : $reverbHost;
        $port = (int) $reverbPort;

        try {
            $socket = @fsockopen($checkHost, $port, $errorCode, $errorMessage, self::HTTP_TIMEOUT_SECONDS);
        } catch (Throwable $exception) {
            $socket = false;
            $errorMessage = $exception->getMessage();
        }

        if (is_resource($socket)) {
            fclose($socket);

            return [
                'name' => 'reverb',
                'status' => 'ok',
                'message' => "{$checkHost}:{$port} accepted a TCP connection.",
            ];
        }

        return [
            'name' => 'reverb',
            'status' => 'failed',
            'message' => "{$checkHost}:{$port} did not accept a TCP connection: {$errorMessage}",
        ];
    }

    /**
     * @param callable(int): bool $acceptsStatus
     *
     * @return array{name: string, status: string, message: string}
     */
    private function verifyUrl(string $name, string $url, callable $acceptsStatus, array $headers = []): array
    {
        try {
            $response = Http::withHeaders($headers)->timeout(self::HTTP_TIMEOUT_SECONDS)->get($url);
            $status = $response->status();
        } catch (Throwable $exception) {
            return [
                'name' => $name,
                'status' => 'failed',
                'message' => "{$url} did not respond: {$exception->getMessage()}",
            ];
        }

        if ($acceptsStatus($status)) {
            return [
                'name' => $name,
                'status' => 'ok',
                'message' => "{$url} responded with HTTP {$status}.",
            ];
        }

        return [
            'name' => $name,
            'status' => 'failed',
            'message' => "{$url} responded with HTTP {$status}.",
        ];
    }
}
