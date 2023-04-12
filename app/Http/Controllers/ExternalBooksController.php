<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use \Illuminate\Http\Request;
use Illuminate\Http\Client\Request as ClientRequest;

    define ("API_URL", "https://www.anapioficeandfire.com/api");
class ExternalBooksController extends Controller
{
    function getBook(Request $request) {
	$query = http_build_query($request->query());
	$apiReq = Http::get(API_URL . "/books?$query");
	return $this->success($apiReq->json());
    }
}
