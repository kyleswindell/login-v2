<?php

declare(strict_types=1);

namespace Tests\Feature\Patterns\CommonActions;

use App\Surfaces\Contracts\Repository;
use App\Surfaces\Contracts\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class ActionSetTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_renders_a_semantic_action_group(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-patterns.common-actions.action-set label="Form actions">
                <x-ui.button variant="secondary" type="button">
                    Cancel
                </x-ui.button>

                <x-ui.button variant="primary" type="submit">
                    Save changes
                </x-ui.button>
            </x-patterns.common-actions.action-set>
        BLADE);

        $this->assertStringContainsString('data-pattern="common-actions.action-set"', $html);
        $this->assertStringContainsString('role="group"', $html);
        $this->assertStringContainsString('aria-label="Form actions"', $html);
        $this->assertStringContainsString('Cancel', $html);
        $this->assertStringContainsString('Save changes', $html);
    }

    public function test_it_supports_visible_labelling_through_aria_labelledby(): void
    {
        $html = Blade::render(<<<'BLADE'
            <h2 id="account-actions-heading">Account actions</h2>

            <x-patterns.common-actions.action-set labelled-by="account-actions-heading">
                <x-ui.button variant="secondary" type="button">
                    Cancel
                </x-ui.button>
            </x-patterns.common-actions.action-set>
        BLADE);

        $this->assertStringContainsString('aria-labelledby="account-actions-heading"', $html);
        $this->assertStringNotContainsString('aria-label="Actions"', $html);
    }

    public function test_it_supports_semantic_orientation_metadata_without_owning_layout(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-patterns.common-actions.action-set label="Vertical actions" orientation="vertical">
                <x-ui.button variant="secondary" type="button">
                    Reset
                </x-ui.button>
            </x-patterns.common-actions.action-set>
        BLADE);

        $this->assertStringContainsString('aria-orientation="vertical"', $html);
        $this->assertStringContainsString('Reset', $html);
        $this->assertStringNotContainsString('ui-pattern-common-actions-action-set', $html);
    }

    public function test_contract_is_registered_as_a_pattern_surface(): void
    {
        $contract = app(Repository::class)->find('pattern', 'common-actions-action-set');

        $this->assertIsArray($contract);
        $this->assertSame('common-actions-action-set', data_get($contract, 'identity.slug'));
        $this->assertSame('pattern', data_get($contract, 'identity.type'));
        $this->assertSame('x-patterns.common-actions.action-set', data_get($contract, 'identity.component'));
        $this->assertSame('approved', data_get($contract, 'lifecycle.status'));
        $this->assertSame([], Validator::validate($contract, true));
    }

}
