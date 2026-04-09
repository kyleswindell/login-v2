<?php

namespace Tests\Feature\Logging;

use Tests\TestCase;

class RequestIdTest extends TestCase
{
    public function test_request_id_header_is_added_to_responses(): void
    {
        $this->get('/')
            ->assertRedirect('/login')
            ->assertHeader('X-Request-Id');
    }

    public function test_existing_request_id_header_is_preserved(): void
    {
        $requestId = '8f1f0000-0000-4000-8000-000000000001';

        $this->withHeader('X-Request-Id', $requestId)
            ->get('/')
            ->assertRedirect('/login')
            ->assertHeader('X-Request-Id', $requestId);
    }
}
