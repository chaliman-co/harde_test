<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExternalBooksController;
use App\Http\Controllers\v1\BooksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

    Route::get("/external-books", [ExternalBooksController::class, "getBook"]);
Route::group(['prefix' => 'v1'], function () {
    Route::post("/books", [BooksController::class, "create"]);
    Route::get("/books", [BooksController::class, "get"]);
    Route::get("/books/{id}", [BooksController::class, "getById"]);
    Route::patch("/books/{id}", [BooksController::class, "update"]);
    Route::delete("/books/{id}", [BooksController::class, "delete"]);
});
