<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Password/NotCommonOrContextualPassword.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Password;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotCommonOrContextualPassword implements ValidationRule
{
    private const MIN_CONTEXT_WORD_LENGTH = 4;

    /**
     * @var list<string>
     */
    private const COMMON_PASSWORDS = [
        '123456',
        '1234567',
        '12345678',
        '123456789',
        '1234567890',
        'abc123',
        'admin',
        'admin123',
        'administrator',
        'changeme',
        'default',
        'letmein',
        'password',
        'password1',
        'password12',
        'password123',
        'password1234',
        'qwerty',
        'qwerty123',
        'test',
        'test123',
        'welcome',
        'welcome1',
        'welcome123',
    ];

    /**
     * @var list<string|null>
     */
    private array $contextWords;

    /**
     * @param list<string|null> $contextWords
     */
    public function __construct(array $contextWords = [])
    {
        $this->contextWords = $contextWords;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || $value === '') {
            return;
        }

        $normalizedPassword = $this->normalize($value);

        if (in_array($normalizedPassword, self::COMMON_PASSWORDS, true)) {
            $fail('The :attribute is too common. Choose a less predictable password.');

            return;
        }

        foreach ($this->contextWords() as $contextWord) {
            if (str_contains($normalizedPassword, $contextWord)) {
                $fail('The :attribute must not contain account or application-specific words.');

                return;
            }
        }
    }

    /**
     * @return list<string>
     */
    private function contextWords(): array
    {
        $words = [
            'loginapp',
            'loginapp2',
            'loginapp20',
            'loginv2',
            'loginv20',
        ];

        foreach ($this->contextWords as $contextWord) {
            if (! is_string($contextWord) || trim($contextWord) === '') {
                continue;
            }

            $words[] = $contextWord;

            foreach (preg_split('/[^A-Za-z0-9]+/', $contextWord) ?: [] as $part) {
                $words[] = $part;
            }
        }

        $normalized = [];

        foreach ($words as $word) {
            $word = $this->normalize($word);

            if (strlen($word) >= self::MIN_CONTEXT_WORD_LENGTH) {
                $normalized[] = $word;
            }
        }

        return array_values(array_unique($normalized));
    }

    private function normalize(string $value): string
    {
        return strtolower((string) preg_replace('/[^A-Za-z0-9]+/', '', $value));
    }
}
