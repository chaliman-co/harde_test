<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Book;

class BooksController extends Controller
{
    function create(Request $request) {
	$data = $request->validate([
	    "name" => "string",
	    "isbn" => "required|unique:books",
	    "authors" => "required|array",
	    "country" => "required|string",
	    "number_of_pages" => "required|integer",
	    "publisher" => "required|string",
	    "release_date" => "required|date"
	]);
	$book = Book::create($data);
	return $this->success($book, statusCode : 201);
    }
    function get(Request $request) {
	$query = Book::query();
	if ($request->query("name")) $query->where("name", "=", $request->query("name"));
	if ($request->query("country")) $query->where("country", "=", $request->query("country"));
	if ($request->query("publisher")) $query->where("publisher", "=", $request->query("publisher"));
	if ($request->query("release_date")) $query->whereRaw("year(release_date)=" . $request->query("release_date"));
	if ($request->query("limit")) $query->limit ($request->query("limit"));
	return $this->success($query->get());
    }
    function getById(Request $request, $id) {
	$book = Book::where("id", $id)->first();
	return $this->success($book);
    }
    function update(Request $request, $id) {
	$update = $request->validate([
	    "name" => "string",
	    "isbn" => "",
	    "authors" => "array",
	    "country" => "string",
	    "number_of_pages" => "integer",
	    "publisher" => "string",
	    "release_date" => "date"
	]);
	$book = Book::where("id", $id)->first();
	if (array_key_exists("name", $update)) $book->name = $update["name"];
	if (array_key_exists("isbn", $update)) $book->isbn = $update["isbn"];
	if (array_key_exists("authors", $update)) $book->authors = $update["authors"];
	if (array_key_exists("country", $update)) $book->country = $update["country"];
	if (array_key_exists("number_of_pages", $update)) $book->number_of_pages = $update["number_of_pages"];
	if (array_key_exists("publisher", $update)) $book->publisher = $update["publisher"];
	if (array_key_exists("release_date", $update)) $book->release_date = $update["release_date"];
	$book->save();
	return $this->success($book, message: "The book $book->name was updated successfully");
    }
    function delete(Request $request, $id) {
	$book = Book::where("id", $id)->first();
	$book->delete();
	return $this->success([], message: "The book $book->name was deleted successfully", statusCode: 204);
    }
}
