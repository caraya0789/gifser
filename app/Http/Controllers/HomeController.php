<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\GiphyAPI;
use App\Search;
use App\Favorite;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the search form
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the user favorites
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function favorites()
    {
        $api = GiphyAPI::get_instance();
        $favorites = $api->get_by_ids(\Auth::user()->get_favorites());
        return view('favorites', [
            'favorites' => $favorites
        ]);
    }

    /**
     * Show the user search history
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function history()
    {
        return view('history', [
            'searches' => \Auth::user()->searches()->orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Show a single gif
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function single( $id )
    {
        return view('single');
    }

    /**
     * Search API endpoint handler
     */
    public function search( Request $request )
    {
        $api = GiphyAPI::get_instance();
        $results = $api->search( $request->input('q'), $request->input('p', 1) );

        // if this is the first page
        if(!$request->input('p', false)) {
            $search = new Search();
            $search->query = $request->input('q');

            \Auth::user()->searches()->save($search);
        }

        // Set favorites
        if(count($results) > 0) {
            $favorites = \Auth::user()->get_favorites();
            foreach($results as &$result) {
                $result['favorite'] = in_array($result['id'], $favorites);
            }
        }

        return $results;
    }

    /**
     * Favorite Toggle API endpoint handler
     */
    public function favorite( Request $request )
    {
        $id = $request->input('id', false);
        // Exit if no id
        if(!$id) abort(404);

        $favorites = \Auth::user()->get_favorites();
        if( in_array( $id, $favorites ) ) {
            // remove
            \Auth::user()->favorites()->where('gif_id', $id)->delete();
        } else {
            // add
            $favorite = new Favorite();
            $favorite->gif_id = $id;
            \Auth::user()->favorites()->save($favorite);
        }
        return [];
    }

    public function remove_favorite( Request $request ) {
        $id = $request->input('id', false);
        // Exit if no id
        if(!$id) abort(404);

        $favorites = \Auth::user()->get_favorites();
        if( in_array( $id, $favorites ) ) {
            // remove
            \Auth::user()->favorites()->where('gif_id', $id)->delete();
            return redirect( route('favorites') );
        }

        abort(404);
    }
}
