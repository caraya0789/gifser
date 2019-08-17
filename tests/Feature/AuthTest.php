<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class AuthTest extends TestCase
{
    public function testRedirects()
    {
        // Home is protected
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertLocation('/login');

        // Favorites is protected
        $response = $this->get('/favorites');
        $response->assertStatus(302);
        $response->assertLocation('/login');
        
        // remove_favorite is protected
        $response = $this->get('/remove_favorite');
        $response->assertStatus(302);
        $response->assertLocation('/login');
        
        // history is protected
        $response = $this->get('/history');
        $response->assertStatus(302);
        $response->assertLocation('/login');
        
        // single is protected
        $response = $this->get('/view/someid');
        $response->assertStatus(302);
        $response->assertLocation('/login');
    }

    public function testAuthRoutes() {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function testLoggedinRedirects() {
        $user = User::first();

        $response = $this->actingAs($user)->get('/login');
        $response->assertStatus(302);
        $response->assertLocation('/');

        $response = $this->actingAs($user)->get('/register');
        $response->assertStatus(302);
        $response->assertLocation('/');
    }
}
