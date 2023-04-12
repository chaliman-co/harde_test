<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
	    $table->string("name", 200);
	    $table->string("isbn", 18);
	    $table->json("authors");
	    $table->string("country", 200);
	    $table->integer("number_of_pages");
	    $table->string("publisher", 200);
	    $table->date("release_date");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
