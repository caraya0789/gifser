<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ShareTest extends TestCase
{
    public function testRedirects()
    {
        // Sharable Link redirect
        $shareResponse = $this->get('/someid');
        $shareResponse->assertStatus(301);
        $shareResponse->assertLocation('/view/someid');
        // No id provided Redirect
        $singleSEORedirectResponse = $this->get('/view');
        $singleSEORedirectResponse->assertStatus(301);
        $singleSEORedirectResponse->assertLocation('/');
    }

    public function testResponse() {
        $user = User::first();
        // invalid id should be not found
        $response = $this->actingAs($user)->get('/view/invalid');
        $response->assertStatus(404);
        // valid id should work
        $response = $this->actingAs($user)->get('/view/gw3IWyGkC0rsazTi');
        $response->assertStatus(200);
    }
}
