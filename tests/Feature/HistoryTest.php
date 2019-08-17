<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Search;

class HistoryTest extends TestCase
{
    public function testResponse() {
        $user = User::first();

        // history is protected
        $response = $this->actingAs($user)->get('/history');
        $response->assertStatus(200);
    }

    public function testHistory() {
        Search::truncate();
        $user = User::first();

        $searches = $user->searches()->get();
        $this->assertTrue( count($searches) === 0 );
        
        // Create some history
        $this->actingAs($user)->get('/api/search?q=crossfit');
        // These should not be recorded as they are pagination
        $this->actingAs($user)->get('/api/search?q=strong&p=2');
        $this->actingAs($user)->get('/api/search?q=strong&p=3');

        // Should have one record
        $searches = $user->searches()->get();
        $this->assertTrue( count($searches) === 1 );

        // View should have the "strong" query
        $response = $this->actingAs($user)->get('/history');
        $response->assertSeeText('crossfit');

        Search::truncate();
    }
}
