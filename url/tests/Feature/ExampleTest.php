<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTestCreateLine()
    {
		global $uniqid;
		$uniqid = uniqid();
		$response = $this->json('POST', '/api/createLink', ['url' => 'http://'. $uniqid. '.ru']);
		$response
            ->assertStatus(200)->assertSuccessful();
    }
	public function testBasicTestChangeLine()
	{
		$last2 = DB::table('links')->orderBy('id', 'DESC')->first();
		$response = $this->json('PUT', '/api/changeLink/'. (string)$last2->id,['code' => 'test']);
		$response
            ->assertStatus(200)->assertSuccessful();
			return $last2->id;
	}
	public function testBasicTestGetLink()
	{
		$response = $this->json('get', '/api/getLink/'. $this->testBasicTestChangeLine(), []);
		$response
            ->assertStatus(200)->assertSuccessful();
	}
	public function testBasicTestDeleteLine()
	{
		$response = $this->json('DELETE', '/api/deleteLink/'. $this->testBasicTestChangeLine(), []);
		$response
            ->assertStatus(200)->assertSuccessful();
	}
	public function testBasicTestShowAllLinks(){
	   $response = $this->get('/api/showAllLinks');

        $response
            ->assertStatus(200)->assertSuccessful();;
	}
}
