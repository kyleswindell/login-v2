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
    public const ROLE = 'platform_super_admin';
    public const VITE_DOCKER_CHECK_URL = 'http://host.docker.internal:5173';
    public const VITE_URL = 'http://localhost:5173';

    /**
     * @return array{
     *     app_url: string,
     *     checks: list<array{name: string, status: string, message: string}>,
     *     email: string,
     *     hot_path: string,
     *     password: string,
     *     role: string,
     *     vite_check_url: string,
     *     vite_url: string
     * }
     */
    public function prepare(
        ?string $hotPath = null,
        string $viteUrl = self::VITE_URL,
        ?string $viteCheckUrl = null,
        string $appUrl = self::APP_URL,
        bool $skipHttpChecks = false,
    ): array {
        $viteUrl = $this->normalizeUrl($viteUrl);
        $viteCheckUrl = $this->normalizeUrl($viteCheckUrl ?: $this->defaultViteCheckUrl($viteUrl));
        $appUrl = $this->normalizeUrl($appUrl);
        $hotPath ??= public_path('hot');

        $this->writeHotFile($hotPath, $viteUrl);
        $this->upsertReviewUser();

        $checks = [
            [
                'name' => 'public/hot',
                'status' => 'ok',
                'message' => "{$hotPath} => {$viteUrl}",
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
            $checks[] = $this->verifyApp($appUrl);
        }

        return [
            'app_url' => $appUrl,
            'checks' => $checks,
            'email' => self::EMAIL,
            'hot_path' => $hotPath,
            'password' => self::PASSWORD,
            'role' => self::ROLE,
            'vite_check_url' => $viteCheckUrl,
            'vite_url' => $viteUrl,
        ];
    }

    private function normalizeUrl(string $url): string
    {
        return rtrim($url, '/');
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
