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
	    Schema::create('images', function (Blueprint $table) {
	        $table->uuid('id')->primary();
	        $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
	        $table->string('filename')->unique();
	        $table->string('original_name');
	        $table->string('mime');
	        $table->unsignedBigInteger('size');
	        $table->timestamps();
	    });
	}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
