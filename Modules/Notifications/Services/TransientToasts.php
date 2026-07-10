<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Services/TransientToasts.php
| Purpose: Creates non-persistent toast payloads for action feedback.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Services;

use Illuminate\Session\Store as SessionStore;
use InvalidArgumentException;

final class TransientToasts
{
    public const SESSION_KEY = 'notifications.transient_toasts';

    /**
     * @var list<string>
     */
    private const KINDS = ['success', 'warning', 'error', 'info'];

    public function __construct(
        private readonly SessionStore $session,
    ) {
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    public function success(string $title, ?string $subtitle = null, array $options = []): array
    {
        return $this->flash('success', $title, $subtitle, $options);
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    public function warning(string $title, ?string $subtitle = null, array $options = []): array
    {
        return $this->flash('warning', $title, $subtitle, $options);
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    public function error(string $title, ?string $subtitle = null, array $options = []): array
    {
        return $this->flash('error', $title, $subtitle, $options);
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    public function info(string $title, ?string $subtitle = null, array $options = []): array
    {
        return $this->flash('info', $title, $subtitle, $options);
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    public function flash(string $kind, string $title, ?string $subtitle = null, array $options = []): array
    {
        $payload = $this->payload($kind, $title, $subtitle, $options);
        $existing = $this->session->get(self::SESSION_KEY, []);
        $toasts = is_array($existing) ? array_values($existing) : [];
        $toasts[] = $payload;

        $this->session->flash(self::SESSION_KEY, $toasts);

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    public function payload(string $kind, string $title, ?string $subtitle = null, array $options = []): array
    {
        $resolvedKind = $this->kind($kind);

        return array_filter([
            'id' => $this->stringOption($options, 'id'),
            'kind' => $resolvedKind,
            'severity' => $resolvedKind,
            'title' => trim($title) !== '' ? $title : 'Notification',
            'body' => $subtitle,
            'subtitle' => $subtitle,
            'caption' => $this->stringOption($options, 'caption'),
            'close_label' => $this->stringOption($options, 'close_label'),
            'timeout' => $this->integerOption($options, 'timeout'),
        ], static fn (mixed $value): bool => $value !== null && $value !== '');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function sessionPayloads(): array
    {
        $payloads = $this->session->get(self::SESSION_KEY, []);

        if (! is_array($payloads)) {
            return [];
        }

        return collect($payloads)
            ->filter(fn (mixed $payload): bool => is_array($payload))
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    public static function kinds(): array
    {
        return self::KINDS;
    }

    private function kind(string $kind): string
    {
        $normalized = strtolower(trim($kind));

        if (! in_array($normalized, self::KINDS, true)) {
            throw new InvalidArgumentException("Transient toast kind [{$kind}] is not supported.");
        }

        return $normalized;
    }

    /**
     * @param  array<string, mixed>  $options
     */
    private function stringOption(array $options, string $key): ?string
    {
        $value = $options[$key] ?? null;

        return is_string($value) && trim($value) !== '' ? $value : null;
    }

    /**
     * @param  array<string, mixed>  $options
     */
    private function integerOption(array $options, string $key): ?int
    {
        $value = $options[$key] ?? null;

        return is_numeric($value) ? (int) $value : null;
    }
}
