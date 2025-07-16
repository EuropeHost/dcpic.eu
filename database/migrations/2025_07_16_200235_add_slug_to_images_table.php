<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Image;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('slug', 7)->unique()->nullable()->after('id');
        });
		
        Image::cursor()->each(function (Image $image) {
            if (empty($image->slug)) {
                $image->slug = Str::random(7);
                $image->saveQuietly(); // avoid triggering events
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
