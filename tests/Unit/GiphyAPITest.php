<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Library\GiphyAPI;

class GiphyAPITest extends TestCase
{
    public function testInstance()
    {
        $api = GiphyAPI::get_instance();
        $this->assertInstanceOf('App\Library\GiphyAPI', $api);
    }

    public function testSearch() {
    	$api = GiphyAPI::get_instance();
    	// Empty query should have no results
    	$results = $api->search('');
    	$this->assertTrue( count($results) === 0 );

    	// good query should have LIMIT results
    	$results = $api->search('strong');
    	$this->assertTrue( count($results) === GiphyAPI::LIMIT );

    	// pagination results should be different
    	$results2 = $api->search('strong', 2);
    	$this->assertTrue( $results[0]['id'] !== $results2[0]['id'] );
    }

    public function testGetById() {
    	$api = GiphyAPI::get_instance();

    	// Empty ids should return empty results
    	$results = $api->get_by_ids('');
    	$this->assertTrue( count($results) === 0 );
    	
    	// Empty array should return empty results
    	$results = $api->get_by_ids([]);
    	$this->assertTrue( count($results) === 0 );
    	
    	// Should be able to find a single
    	$results = $api->get_by_ids('gw3IWyGkC0rsazTi');
		$this->assertTrue( count($results) === 1 );
		
		// Should be able to find a single item in an array
		$results = $api->get_by_ids(['gw3IWyGkC0rsazTi']);
		$this->assertTrue( count($results) === 1 );
		
		// Should be able to find multiple items in an array
		$results = $api->get_by_ids(['M7oKkaur56EFO', 'Ub4kWebdWWJP2', 'xThuWmih18AgwVxqxi']);
		$this->assertTrue( count($results) === 3 );
		
		// Should be able to find multiple items in a string separates by ,
		$results = $api->get_by_ids('M7oKkaur56EFO,Ub4kWebdWWJP2,xThuWmih18AgwVxqxi');
		$this->assertTrue( count($results) === 3 );
		
		// invalid or not found ids should return empty results
		$results = $api->get_by_ids('somethinginvalid');
		$this->assertTrue( count($results) === 0 );
		
		// invalid or not found ids should return empty results or be ignored
		$results = $api->get_by_ids('M7oKkaur56EFO,somethinginvalid');
		$this->assertTrue( count($results) === 1 );
    }

    public function testImageSize() {
    	$api = GiphyAPI::get_instance();
    	$result1 = $api->get_by_ids('gw3IWyGkC0rsazTi');
    	$result2 = $api->get_by_ids('gw3IWyGkC0rsazTi', 'full');
    	$result3 = $api->get_by_ids('gw3IWyGkC0rsazTi', 'any');

    	// URL should be different, different sizes
    	$this->assertTrue( $result1[0]['url'] !== $result2[0]['url'] );

    	// URL should be equal, sinze only full size should return diff image
    	$this->assertTrue( $result1[0]['url'] == $result3[0]['url'] );
    }
}
