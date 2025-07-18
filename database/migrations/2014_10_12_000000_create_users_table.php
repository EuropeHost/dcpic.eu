<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
	{
	    Schema::create('users', function (Blueprint $table) {
	        $table->uuid('id')->primary();
	        $table->string('name');
	        $table->string('email')->nullable()->unique();
	        $table->string('discord_id')->unique();
	        $table->string('avatar')->nullable();
	        $table->rememberToken();
	        $table->timestamps();
	    });
	}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
