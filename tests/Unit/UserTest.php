<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Favorite;
use App\Search;

class UserTest extends TestCase
{
    public function testRelations()
    {
    	Search::truncate();
    	Favorite::truncate();

        $user = User::first();

        $this->assertInstanceOf( 'Illuminate\Database\Eloquent\Relations\HasMany', $user->favorites() );
        $this->assertInstanceOf( 'Illuminate\Database\Eloquent\Relations\HasMany', $user->searches() );

        $fav = new Favorite();
        $fav->gif_id = 'test';
        $fav->user_id = $user->id;
        $fav->save();

        $ser = new Search();
        $ser->query = 'test';
        $ser->user_id = $user->id;
        $ser->save();

        $favorites = $user->favorites()->get();
        $searches = $user->searches()->get();

        $this->assertTrue( count($favorites) === 1 );
        $this->assertTrue( count($searches) === 1 );

        Search::truncate();
    	Favorite::truncate();
    }

    public function testGetFavorites() {
    	Search::truncate();
    	Favorite::truncate();

        $user = User::first();

        $fav = new Favorite();
        $fav->gif_id = 'test';
        $fav->user_id = $user->id;
        $fav->save();

        $fav = new Favorite();
        $fav->gif_id = 'test2';
        $fav->user_id = $user->id;
        $fav->save();

        // This one should be ignored
        $fav = new Favorite();
        $fav->gif_id = 'test3';
        $fav->user_id = 0;
        $fav->save();

        $favorites = $user->get_favorites();
        $this->assertTrue( count($favorites) === 2 );
        $this->assertTrue( $favorites === ['test', 'test2'] );

        Search::truncate();
    	Favorite::truncate();
    }
}
