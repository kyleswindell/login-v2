<?php

namespace Tests\Feature\Platform;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformActionMenuSuiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_actions_reference_page_exposes_the_shared_action_and_menu_item_review_surface(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/actions')
            ->assertOk()
            ->assertSee('P2-B-CQ-014')
            ->assertSee('P2-B-CQ-016')
            ->assertSee('data-ui-component="menu-item"', false)
            ->assertSee('data-ui-pattern="proof-review-target"', false);
    }

    public function test_grouped_action_proofs_consume_the_shared_menu_item_entry_point(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/patterns/navigation')
            ->assertOk()
            ->assertSee('P2-B-CQ-014')
            ->assertSee('P2-B-CQ-016')
            ->assertSee('data-ui-component="menu-item"', false);

        $this->get('/platform/ui-reference/patterns/data-content')
            ->assertOk()
            ->assertSee('P2-B-CQ-014')
            ->assertSee('data-ui-component="menu-item"', false);
    }
}
