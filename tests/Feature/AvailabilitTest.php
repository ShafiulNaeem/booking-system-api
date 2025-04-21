<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AvailabilitTest extends TestCase
{
    use LoginTraitForTest;

    #[Test]
    public function host_can_create_availability(): void
    {
        $this->host_login();
        $response = $this->post('/api/v1/availability', [
            'start_time' => '10:00',
            'end_time' => '12:00',
            'host_id' => 1,
            'weekday' => 'Monday',
            'time_zone' => 'UTC'
        ]);
        $response->assertStatus(201);
        // $response->dump();
    }

    #[Test]
    public function guest_can_not_create_availability(): void
    {
        $this->guest_login();
        $response = $this->post('/api/v1/availability', [
            'start_time' => '10:00',
            'end_time' => '12:00',
            'host_id' => 1,
            'weekday' => 'Monday',
            'time_zone' => 'UTC'
        ]);
        $response->assertStatus(401);
        // $response->dump();
    }

    #[Test]
    public function host_can_get_availability(): void
    {
        $this->host_login();
        $response = $this->get('/api/v1/availability/1');
        $response->assertStatus(200);
        // $response->dump();
    }

    #[Test]
    public function guest_can_not_get_availability(): void
    {
        $this->guest_login();
        $response = $this->get('/api/v1/availability/1');
        $response->assertStatus(401);
        // $response->dump();
    }
}
