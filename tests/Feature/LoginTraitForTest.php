<?php

namespace Tests\Feature;


trait LoginTraitForTest
{
    private function host_login(): void
    {
        $response = $this->post('/api/v1/login', [
            'email' => 'host@example.com',
            'password' => 'password',
        ]);
    }
    private function guest_login(): void
    {
        $response = $this->post('/api/v1/login', [
            'email' => 'guest@example.com',
            'password' => 'password',
        ]);
    }
}
