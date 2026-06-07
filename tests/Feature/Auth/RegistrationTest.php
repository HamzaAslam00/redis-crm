<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_redirects_to_login(): void
    {
        // Public registration is disabled — the /register route redirects to login.
        // New users are created by an admin via the Users CRUD.
        $response = $this->get('/register');

        $response->assertRedirect(route('login'));
    }

    public function test_self_registration_is_not_possible(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
    }
}
