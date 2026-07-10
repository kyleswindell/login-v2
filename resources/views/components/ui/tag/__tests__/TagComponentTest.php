<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/tag/__tests__/TagComponentTest.php
| Purpose: Verify Tag component Blade rendering and public API contract.
|--------------------------------------------------------------------------
|
| These tests protect the x-ui.tag public API, rendered markup, accessibility
| behavior, class/data-attribute contract, and contract-to-implementation
| alignment.
|
*/

namespace Tests\Ui\Components\Tag;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

final class TagComponentTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Contract / source inventory
     * ---------------------------------------------------------------------
     */

    public function test_tag_contract_and_source_files_are_installed(): void
    {
        $contract = $this->contract();

        $this->assertSame('tag', data_get($contract, 'identity.slug'));
        $this->assertSame('Tag', data_get($contract, 'identity.label'));
        $this->assertSame('x-ui.tag', data_get($contract, 'identity.component'));
        $this->assertSame('provisional', data_get($contract, 'lifecycle.status'));

        foreach (
            [
                'source.blade',
                'source.css',
                'source.tokens',
                'source.contract',
                'source.docs',
            ] as $sourceKey
        ) {
            $paths = data_get($contract, $sourceKey, []);

            $this->assertIsArray($paths, "Tag contract [{$sourceKey}] must be an array.");
            $this->assertNotSame([], $paths, "Tag contract [{$sourceKey}] must not be empty.");

            foreach ($paths as $path) {
                $this->assertIsString($path, "Tag contract [{$sourceKey}] entries must be strings.");
                $this->assertFileExists(base_path($path), "Tag source path [{$path}] must exist.");
            }
        }
    }

    public function test_tag_contract_public_props_match_installed_blade_props(): void
    {
        $contractProps = $this->contractPropNames();
        $bladeProps = $this->bladePropNames();

        sort($contractProps);
        sort($bladeProps);

        $this->assertSame(
            $bladeProps,
            $contractProps,
            'Tag contract props must document the installed Blade props. Update contract, Blade, or standard intentionally when this fails.',
        );
    }

    public function test_tag_contract_declares_installed_variant_type_tone_size_and_state_values(): void
    {
        $this->assertSame(
            [
                'readonly',
                'read-only',
                'filter',
                'dismissible',
                'selectable',
                'operational',
            ],
            $this->propValues('variant'),
            'Tag contract must document installed variant values.',
        );

        $this->assertSame(
            [
                'gray',
                'cool-gray',
                'cool_gray',
                'warm-gray',
                'warm_gray',
                'red',
                'magenta',
                'purple',
                'blue',
                'cyan',
                'teal',
                'green',
                'high-contrast',
                'outline',
            ],
            $this->propValues('type'),
            'Tag contract must document installed type values.',
        );

        $this->assertSame(
            [
                'gray',
                'neutral',
                'blue',
                'info',
                'notice',
                'green',
                'success',
                'red',
                'danger',
                'error',
                'yellow',
                'warning',
                'purple',
            ],
            $this->propValues('tone'),
            'Tag contract must document installed tone compatibility values.',
        );

        $this->assertSame(
            [
                'sm',
                'md',
                'lg',
            ],
            $this->propValues('size'),
            'Tag contract must document installed size values.',
        );

        $this->assertSame(
            [
                'top',
                'bottom',
                'left',
                'right',
                'top-start',
                'top-end',
                'bottom-start',
                'bottom-end',
                'left-start',
                'left-end',
                'right-start',
                'right-end',
                'start',
                'center',
                'end',
            ],
            $this->propValues('dismissTooltipAlignment'),
            'Tag contract must document installed dismiss tooltip alignment values.',
        );
    }

    public function test_tag_contract_declares_installed_data_attributes(): void
    {
        $dataAttributes = collect(data_get($this->contract(), 'api.data_attributes', []))
            ->pluck('name')
            ->all();

        foreach (
            [
                'data-ui-component',
                'data-ui-tag',
                'data-ui-tag-variant',
                'data-ui-tag-type',
                'data-ui-tag-size',
                'data-ui-tag-selected',
                'data-ui-tag-disabled',
                'data-ui-tag-dismissible',
                'data-ui-tag-dismiss',
                'data-ui-tag-operational',
                'data-ui-tag-expanded',
                'data-ui-tag-disclosure-target',
                'data-ui-tag-decorator',
                'data-ui-tag-decorator-source',
            ] as $attribute
        ) {
            $this->assertContains(
                $attribute,
                $dataAttributes,
                "Tag contract must document generated data attribute [{$attribute}].",
            );
        }
    }

    public function test_tag_contract_class_contract_matches_installed_classes(): void
    {
        $contract = $this->contract();

        $this->assertSame('ui-tag', data_get($contract, 'class_contract.root'));

        $optional = data_get($contract, 'class_contract.optional', []);

        foreach (
            [
                'ui-tag-read-only',
                'ui-tag-dismissible',
                'ui-tag-selectable',
                'ui-tag-operational',
                'ui-tag-type-gray',
                'ui-tag-type-cool-gray',
                'ui-tag-type-warm-gray',
                'ui-tag-type-red',
                'ui-tag-type-magenta',
                'ui-tag-type-purple',
                'ui-tag-type-blue',
                'ui-tag-type-cyan',
                'ui-tag-type-teal',
                'ui-tag-type-green',
                'ui-tag-type-high-contrast',
                'ui-tag-type-outline',
                'ui-tag-sm',
                'ui-tag-md',
                'ui-tag-lg',
                'ui-tag-has-icon',
                'ui-tag-has-decorator',
                'ui-tag-selected',
                'ui-tag-disabled',
                'ui-tag-truncate-start',
                'ui-tag-truncate-middle',
                'ui-tag-truncate-end',
            ] as $className
        ) {
            $this->assertContains(
                $className,
                $optional,
                "Tag contract must document installed optional class [{$className}].",
            );
        }

        $internal = data_get($contract, 'class_contract.internal', []);

        foreach (
            [
                'ui-tag-label',
                'ui-tag-label-middle',
                'ui-tag-label-start',
                'ui-tag-label-end',
                'ui-tag-icon',
                'ui-tag-icon-decorative',
                'ui-tag-close',
                'ui-tag-close-icon',
                'ui-tag-decorator',
            ] as $className
        ) {
            $this->assertContains(
                $className,
                $internal,
                "Tag contract must document installed internal class [{$className}].",
            );
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Default rendering
     * ---------------------------------------------------------------------
     */

    public function test_tag_renders_read_only_span_by_default(): void
    {
        $html = Blade::render('<x-ui.tag>Open</x-ui.tag>');

        $this->assertStringContainsString('<span', $html);
        $this->assertStringContainsString('data-ui-component="tag"', $html);
        $this->assertMatchesRegularExpression('/\sdata-ui-tag(?:=|\s|>)/', $html);
        $this->assertStringContainsString('data-ui-tag-variant="read-only"', $html);
        $this->assertStringContainsString('data-ui-tag-type="gray"', $html);
        $this->assertStringContainsString('data-ui-tag-size="md"', $html);
        $this->assertStringContainsString('data-ui-tag-disabled="false"', $html);
        $this->assertStringContainsString('data-ui-tag-decorator="false"', $html);
        $this->assertStringContainsString('ui-tag', $html);
        $this->assertStringContainsString('ui-tag-read-only', $html);
        $this->assertStringContainsString('ui-tag-type-gray', $html);
        $this->assertStringContainsString('ui-tag-md', $html);
        $this->assertMatchesRegularExpression('/<span class="ui-tag-label"[^>]*>Open<\/span>/', $html);
        $this->assertStringNotContainsString('<button', $html);
        $this->assertStringNotContainsString('tabindex=', $html);
        $this->assertStringNotContainsString('role=', $html);
    }

    public function test_tag_supports_root_id_from_public_prop(): void
    {
        $html = Blade::render('<x-ui.tag id="status-tag">Open</x-ui.tag>');

        $this->assertStringContainsString('id="status-tag"', $html);
    }

    public function test_tag_text_prop_renders_visible_label_and_takes_precedence_over_label_and_slot(): void
    {
        $html = Blade::render('<x-ui.tag text="Text wins" label="Label loses">Slot loses</x-ui.tag>');

        $this->assertMatchesRegularExpression('/<span class="ui-tag-label"[^>]*>Text wins<\/span>/', $html);
        $this->assertStringNotContainsString('Label loses', $html);
        $this->assertStringNotContainsString('Slot loses', $html);
    }

    public function test_tag_label_prop_renders_visible_label_when_text_is_not_provided(): void
    {
        $html = Blade::render('<x-ui.tag label="Approved" />');

        $this->assertMatchesRegularExpression('/<span class="ui-tag-label"[^>]*>Approved<\/span>/', $html);
    }

    public function test_tag_slot_markup_is_stripped_for_visible_label_text(): void
    {
        $html = Blade::render('<x-ui.tag><strong>Bold label</strong></x-ui.tag>');

        $this->assertMatchesRegularExpression('/<span class="ui-tag-label"[^>]*>Bold label<\/span>/', $html);
        $this->assertStringNotContainsString('<strong>', $html);
    }

    public function test_tag_falls_back_to_type_label_when_no_text_label_or_slot_is_provided(): void
    {
        $html = Blade::render('<x-ui.tag type="high-contrast" />');

        $this->assertMatchesRegularExpression('/<span class="ui-tag-label"[^>]*>High contrast<\/span>/', $html);
    }

    public function test_tag_escapes_label_content(): void
    {
        $html = Blade::render('<x-ui.tag :text="$text" />', [
            'text' => '<strong>Unsafe</strong>',
        ]);

        $this->assertStringContainsString('&lt;strong&gt;Unsafe&lt;/strong&gt;', $html);
        $this->assertStringNotContainsString('<strong>Unsafe</strong>', $html);
    }

    /**
     * ---------------------------------------------------------------------
     * Type / tone / size values
     * ---------------------------------------------------------------------
     */

    public function test_tag_renders_installed_type_classes_and_data_attributes(): void
    {
        foreach (
            [
                'gray',
                'cool-gray',
                'cool_gray' => 'cool-gray',
                'warm-gray',
                'warm_gray' => 'warm-gray',
                'red',
                'magenta',
                'purple',
                'blue',
                'cyan',
                'teal',
                'green',
                'high-contrast',
                'outline',
            ] as $input => $expectedType
        ) {
            if (is_int($input)) {
                $input = $expectedType;
            }

            $html = Blade::render('<x-ui.tag type="' . $input . '">Type</x-ui.tag>');

            $this->assertStringContainsString(
                'ui-tag-type-' . $expectedType,
                $html,
                "Tag type [{$input}] must render class [ui-tag-type-{$expectedType}].",
            );

            $this->assertStringContainsString(
                'data-ui-tag-type="' . $expectedType . '"',
                $html,
                "Tag type [{$input}] must render data-ui-tag-type [{$expectedType}].",
            );
        }
    }

    public function test_tag_renders_tone_aliases_to_installed_type_classes(): void
    {
        $expectations = [
            'neutral' => 'gray',
            'info' => 'blue',
            'notice' => 'blue',
            'success' => 'green',
            'danger' => 'red',
            'error' => 'red',
            'warning' => 'purple',
            'yellow' => 'purple',
        ];

        foreach ($expectations as $tone => $expectedType) {
            $html = Blade::render('<x-ui.tag tone="' . $tone . '">Tone</x-ui.tag>');

            $this->assertStringContainsString(
                'ui-tag-type-' . $expectedType,
                $html,
                "Tag tone [{$tone}] must map to type [{$expectedType}].",
            );

            $this->assertStringContainsString(
                'data-ui-tag-type="' . $expectedType . '"',
                $html,
                "Tag tone [{$tone}] must emit resolved type [{$expectedType}].",
            );
        }
    }

    public function test_type_takes_precedence_over_tone_when_both_are_supplied(): void
    {
        $html = Blade::render('<x-ui.tag type="green" tone="danger">Resolved</x-ui.tag>');

        $this->assertStringContainsString('ui-tag-type-green', $html);
        $this->assertStringContainsString('data-ui-tag-type="green"', $html);
        $this->assertStringNotContainsString('ui-tag-type-red', $html);
    }

    public function test_tag_renders_installed_size_classes_and_data_attributes(): void
    {
        foreach (['sm', 'md', 'lg'] as $size) {
            $html = Blade::render('<x-ui.tag size="' . $size . '">Size</x-ui.tag>');

            $this->assertStringContainsString(
                'ui-tag-' . $size,
                $html,
                "Tag size [{$size}] must render class [ui-tag-{$size}].",
            );

            $this->assertStringContainsString(
                'data-ui-tag-size="' . $size . '"',
                $html,
                "Tag size [{$size}] must render data-ui-tag-size [{$size}].",
            );
        }
    }

    public function test_tag_falls_back_to_safe_defaults_for_invalid_values(): void
    {
        $html = Blade::render(
            '<x-ui.tag variant="bad-variant" type="bad-type" tone="bad-tone" size="bad-size" dir="bad-dir" dismiss-tooltip-alignment="bad-alignment">Fallback</x-ui.tag>',
        );

        $this->assertStringContainsString('ui-tag-read-only', $html);
        $this->assertStringContainsString('ui-tag-type-gray', $html);
        $this->assertStringContainsString('ui-tag-md', $html);
        $this->assertStringContainsString('data-ui-tag-variant="read-only"', $html);
        $this->assertStringContainsString('data-ui-tag-type="gray"', $html);
        $this->assertStringContainsString('data-ui-tag-size="md"', $html);
        $this->assertStringContainsString('dir="ltr"', $html);
    }

    /**
     * ---------------------------------------------------------------------
     * Variants
     * ---------------------------------------------------------------------
     */

    public function test_readonly_alias_renders_read_only_variant(): void
    {
        $html = Blade::render('<x-ui.tag variant="readonly">Read only</x-ui.tag>');

        $this->assertStringContainsString('ui-tag-read-only', $html);
        $this->assertStringContainsString('data-ui-tag-variant="read-only"', $html);
    }

    public function test_filter_alias_renders_dismissible_variant(): void
    {
        $html = Blade::render('<x-ui.tag variant="filter" text="Active filter" />');

        $this->assertStringContainsString('ui-tag-dismissible', $html);
        $this->assertStringContainsString('data-ui-tag-variant="dismissible"', $html);
        $this->assertStringContainsString('data-ui-tag-dismissible="true"', $html);
        $this->assertStringContainsString('data-ui-tag-dismiss', $html);
    }

    public function test_dismissible_tag_renders_close_button_with_accessible_name(): void
    {
        $html = Blade::render(
            '<x-ui.tag variant="dismissible" text="Filter" dismiss-tooltip-label="Remove status filter" dismiss-tooltip-alignment="end" />',
        );

        $this->assertStringContainsString('<span', $html);
        $this->assertStringContainsString('ui-tag-dismissible', $html);
        $this->assertStringContainsString('data-ui-tag-variant="dismissible"', $html);
        $this->assertStringContainsString('data-ui-tag-dismissible="true"', $html);
        $this->assertStringContainsString('class="ui-tag-close"', $html);
        $this->assertStringContainsString('aria-label="Remove status filter"', $html);
        $this->assertStringContainsString('title="Remove status filter"', $html);
        $this->assertStringContainsString('data-ui-tag-dismiss', $html);
        $this->assertStringContainsString('data-ui-tooltip-alignment="bottom-end"', $html);
        $this->assertStringContainsString('data-ui-component="icon"', $html);
        $this->assertStringContainsString('data-ui-icon-name="close"', $html);
    }

    public function test_dismiss_label_remains_compatibility_alias_when_tooltip_label_is_not_provided(): void
    {
        $html = Blade::render(
            '<x-ui.tag variant="dismissible" text="Filter" dismiss-label="Remove status filter" />',
        );

        $this->assertStringContainsString('aria-label="Remove status filter"', $html);
        $this->assertStringContainsString('title="Remove status filter"', $html);
    }

    public function test_dismiss_tooltip_label_takes_precedence_over_dismiss_label(): void
    {
        $html = Blade::render(
            '<x-ui.tag variant="dismissible" text="Filter" dismiss-label="Remove old" dismiss-tooltip-label="Remove new" />',
        );

        $this->assertStringContainsString('aria-label="Remove new"', $html);
        $this->assertStringNotContainsString('Remove old', $html);
    }

    public function test_dismiss_tooltip_alignment_aliases_map_to_installed_positions(): void
    {
        $expectations = [
            'start' => 'bottom-start',
            'center' => 'bottom',
            'end' => 'bottom-end',
            'top-start' => 'top-start',
        ];

        foreach ($expectations as $input => $expectedAlignment) {
            $html = Blade::render(
                '<x-ui.tag variant="dismissible" text="Filter" dismiss-tooltip-alignment="' . $input . '" />',
            );

            $this->assertStringContainsString(
                'data-ui-tooltip-alignment="' . $expectedAlignment . '"',
                $html,
                "Dismiss tooltip alignment [{$input}] must resolve to [{$expectedAlignment}].",
            );
        }
    }

    public function test_dismissible_tag_uses_default_close_label_when_dismiss_label_is_not_provided(): void
    {
        $html = Blade::render('<x-ui.tag variant="dismissible" text="Closed" />');

        $this->assertStringContainsString('aria-label="Remove Closed"', $html);
        $this->assertStringContainsString('title="Remove Closed"', $html);
    }

    public function test_disabled_dismissible_tag_disables_close_control_and_marks_root_disabled(): void
    {
        $html = Blade::render('<x-ui.tag variant="dismissible" text="Closed" :disabled="true" />');

        $this->assertStringContainsString('ui-tag-disabled', $html);
        $this->assertStringContainsString('data-ui-tag-disabled="true"', $html);
        $this->assertStringContainsString('aria-disabled="true"', $html);
        $this->assertMatchesRegularExpression('/<button[^>]+class="ui-tag-close"[^>]+disabled/', $html);
    }

    public function test_selectable_tag_renders_toggle_button_with_pressed_state(): void
    {
        $html = Blade::render('<x-ui.tag variant="selectable" text="Selected" :selected="true" />');

        $this->assertStringContainsString('<button', $html);
        $this->assertStringContainsString('type="button"', $html);
        $this->assertStringContainsString('ui-tag-selectable', $html);
        $this->assertStringContainsString('ui-tag-selected', $html);
        $this->assertStringContainsString('data-ui-tag-variant="selectable"', $html);
        $this->assertStringContainsString('data-ui-tag-selected="true"', $html);
        $this->assertStringContainsString('aria-pressed="true"', $html);
    }

    public function test_selectable_tag_supports_default_selected_state(): void
    {
        $html = Blade::render('<x-ui.tag variant="selectable" text="Default selected" :default-selected="true" />');

        $this->assertStringContainsString('ui-tag-selected', $html);
        $this->assertStringContainsString('data-ui-tag-selected="true"', $html);
        $this->assertStringContainsString('aria-pressed="true"', $html);
    }

    public function test_controlled_selected_false_takes_precedence_over_default_selected_true(): void
    {
        $html = Blade::render('<x-ui.tag variant="selectable" text="Not selected" :selected="false" :default-selected="true" />');

        $this->assertStringNotContainsString('ui-tag-selected', $html);
        $this->assertStringContainsString('data-ui-tag-selected="false"', $html);
        $this->assertStringContainsString('aria-pressed="false"', $html);
    }

    public function test_disabled_selectable_tag_renders_disabled_toggle_button(): void
    {
        $html = Blade::render('<x-ui.tag variant="selectable" text="Disabled" :disabled="true" />');

        $this->assertStringContainsString('<button', $html);
        $this->assertStringContainsString('ui-tag-disabled', $html);
        $this->assertStringContainsString('data-ui-tag-disabled="true"', $html);
        $this->assertStringContainsString('aria-disabled="true"', $html);
        $this->assertMatchesRegularExpression('/<button[^>]+disabled/', $html);
    }

    public function test_operational_tag_renders_button_with_disclosure_attributes(): void
    {
        $html = Blade::render('<x-ui.tag variant="operational" text="Filters" disclosure-target="#filters-panel" />');

        $this->assertStringContainsString('<button', $html);
        $this->assertStringContainsString('type="button"', $html);
        $this->assertStringContainsString('ui-tag-operational', $html);
        $this->assertStringContainsString('data-ui-tag-operational', $html);
        $this->assertStringContainsString('data-ui-tag-variant="operational"', $html);
        $this->assertStringContainsString('data-ui-tag-expanded="false"', $html);
        $this->assertStringContainsString('data-ui-tag-disclosure-target="filters-panel"', $html);
        $this->assertStringContainsString('aria-controls="filters-panel"', $html);
        $this->assertStringContainsString('aria-expanded="false"', $html);
    }

    public function test_operational_tag_supports_expanded_state(): void
    {
        $html = Blade::render('<x-ui.tag variant="operational" text="Filters" disclosure-target="filters-panel" :expanded="true" />');

        $this->assertStringContainsString('data-ui-tag-expanded="true"', $html);
        $this->assertStringContainsString('aria-expanded="true"', $html);
    }

    public function test_operational_tag_without_disclosure_target_does_not_emit_aria_controls(): void
    {
        $html = Blade::render('<x-ui.tag variant="operational" text="Filters" />');

        $this->assertStringNotContainsString('aria-controls=', $html);
        $this->assertStringContainsString('aria-expanded="false"', $html);
    }

    public function test_disabled_operational_tag_renders_disabled_button(): void
    {
        $html = Blade::render('<x-ui.tag variant="operational" text="Filters" :disabled="true" />');

        $this->assertStringContainsString('<button', $html);
        $this->assertStringContainsString('ui-tag-disabled', $html);
        $this->assertStringContainsString('data-ui-tag-disabled="true"', $html);
        $this->assertStringContainsString('aria-disabled="true"', $html);
        $this->assertMatchesRegularExpression('/<button[^>]+disabled/', $html);
    }

    /**
     * ---------------------------------------------------------------------
     * Icons / decorators / truncation / direction
     * ---------------------------------------------------------------------
     */

    public function test_tag_renders_optional_decorative_icon(): void
    {
        $html = Blade::render('<x-ui.tag icon="checkmark" text="Ready" />');

        $this->assertStringContainsString('ui-tag-has-icon', $html);
        $this->assertStringContainsString('ui-tag-icon', $html);
        $this->assertStringContainsString('ui-tag-icon-decorative', $html);
        $this->assertStringContainsString('data-ui-component="icon"', $html);
        $this->assertStringContainsString('data-ui-icon-name="checkmark"', $html);
        $this->assertStringContainsString('aria-hidden="true"', $html);
    }

    public function test_read_only_tag_renders_decorator_content(): void
    {
        $html = Blade::render('<x-ui.tag text="Generated" decorator="AI" />');

        $this->assertStringContainsString('ui-tag-has-decorator', $html);
        $this->assertStringContainsString('data-ui-tag-decorator="true"', $html);
        $this->assertStringContainsString('data-ui-tag-decorator-source="decorator"', $html);
        $this->assertStringContainsString('class="ui-tag-decorator"', $html);
        $this->assertStringContainsString('AI', $html);
    }

    public function test_decorator_trusted_html_string_renders_as_html(): void
    {
        $html = Blade::render('<x-ui.tag text="Generated" :decorator="$decorator" />', [
            'decorator' => new HtmlString('<abbr title="Artificial intelligence">AI</abbr>'),
        ]);

        $this->assertStringContainsString('<abbr title="Artificial intelligence">AI</abbr>', $html);
    }

    public function test_string_decorator_content_is_escaped(): void
    {
        $html = Blade::render('<x-ui.tag text="Generated" :decorator="$decorator" />', [
            'decorator' => '<strong>AI</strong>',
        ]);

        $this->assertStringContainsString('&lt;strong&gt;AI&lt;/strong&gt;', $html);
        $this->assertStringNotContainsString('<strong>AI</strong>', $html);
    }

    public function test_slug_alias_renders_decorator_with_slug_source_marker(): void
    {
        $html = Blade::render('<x-ui.tag text="Generated" slug="AI" />');

        $this->assertStringContainsString('ui-tag-has-decorator', $html);
        $this->assertStringContainsString('data-ui-tag-decorator="true"', $html);
        $this->assertStringContainsString('data-ui-tag-decorator-source="slug"', $html);
        $this->assertStringContainsString('class="ui-tag-decorator"', $html);
    }

    public function test_decorator_is_not_rendered_for_selectable_or_operational_variants(): void
    {
        foreach (['selectable', 'operational'] as $variant) {
            $html = Blade::render('<x-ui.tag variant="' . $variant . '" text="Tag" decorator="AI" />');

            $this->assertStringNotContainsString('ui-tag-has-decorator', $html);
            $this->assertStringNotContainsString('class="ui-tag-decorator"', $html);
        }
    }

    public function test_tag_supports_start_and_end_truncation_classes(): void
    {
        foreach (['start', 'end'] as $truncate) {
            $html = Blade::render('<x-ui.tag truncate="' . $truncate . '" text="Long tag content" />');

            $this->assertStringContainsString('ui-tag-truncate-' . $truncate, $html);
            $this->assertStringContainsString('class="ui-tag-label"', $html);
            $this->assertStringContainsString('title="Long tag content"', $html);
        }
    }

    public function test_tag_supports_middle_truncation_markup(): void
    {
        $html = Blade::render('<x-ui.tag truncate="middle" text="ABCDEFGHIJKLMNOPQRSTUVWXYZ" />');

        $this->assertStringContainsString('ui-tag-truncate-middle', $html);
        $this->assertStringContainsString('ui-tag-label-middle', $html);
        $this->assertStringContainsString('ui-tag-label-start', $html);
        $this->assertStringContainsString('ui-tag-label-end', $html);
        $this->assertStringContainsString('title="ABCDEFGHIJKLMNOPQRSTUVWXYZ"', $html);
    }

    public function test_tag_title_takes_precedence_over_title_alias_for_label_title_attribute(): void
    {
        $html = Blade::render('<x-ui.tag text="Label" title="Old title" tag-title="New title" />');

        $this->assertStringContainsString('title="New title"', $html);
        $this->assertStringNotContainsString('title="Old title"', $html);
    }

    public function test_tag_label_supports_ltr_rtl_and_auto_direction(): void
    {
        foreach (['ltr', 'rtl', 'auto'] as $direction) {
            $html = Blade::render('<x-ui.tag dir="' . $direction . '" text="Direction" />');

            $this->assertStringContainsString(
                'dir="' . $direction . '"',
                $html,
                "Tag label must support dir [{$direction}].",
            );
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Helpers
     * ---------------------------------------------------------------------
     *
     * @return array<string, mixed>
     */
    private function contract(): array
    {
        $contract = require resource_path('views/components/ui/tag/contract.php');

        $this->assertIsArray($contract);

        return $contract;
    }

    /**
     * @return list<string>
     */
    private function contractPropNames(): array
    {
        return collect(data_get($this->contract(), 'api.props', []))
            ->pluck('name')
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    private function bladePropNames(): array
    {
        $blade = file_get_contents(resource_path('views/components/ui/tag/index.blade.php'));

        $this->assertIsString($blade);

        preg_match('/@props\(\s*\[(?<props>.*?)\]\s*\)/s', $blade, $propsMatch);

        $this->assertArrayHasKey('props', $propsMatch, 'Tag Blade file must declare @props.');

        preg_match_all(
            '/[\'"](?<name>[A-Za-z0-9_]+)[\'"]\s*=>/',
            $propsMatch['props'],
            $matches,
        );

        return array_values($matches['name'] ?? []);
    }

    /**
     * @return list<mixed>
     */
    private function propValues(string $propName): array
    {
        $prop = collect(data_get($this->contract(), 'api.props', []))
            ->firstWhere('name', $propName);

        if (! is_array($prop)) {
            return [];
        }

        return array_values($prop['values'] ?? []);
    }
}
