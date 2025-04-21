<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\LoginTraitForTest;
use PHPUnit\Framework\Attributes\Test;

class BookingTest extends TestCase
{
    use LoginTraitForTest;

    #[Test]
    public function host_can_create_booking_link(): void
    {
        $this->host_login();
        $response = $this->post('/api/v1/booking-links', [
            'slug' => 'test-slug',
            'host_id' => 1,
            'note' => 'test note',
            'duration' => 30,
            'price' => 100,
        ]);
        $response->assertStatus(201);
        // $response->dump();
    }

    #[Test]
    public function guest_can_not_create_booking_link(): void
    {
        $this->guest_login();
        $response = $this->post('/api/v1/booking-links', [
            'slug' => 'test-slug',
            'host_id' => 1,
            'note' => 'test note',
            'duration' => 30,
            'price' => 100,
        ]);
        $response->assertStatus(401);
        // $response->dump();
    }

    #[Test]
    public function guest_can_get_booking_link(): void
    {
        $this->guest_login();
        $response = $this->get('/api/v1/booking-links/test-slug');
        $response->assertStatus(404);
        // $response->dump();
    }
}
