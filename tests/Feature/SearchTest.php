<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Search;

class SearchTest extends TestCase
{
    public function testResponse() {
        $user = User::first();

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    public function testSearch() {
        $user = User::first();
        // Empty query
        $response = $this->actingAs($user)->get('/api/search');
        $response->assertJsonCount(0);

        // Got Results
        $response = $this->actingAs($user)->get('/api/search/?q=strong');
        $response->assertJsonCount(12);
        $firstpage = $response->json();
        // pagination
        $response = $this->actingAs($user)->get('/api/search/?q=strong&p=2');
        $response->assertJsonCount(12);
        $secondpage = $response->json();
        // validate pagination
        $this->assertTrue( $firstpage[0]['id'] !== $secondpage[0]['id'] );

        // Remove log
        Search::truncate();
    }
}
