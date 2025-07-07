<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        // Add uuid column to users
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->nullable()->after('id');
        });

        // Add uuid column to images
        Schema::table('images', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->nullable()->after('id');
            $table->uuid('user_uuid')->nullable()->after('user_id');
        });

        // Fill UUID columns with generated UUIDs
        DB::table('users')->get()->each(function ($user) {
            DB::table('users')
              ->where('id', $user->id)
              ->update(['uuid' => (string) Str::uuid()]);
        });

        DB::table('images')->get()->each(function ($image) {
            $user = DB::table('users')->where('id', $image->user_id)->first();
            DB::table('images')
              ->where('id', $image->id)
              ->update([
                  'uuid' => (string) Str::uuid(),
                  'user_uuid' => $user->uuid ?? null
              ]);
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'user_uuid']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
