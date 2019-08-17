<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Favorite;
use App\Search;

class FavoritesTest extends TestCase
{
    public function testResponse() {
        $user = User::first();
        // Favorites is protected
        $response = $this->actingAs($user)->get('/favorites');
        $response->assertStatus(200);
    }

    public function testFavoritesAPI() {
        Favorite::truncate();
        $user = User::first();

        // Should abort when no id
        $response = $this->actingAs($user)->get('api/favorite');
        $response->assertStatus(404);
        
        // Should abort when invalid id
        $response = $this->actingAs($user)->get('api/favorite?id=invalid');
        $response->assertStatus(404);
        
        // Get some test data
        $response = $this->actingAs($user)->get('/api/search/?q=strong');
        $results = $response->json();
        // Should add favorite
        $response = $this->actingAs($user)->get('api/favorite?id='.$results[0]['id']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'added'
        ]);

        // Should have a favorite with first id
        $favorites = $user->get_favorites();
        $this->assertTrue( in_array($results[0]['id'], $favorites) );
        // Should remove favorite
        $response = $this->actingAs($user)->get('api/favorite?id='.$results[0]['id']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'removed'
        ]);

        // Should not have a favorite with first id
        $favorites = $user->get_favorites();
        $this->assertTrue( !in_array($results[0]['id'], $favorites) );

        // Remove test data
        Favorite::truncate();
        Search::truncate();
    }

    public function testRemoveFavorite() {
        Favorite::truncate();
        $user = User::first();

        // Should abort when no id
        $response = $this->actingAs($user)->get('remove_favorite');
        $response->assertStatus(404);
        
        // Get some test data
        $response = $this->actingAs($user)->get('/api/search/?q=strong');
        $results = $response->json();
        // Save favorite
        $favorite = new Favorite();
        $favorite->gif_id = $results[0]['id'];
        $user->favorites()->save($favorite);
        
        // Assert favorite was added correctly
        $favorites = $user->get_favorites();
        $this->assertTrue( in_array($results[0]['id'], $favorites) );
        
        // Should remove favorite
        $response = $this->actingAs($user)->get('remove_favorite?id='.$results[0]['id']);
        $response->assertStatus(302); // redirects to favorites
        $response->assertLocation('/favorites');
        
        // Assert favorite has been removed
        $favorites = $user->get_favorites();
        $this->assertTrue( !in_array($results[0]['id'], $favorites) );

        // Remove test data
        Favorite::truncate();
        Search::truncate();
    }
}
