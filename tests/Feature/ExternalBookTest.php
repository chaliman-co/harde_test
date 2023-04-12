<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Description of ExternalBookTest
 *
 * @author chaluchukwu
 */
class ExternalBookTest extends TestCase {

    /** @test */
    public function getsBookFromExternalApi()
    {
	$expected = json_decode(file_get_contents(__DIR__ . "/game_of_thrones.json"), true);
	$response = $this->get("/api/external-books?name=A+Game+of+Thrones");
	$response->assertStatus(200);
	$this->assertEquals($response->json(), [
	    "status" => "success",
	    "status_code" => 200,
	    "data" => [$expected]
	], true); // ensure the response is what is on the external api.
    }

}
