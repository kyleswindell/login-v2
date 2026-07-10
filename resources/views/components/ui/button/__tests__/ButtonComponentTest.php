<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/button/__tests__/ButtonComponentTest.php
| Purpose: Verify Button component Blade rendering and public API contract.
|--------------------------------------------------------------------------
|
| These tests protect the x-ui.button public API, rendered markup, accessibility
| behavior, compatibility aliases, and root class/data-attribute contract.
|
*/

namespace Tests\Ui\Components\Button;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

final class ButtonComponentTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Contract / source inventory
     * ---------------------------------------------------------------------
     */

    public function test_button_contract_and_source_files_are_installed(): void
    {
        $contract = $this->contract();

        $this->assertSame('button', data_get($contract, 'identity.slug'));
        $this->assertSame('Button', data_get($contract, 'identity.label'));
        $this->assertSame('x-ui.button', data_get($contract, 'identity.component'));
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

            $this->assertIsArray($paths, "Button contract [{$sourceKey}] must be an array.");
            $this->assertNotSame([], $paths, "Button contract [{$sourceKey}] must not be empty.");

            foreach ($paths as $path) {
                $this->assertIsString($path, "Button contract [{$sourceKey}] entries must be strings.");
                $this->assertFileExists(base_path($path), "Button source path [{$path}] must exist.");
            }
        }
    }

    public function test_button_contract_declares_expected_public_props(): void
    {
        $props = collect(data_get($this->contract(), 'api.props', []))
            ->pluck('name')
            ->all();

        $this->assertSame(
            [
                'href',
                'type',
                'kind',
                'semantic',
                'variant',
                'size',
                'expressive',
                'loading',
                'disabled',
                'icon',
                'iconPosition',
                'dangerDescription',
            ],
            $props,
            'Button public props must stay aligned with the rendered component API.',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Default rendering
     * ---------------------------------------------------------------------
     */

    public function test_button_renders_native_button_by_default(): void
    {
        $html = $this->renderButton('Save');

        $this->assertStringContainsString('<button', $html);
        $this->assertStringContainsString('type="button"', $html);
        $this->assertStringContainsString('data-ui-component="button"', $html);
        $this->assertStringContainsString('class="ui-btn', $html);
        $this->assertStringContainsString('ui-btn--primary', $html);
        $this->assertStringContainsString('ui-btn--lg', $html);
        $this->assertStringContainsString('ui-layout--size-lg', $html);
        $this->assertStringContainsString('<span class="ui-btn__label">Save</span>', $html);
        $this->assertStringNotContainsString('<a ', $html);
    }

    public function test_button_merges_custom_attributes_and_classes_onto_root_element(): void
    {
        $html = Blade::render(
            '<x-ui.button id="save-button" class="custom-class" data-test-id="save" tabindex="-1">Save</x-ui.button>',
        );

        $this->assertStringContainsString('id="save-button"', $html);
        $this->assertStringContainsString('custom-class', $html);
        $this->assertStringContainsString('data-test-id="save"', $html);
        $this->assertStringContainsString('tabindex="-1"', $html);
        $this->assertStringContainsString('ui-btn', $html);
    }

    public function test_button_falls_back_to_safe_defaults_for_invalid_public_values(): void
    {
        $html = Blade::render(
            '<x-ui.button kind="bad-kind" size="bad-size" type="bad-type">Save</x-ui.button>',
        );

        $this->assertStringContainsString('type="button"', $html);
        $this->assertStringContainsString('ui-btn--primary', $html);
        $this->assertStringContainsString('ui-btn--lg', $html);
        $this->assertStringContainsString('ui-layout--size-lg', $html);
    }

    /**
     * ---------------------------------------------------------------------
     * Native button type
     * ---------------------------------------------------------------------
     */

    public function test_button_supports_approved_native_button_types(): void
    {
        foreach (['button', 'submit', 'reset'] as $type) {
            $html = Blade::render(
                '<x-ui.button type="' . $type . '">Action</x-ui.button>',
            );

            $this->assertStringContainsString(
                'type="' . $type . '"',
                $html,
                "Button must support native type [{$type}].",
            );
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Kinds / sizes
     * ---------------------------------------------------------------------
     */

    public function test_button_renders_contract_kind_classes(): void
    {
        foreach (data_get($this->contract(), 'variants', []) as $kind => $variant) {
            $expectedClass = data_get($variant, 'class');

            $this->assertIsString($expectedClass, "Button variant [{$kind}] must define a class.");

            $html = Blade::render(
                '<x-ui.button kind="' . $kind . '">Action</x-ui.button>',
            );

            $this->assertStringContainsString(
                $expectedClass,
                $html,
                "Button kind [{$kind}] must render [{$expectedClass}].",
            );
        }
    }

    public function test_button_renders_contract_size_classes(): void
    {
        foreach (data_get($this->contract(), 'sizes', []) as $size => $sizeContract) {
            $expectedClass = data_get($sizeContract, 'class');

            $this->assertIsString($expectedClass, "Button size [{$size}] must define a class.");

            $html = Blade::render(
                '<x-ui.button size="' . $size . '">Action</x-ui.button>',
            );

            $this->assertStringContainsString(
                $expectedClass,
                $html,
                "Button size [{$size}] must render [{$expectedClass}].",
            );

            $this->assertStringContainsString(
                'ui-layout--size-' . $size,
                $html,
                "Button size [{$size}] must render its layout size class.",
            );
        }
    }

    public function test_lg_expressive_size_alias_renders_large_expressive_button(): void
    {
        $html = Blade::render(
            '<x-ui.button size="lg-expressive">Action</x-ui.button>',
        );

        $this->assertStringContainsString('ui-btn--lg', $html);
        $this->assertStringContainsString('ui-layout--size-lg', $html);
        $this->assertStringContainsString('ui-btn--expressive', $html);
        $this->assertStringNotContainsString('ui-btn--lg-expressive', $html);
    }

    public function test_explicit_expressive_prop_renders_expressive_modifier(): void
    {
        $html = Blade::render(
            '<x-ui.button expressive>Action</x-ui.button>',
        );

        $this->assertStringContainsString('ui-btn--expressive', $html);
    }

    /**
     * ---------------------------------------------------------------------
     * Compatibility aliases
     * ---------------------------------------------------------------------
     */

    public function test_semantic_aliases_resolve_to_expected_kinds_when_kind_is_not_provided(): void
    {
        $expectations = [
            'neutral' => 'ui-btn--tertiary',
            'warning' => 'ui-btn--tertiary',
            'notice' => 'ui-btn--tertiary',
            'info' => 'ui-btn--tertiary',
            'success' => 'ui-btn--primary',
            'danger-primary' => 'ui-btn--danger--primary',
            'danger-tertiary' => 'ui-btn--danger--tertiary',
            'danger-ghost' => 'ui-btn--danger--ghost',
        ];

        foreach ($expectations as $semantic => $expectedClass) {
            $html = Blade::render(
                '<x-ui.button semantic="' . $semantic . '">Action</x-ui.button>',
            );

            $this->assertStringContainsString(
                $expectedClass,
                $html,
                "Button semantic alias [{$semantic}] must resolve to [{$expectedClass}].",
            );
        }
    }

    public function test_kind_takes_precedence_over_semantic_alias(): void
    {
        $html = Blade::render(
            '<x-ui.button kind="secondary" semantic="danger-primary">Action</x-ui.button>',
        );

        $this->assertStringContainsString('ui-btn--secondary', $html);
        $this->assertStringNotContainsString('ui-btn--danger--primary', $html);
    }

    public function test_variant_aliases_resolve_to_expected_kinds(): void
    {
        $expectations = [
            ['kind' => 'primary', 'variant' => 'outline', 'class' => 'ui-btn--tertiary'],
            ['kind' => 'primary', 'variant' => 'soft', 'class' => 'ui-btn--tertiary'],
            ['kind' => 'primary', 'variant' => 'ghost', 'class' => 'ui-btn--ghost'],
            ['kind' => 'danger', 'variant' => 'outline', 'class' => 'ui-btn--danger--tertiary'],
            ['kind' => 'danger', 'variant' => 'soft', 'class' => 'ui-btn--danger--tertiary'],
            ['kind' => 'danger', 'variant' => 'ghost', 'class' => 'ui-btn--danger--ghost'],
        ];

        foreach ($expectations as $expectation) {
            $html = Blade::render(
                '<x-ui.button kind="' . $expectation['kind'] . '" variant="' . $expectation['variant'] . '">Action</x-ui.button>',
            );

            $this->assertStringContainsString(
                $expectation['class'],
                $html,
                "Button variant alias [{$expectation['variant']}] for kind [{$expectation['kind']}] must resolve to [{$expectation['class']}].",
            );
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Anchor rendering
     * ---------------------------------------------------------------------
     */

    public function test_button_renders_anchor_when_href_is_present_and_interactive(): void
    {
        $html = Blade::render(
            '<x-ui.button href="/dashboard">Dashboard</x-ui.button>',
        );

        $this->assertStringContainsString('<a', $html);
        $this->assertStringContainsString('href="/dashboard"', $html);
        $this->assertStringContainsString('data-ui-component="button"', $html);
        $this->assertStringContainsString('<span class="ui-btn__label">Dashboard</span>', $html);
        $this->assertStringNotContainsString('<button', $html);
        $this->assertStringNotContainsString('type="button"', $html);
        $this->assertStringNotContainsString('disabled', $html);
    }

    public function test_disabled_href_button_renders_native_disabled_button_instead_of_anchor(): void
    {
        $html = Blade::render(
            '<x-ui.button href="/dashboard" disabled>Dashboard</x-ui.button>',
        );

        $this->assertStringContainsString('<button', $html);
        $this->assertStringContainsString('disabled', $html);
        $this->assertStringContainsString('ui-btn--disabled', $html);
        $this->assertStringNotContainsString('<a', $html);
        $this->assertStringNotContainsString('href="/dashboard"', $html);
    }

    public function test_loading_href_button_renders_native_disabled_busy_button_instead_of_anchor(): void
    {
        $html = Blade::render(
            '<x-ui.button href="/dashboard" loading>Dashboard</x-ui.button>',
        );

        $this->assertStringContainsString('<button', $html);
        $this->assertStringContainsString('disabled', $html);
        $this->assertStringContainsString('aria-busy="true"', $html);
        $this->assertStringContainsString('ui-btn--loading', $html);
        $this->assertStringContainsString('ui-btn--disabled', $html);
        $this->assertStringContainsString('ui-spinner', $html);
        $this->assertStringNotContainsString('<a', $html);
        $this->assertStringNotContainsString('href="/dashboard"', $html);
    }

    /**
     * ---------------------------------------------------------------------
     * Disabled / loading state
     * ---------------------------------------------------------------------
     */

    public function test_disabled_button_renders_native_disabled_state_and_disabled_modifier(): void
    {
        $html = Blade::render(
            '<x-ui.button disabled>Save</x-ui.button>',
        );

        $this->assertStringContainsString('<button', $html);
        $this->assertStringContainsString('disabled', $html);
        $this->assertStringContainsString('ui-btn--disabled', $html);
        $this->assertStringNotContainsString('aria-busy="true"', $html);
    }

    public function test_loading_button_renders_busy_disabled_state_and_decorative_spinner(): void
    {
        $html = Blade::render(
            '<x-ui.button loading>Save</x-ui.button>',
        );

        $this->assertStringContainsString('<button', $html);
        $this->assertStringContainsString('disabled', $html);
        $this->assertStringContainsString('aria-busy="true"', $html);
        $this->assertStringContainsString('ui-btn--loading', $html);
        $this->assertStringContainsString('ui-btn--disabled', $html);
        $this->assertStringContainsString('ui-spinner', $html);
        $this->assertStringContainsString('aria-hidden="true"', $html);
    }

    public function test_filled_loading_kinds_use_inverse_spinner_treatment(): void
    {
        foreach (['primary', 'secondary', 'danger', 'danger--primary'] as $kind) {
            $html = Blade::render(
                '<x-ui.button kind="' . $kind . '" loading>Save</x-ui.button>',
            );

            $this->assertStringContainsString(
                'ui-spinner-inverse',
                $html,
                "Loading button kind [{$kind}] must use inverse spinner treatment.",
            );
        }
    }

    public function test_unfilled_loading_kinds_do_not_use_inverse_spinner_treatment(): void
    {
        foreach (['tertiary', 'ghost', 'danger--tertiary', 'danger--ghost'] as $kind) {
            $html = Blade::render(
                '<x-ui.button kind="' . $kind . '" loading>Save</x-ui.button>',
            );

            $this->assertStringContainsString('ui-spinner', $html);
            $this->assertStringNotContainsString(
                'ui-spinner-inverse',
                $html,
                "Loading button kind [{$kind}] must not use inverse spinner treatment.",
            );
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Icon behavior
     * ---------------------------------------------------------------------
     */

    public function test_button_renders_trailing_decorative_icon_when_icon_is_provided(): void
    {
        $html = Blade::render(
            '<x-ui.button icon="arrow--right">Continue</x-ui.button>',
        );

        $this->assertStringContainsString('ui-btn__icon', $html);
        $this->assertStringContainsString('data-ui-component="icon"', $html);
        $this->assertStringContainsString('data-ui-icon-name="arrow--right"', $html);
        $this->assertStringContainsString('aria-hidden="true"', $html);
    }

    public function test_button_ignores_non_trailing_icon_position_requests(): void
    {
        $html = Blade::render(
            '<x-ui.button icon="arrow--right" icon-position="leading">Continue</x-ui.button>',
        );

        $this->assertStringNotContainsString('ui-btn__icon', $html);
        $this->assertStringNotContainsString('data-ui-component="icon"', $html);
        $this->assertStringContainsString('<span class="ui-btn__label">Continue</span>', $html);
    }

    /**
     * ---------------------------------------------------------------------
     * Danger assistive description
     * ---------------------------------------------------------------------
     */

    public function test_danger_button_merges_generated_danger_description_with_existing_aria_describedby(): void
    {
        $html = Blade::render(
            '<x-ui.button kind="danger" danger-description="This action permanently deletes the record." aria-describedby="existing-help">Delete</x-ui.button>',
        );

        $this->assertStringContainsString('aria-describedby="existing-help ui-btn-danger-description-', $html);
        $this->assertStringContainsString('class="ui-visually-hidden"', $html);
        $this->assertStringContainsString('This action permanently deletes the record.', $html);
    }

    public function test_danger_button_does_not_render_assistive_description_when_empty(): void
    {
        $html = Blade::render(
            '<x-ui.button kind="danger" danger-description="">Delete</x-ui.button>',
        );

        $this->assertStringNotContainsString('aria-describedby=', $html);
        $this->assertStringNotContainsString('ui-btn-danger-description-', $html);
    }

    public function test_non_danger_button_does_not_render_danger_description(): void
    {
        $html = Blade::render(
            '<x-ui.button kind="primary" danger-description="Primary helper text">Save</x-ui.button>',
        );

        $this->assertStringNotContainsString('aria-describedby=', $html);
        $this->assertStringNotContainsString('ui-btn-danger-description-', $html);
        $this->assertStringNotContainsString('Primary helper text', $html);
    }

    /**
     * ---------------------------------------------------------------------
     * Helpers
     * ---------------------------------------------------------------------
     */

    private function renderButton(string $slot): string
    {
        return Blade::render('<x-ui.button>' . $slot . '</x-ui.button>');
    }

    /**
     * @return array<string, mixed>
     */
    private function contract(): array
    {
        $contract = require resource_path('views/components/ui/button/contract.php');

        $this->assertIsArray($contract);

        return $contract;
    }
}
