<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SafeEvidenceLinkUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $url = trim((string) $value);

        if ($url === '') {
            return;
        }

        if ($this->containsUnsafeCharacters($url) || $this->containsPathTraversal($url)) {
            $fail('The evidence link URL must be a safe HTTP URL, app path, or docs path.');

            return;
        }

        if (str_starts_with($url, 'docs/')) {
            return;
        }

        if (str_starts_with($url, '/')) {
            if (! str_starts_with($url, '//')) {
                return;
            }

            $fail('The evidence link URL must be a safe HTTP URL, app path, or docs path.');

            return;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        if (! in_array($scheme, ['http', 'https'], true) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            $fail('The evidence link URL must be a safe HTTP URL, app path, or docs path.');

            return;
        }

        if (parse_url($url, PHP_URL_USER) !== null || parse_url($url, PHP_URL_PASS) !== null) {
            $fail('The evidence link URL must not include embedded credentials.');
        }
    }

    private function containsUnsafeCharacters(string $url): bool
    {
        return preg_match('/[<>\x00-\x1F\x7F]/u', $url) === 1;
    }

    private function containsPathTraversal(string $url): bool
    {
        $decoded = rawurldecode(str_replace('\\', '/', $url));

        return preg_match('~(?:^|/)\.\.(?:/|$)~', $decoded) === 1;
    }
}
