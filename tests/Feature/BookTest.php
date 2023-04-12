<?php

namespace Tests\Feature;

use Tests\TestCase;
use \App\Models\Book;

/**
 * Description of BookTest
 *
 * @author chaluchukwu
 */
class BookTest extends TestCase {

    private $book1;
    private $book2;
    private $book3;
    private $book4;

    function __construct($name)
    {
	parent::__construct($name);
	parent::setUp();
    }

    function setUp(): void
    {
	Book::truncate();
	$data1 = [
	    "name" => "nice book",
	    "isbn" => "34443-43434-3434",
	    "authors" => ["first guy", "another writer"],
	    "country" => "Nigeria",
	    "number_of_pages" => 1024,
	    "publisher" => "orizu",
	    "release_date" => "2020-10-02"
	];
	$data2 = [
	    "name" => "bad book",
	    "isbn" => "40943-24434-5341",
	    "authors" => ["first guy", "another writer"],
	    "country" => "Ghana",
	    "number_of_pages" => 512,
	    "publisher" => "chaluchukwu",
	    "release_date" => "2022-10-02"
	];
	$data3 = [
	    "name" => "third book",
	    "isbn" => "33423-43434-8834",
	    "authors" => ["awesome author"],
	    "country" => "Canada",
	    "number_of_pages" => 256,
	    "publisher" => "ekene",
	    "release_date" => "2022-10-02"
	];
	$data4 = [
	    "name" => "bad book",
	    "isbn" => "34734-24434-5231",
	    "authors" => ["awesome author"],
	    "country" => "Ghana",
	    "number_of_pages" => 514,
	    "publisher" => "chaluchukwu",
	    "release_date" => "2022-08-15"
	];
	$this->book1 = Book::create($data1);
	$this->book2 = Book::create($data2);
	$this->book3 = Book::create($data3);
	$this->book4 = Book::create($data4);
    }

    /** @test */
    public function createsBookInDataBase()
    {
	$data = [
	    "name" => "nice book",
	    "isbn" => "93220-4234-3434",
	    "authors" => ["first guy", "another writer"],
	    "country" => "Nigeria",
	    "number_of_pages" => 1024,
	    "publisher" => "chaluchukwu Enterprise",
	    "release_date" => "2020-10-02"
	];
	$response = $this->post('/api/v1/books', $data);
	$response->assertStatus(200);
	$dbItem = Book::find($response->json("data")["id"]);  // what was saved by the application into the db
	$response->assertExactJson([
	    "status" => "success",
	    "status_code" => 201,
	    "data" => $dbItem->toArray()], true); // ensure what is sent back is what was saved in the database
	$data["id"] = $response->json("data")["id"];  //attach the id and other auto-generated fields and compare input with what the server actually saved
	$data["created_at"] = $response->json("data")["created_at"];
	$data["updated_at"] = $response->json("data")["updated_at"];
	$this->assertEquals($data, $dbItem->toArray()); // ensure that what we sent is what what saved
    }

    /** @test */
    public function retrievesBooksFromDataBase()
    {
	$response = $this->get('/api/v1/books');
	$response->assertStatus(200);
	$response->assertExactJson([
	    "status" => "success",
	    "status_code" => 200,
	    "data" => [$this->book1->toArray(), $this->book2->toArray(), $this->book3->toArray(), $this->book4->toArray()]], true); // ensure what is sent back is what was in the database
    }

    /** @test */
    public function filtersBooksByAttributes()
    {
	$response1 = $this->get("/api/v1/books?year=2022&publisher=chaluchukwu");
	$response1->assertStatus(200);
	$response1->assertExactJson([
	    "status" => "success",
	    "status_code" => 200,
	    "data" => [$this->book2->toArray(), $this->book4->toArray()]], true); // ensure what is sent back is what was in the database
	$response2 = $this->get("/api/v1/books?name=nice+book");
	$response2->assertStatus(200);
	$response2->assertExactJson([
	    "status" => "success",
	    "status_code" => 200,
	    "data" => [$this->book1->toArray()]], true); // ensure what is sent back is what was in the database
    }
    /** @test */
    public function returnsEmptyArrayWhenNoBooksFound()
    {
	Book::truncate();  // Remove all books
	$response = $this->get("/api/v1/books");
	$response->assertStatus(200);
	$response->assertExactJson([
	    "status" => "success",
	    "status_code" => 200,
	    "data" => []], true); // ensure what is sent back is what was in the database
    }
    /** @test */
    public function getsBookById()
    {
	
	$response = $this->get("/api/v1/books/{$this->book3->id}");
	$response->assertStatus(200);
	$response->assertExactJson([
	    "status" => "success",
	    "status_code" => 200,
	    "data" => $this->book3->toArray()], true); // ensure what is sent back is what was in the database
    }

/** @test */

    public function updatesBookById()
    {
	
	$response = $this->patch("/api/v1/books/{$this->book4->id}", ["name" => "changed book", "authors" => ["chaluchukwu", "ekene"]]);
	$updated = clone $this->book4;
	$updated->name = "changed book";
	$updated->authors = ["chaluchukwu", "ekene"];
	$response->assertStatus(200);
	$response->assertExactJson([
	    "status" => "success",
	    "status_code" => 200,
	    "message" => "The book changed book was updated successfully",
	    "data" => $updated->toArray()], true); // ensure what is sent back reflects changes

	$this->assertEquals($updated->toArray(), Book::find($this->book4->id)->toArray()); // ensure that the database record was actually updated
    }
/** @test */
    public function deletesBookById()
    {
	$response = $this->delete("/api/v1/books/{$this->book1->id}");
	$updated = clone $this->book1;
	$updated->name = "changed book";
	$updated->authors = ["chaluchukwu", "ekene"];
	$response->assertStatus(200);
	$response->assertExactJson([
	    "status" => "success",
	    "status_code" => 204,
	    "message" => "The book nice book was deleted successfully",
	    "data" => []], true); // ensure what is sent back reflects changes

	$this->assertEquals(null, Book::find($this->book1->id)); // ensure that the database record was actually deleted
    }

}
