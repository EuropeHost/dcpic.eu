<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Link;
use App\Models\LinkView;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        // Create normal users
        User::factory(10)->create()->each(function ($user) {
            // Create images for each user
            Image::factory(rand(5, 20))->create([
                'user_id' => $user->id,
            ]);

            // Create links for each user
            Link::factory(rand(5, 20))->create([
                'user_id' => $user->id,
            ])->each(function ($link) {
                // Create link views for each link
                LinkView::factory(rand(10, 100))->create([
                    'link_id' => $link->id,
                ]);
            });
        });
    }
}
