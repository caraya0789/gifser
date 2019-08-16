<?php

namespace App\Library;

use GuzzleHttp\Client;

class GiphyAPI {

	const LIMIT = 12;

	protected static $_instance;

	public static function get_instance() {
		if( null === self::$_instance )
			self::$_instance = new self();

		return self::$_instance;
	}

	public function search( $query, $page = 1 ) {
		$images = [];

		$client = new Client();
		
		$response = $client->get( 'https://api.giphy.com/v1/gifs/search', [
			'query' => [
				'api_key' => env( 'GIPHY_APIKEY', '' ),
				'q' => $query,
				'limit' => self::LIMIT,
				'offset' => (self::LIMIT * ($page - 1))
			]
		]);

		if($response->getStatusCode() !== 200)
			return $images;

		$result = json_decode((string) $response->getBody(), true);
		if(count($result['data']) === 0)
			return $images;

		foreach($result['data'] as $img) {
			$images[] = [
				'id' => $img['id'],
				'url' => $img['images']['fixed_height']['url'],
				'title' => $img['title'],
				'favorite' => false
			];
		}

		return $images;
	}

}