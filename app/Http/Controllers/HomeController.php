<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\GiphyAPI;

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
        return view('favorites');
    }

    /**
     * Show the user search history
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function history()
    {
        return view('history');
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
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search( Request $request )
    {
        $api = GiphyAPI::get_instance();
        $results = $api->search( $request->input('q') );
        return $results;
    }
}
