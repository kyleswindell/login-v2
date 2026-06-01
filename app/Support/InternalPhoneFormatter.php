<?php

namespace App\Support;

final class InternalPhoneFormatter
{
    public static function normalize(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalizedWhitespace = preg_replace('/\s+/', ' ', trim($value));
        $normalizedWhitespace = is_string($normalizedWhitespace) ? $normalizedWhitespace : trim($value);

        if ($normalizedWhitespace === '') {
            return null;
        }

        $extension = null;

        if (preg_match('/(?:ext\.?|extension|x)\s*(\d+)$/i', $normalizedWhitespace, $matches) === 1) {
            $extension = $matches[1];
            $normalizedWhitespace = trim(substr($normalizedWhitespace, 0, -strlen($matches[0])));
        }

        $digits = preg_replace('/\D+/', '', $normalizedWhitespace);
        $digits = is_string($digits) ? $digits : '';

        if (strlen($digits) === 11 && str_starts_with($digits, '1')) {
            $digits = substr($digits, 1);
        }

        if (strlen($digits) !== 10) {
            return $extension !== null
                ? trim($normalizedWhitespace.' x'.$extension)
                : $normalizedWhitespace;
        }

        $formatted = sprintf('(%s) %s-%s', substr($digits, 0, 3), substr($digits, 3, 3), substr($digits, 6, 4));

        return $extension !== null
            ? $formatted.' x'.$extension
            : $formatted;
    }
}
