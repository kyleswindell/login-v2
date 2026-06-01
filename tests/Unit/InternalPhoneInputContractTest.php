<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class InternalPhoneInputContractTest extends TestCase
{
    public function test_ui_reference_forms_proof_defines_the_partial_entry_contract(): void
    {
        $view = file_get_contents(__DIR__.'/../../resources/views/platform/ui-reference/patterns/forms.blade.php');

        $this->assertIsString($view);
        $this->assertStringContainsString('Partial entry contract', $view);
        $this->assertStringContainsString('Partial entry should render as `(5`, `(555`, `(555) 5`, then normalize to `(555) 555-5555`', $view);
        $this->assertStringContainsString('Format from the first typed digit. Keep the area-code wrapper open through the third digit, add the space on the fourth digit, and add the dash only after the sixth digit.', $view);
    }
}
