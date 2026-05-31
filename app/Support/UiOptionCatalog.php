<?php

namespace App\Support;

use DateTimeZone;

final class UiOptionCatalog
{
    /**
     * @return array<int, array{value: string, label: string}>
     */
    public static function localeOptions(): array
    {
        return [
            ['value' => 'en', 'label' => 'English'],
            ['value' => 'en_US', 'label' => 'English (United States)'],
            ['value' => 'en_GB', 'label' => 'English (United Kingdom)'],
            ['value' => 'es', 'label' => 'Spanish'],
            ['value' => 'fr', 'label' => 'French'],
            ['value' => 'de', 'label' => 'German'],
        ];
    }

    /**
     * @return list<string>
     */
    public static function localeValues(): array
    {
        return array_column(self::localeOptions(), 'value');
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public static function timezoneOptions(): array
    {
        return array_map(
            static fn (string $timezone): array => [
                'value' => $timezone,
                'label' => str_replace('_', ' ', $timezone),
            ],
            DateTimeZone::listIdentifiers()
        );
    }
}
