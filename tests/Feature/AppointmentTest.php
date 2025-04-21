<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AppointmentTest extends TestCase
{
    use LoginTraitForTest;

    #[Test]
    public function host_can_not_create_appointment(): void
    {
        $this->host_login();
        $response = $this->post('/api/v1/appointments', [
            'date' => now()->format('Y-m-d'),
            'note' => "note",
            'guest_id' => 2,
            'avaiability_id' => 1,
        ]);
        $response->assertStatus(401);
        // $response->dump();
    }

    #[Test]
    public function guest_can_create_appointment(): void
    {
        $this->guest_login();
        $response = $this->post('/api/v1/appointments', [
            'date' => now()->format('Y-m-d'),
            'note' => "note",
            'guest_id' => 2,
            'avaiability_id' => 1,
        ]);
        $response->assertStatus(201);
        // $response->dump();
    }

    #[Test]
    public function host_can_get_appointment(): void
    {
        $this->host_login();
        $response = $this->get('/api/v1/appointments');
        $response->assertStatus(200);
        // $response->dump();
    }

    #[Test]
    public function guest_can_not_get_appointment(): void
    {
        $this->guest_login();
        $response = $this->get('/api/v1/appointments');
        $response->assertStatus(401);
        // $response->dump();
    }

    #[Test]
    public function host_can_update_appointment_status(): void
    {
        $this->host_login();
        $response = $this->put('/api/v1/appointments/status', [
            'status' => 'confirmed',
            'appointment_id' => 1,
        ]);
        $response->assertStatus(200);
        // $response->dump();
    }

    #[Test]
    public function guest_can_not_update_appointment_status(): void
    {
        $this->guest_login();
        $response = $this->put('/api/v1/appointments/status', [
            'status' => 'confirmed',
            'appointment_id' => 1,
        ]);
        $response->assertStatus(401);
        // $response->dump();
    }
}
