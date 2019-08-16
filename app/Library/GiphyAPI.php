<?php

namespace App\Library;

use GuzzleHttp\Client;

class GiphyAPI {

	const LIMIT = 12;

	protected static $_instance;

	protected $_client;

	protected $_api_key;

	protected $_base;

	public static function get_instance() {
		if( null === self::$_instance )
			self::$_instance = new self();

		return self::$_instance;
	}

	public function __construct() {
		$this->_client = new Client();
		$this->_base = "https://api.giphy.com/v1/";
		$this->_api_key = env('GIPHY_APIKEY', '');
	}

	public function get_by_ids( $ids ) {
		if( !count($ids) )
			return [];

		$result = $this->_query( 'gifs', [
			'ids' => implode(',', $ids)
		]);

		return $this->_parseImages( $result );
	}

	public function search( $query, $page = 1 ) {
		$result = $this->_query( 'gifs/search', [
			'q' => $query,
			'limit' => self::LIMIT,
			'offset' => (self::LIMIT * ($page - 1))
		]);

		return $this->_parseImages( $result );
	}

	protected function _parseImages( $result ) {
		if( !isset( $result['data'] ) || count($result['data']) === 0)
			return [];

		$images = [];

		foreach($result['data'] as $img) {
			$images[] = [
				'id' => $img['id'],
				'url' => $img['images']['fixed_height']['url'],
				'title' => $img['title']
			];
		}

		return $images;
	}

	protected function _query($endpoint, $data) {
		$data['api_key'] = $this->_api_key;

		$response = $this->_client->get( $this->_base . $endpoint, [
			'query' => $data
		]);

		if($response->getStatusCode() !== 200)
			return [];

		$result = json_decode((string) $response->getBody(), true);
		if(count($result['data']) === 0)
			return [];

		return $result;
	}

}