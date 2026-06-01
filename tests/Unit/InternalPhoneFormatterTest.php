<?php

namespace Tests\Unit;

use App\Support\InternalPhoneFormatter;
use PHPUnit\Framework\TestCase;

class InternalPhoneFormatterTest extends TestCase
{
    public function test_it_formats_plain_ten_digit_numbers(): void
    {
        $this->assertSame('(555) 555-5555', InternalPhoneFormatter::normalize('5555555555'));
    }

    public function test_it_formats_country_code_input_to_the_internal_baseline(): void
    {
        $this->assertSame('(555) 555-5555', InternalPhoneFormatter::normalize('1 (555) 555-5555'));
    }

    public function test_it_preserves_standard_extensions_after_normalizing_the_base_number(): void
    {
        $this->assertSame('(555) 867-5309 x204', InternalPhoneFormatter::normalize('5558675309 ext 204'));
    }

    public function test_it_leaves_non_baseline_numbers_as_entered_after_trimming(): void
    {
        $this->assertSame('555-0102', InternalPhoneFormatter::normalize('  555-0102  '));
    }
}
