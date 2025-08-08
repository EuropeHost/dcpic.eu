<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User; // Assuming you have a User model
use App\Models\Image; // Assuming you have an Image model

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define new UUIDs for the specific users based on their OLD IDs
        // These UUIDs are fixed for consistency if the users are newly inserted.
        // If users already exist by discord_id, their actual DB UUID will be used for linking.
        $userMappings = [
            1 => 'f1551328-973f-4a77-8e47-f386ca71ca03', // UUID for michaelninder_yt (old ID 1)
            2 => 'a0b1c2d3-e4f5-6789-abcd-ef0123456789', // New UUID for jonas.xd_ (old ID 2) - **Please change if this conflicts or you have an existing UUID for Jonas**
            3 => 'fedcba98-7654-3210-fedc-ba9876543210', // New UUID for oel30007 (old ID 3) - **Please change if this conflicts or you have an existing UUID for Oel**
        ];

        // --- Users Data to be inserted (if they don't exist by discord_id) ---
        $usersToSeed = [
            [
                'id' => $userMappings[1], // Predefined UUID for michaelninder_yt
                'name' => 'michaelninder_yt',
                'email' => 'fabianeternis@gmail.com',
                'discord_id' => '1189658618761580664',
                'avatar' => '1ecd5b4a56614339ea64c87d10d84c0f',
                'created_at' => Carbon::parse('2025-05-22 19:44:16'),
                'updated_at' => Carbon::parse('2025-05-22 19:44:16'),
            ],
            [
                'id' => $userMappings[2], // New UUID for jonas.xd_
                'name' => 'jonas.xd_',
                'email' => 'jonasplayer1@outlook.de',
                'discord_id' => '1275032645306155040',
                'avatar' => 'a_3b372dde6de52b6219cdec8216939446',
                'created_at' => Carbon::parse('2025-05-25 07:19:43'),
                'updated_at' => Carbon::parse('2025-05-25 07:19:43'),
            ],
            [
                'id' => $userMappings[3], // New UUID for oel30007
                'name' => 'oel30007',
                'email' => 'oel3006@gmail.com',
                'discord_id' => '1332450921497493605',
                'avatar' => 'd9321d80fafd3905c6341589cd3c4693',
                'created_at' => Carbon::parse('2025-05-25 07:20:05'),
                'updated_at' => Carbon::parse('2025-05-25 07:20:05'),
            ],
        ];

        // This array will hold the actual UUIDs from the DB,
        // whether they were newly inserted or already existed.
        $actualUserUuids = [];

        foreach ($usersToSeed as $userData) {
            $existingUser = User::where('discord_id', $userData['discord_id'])->first();

            if (!$existingUser) {
                DB::table('users')->insert($userData);
                $actualUserUuids[$userData['discord_id']] = $userData['id']; // Use the ID we just inserted
                $this->command->info('Inserted user: ' . $userData['name'] . ' (UUID: ' . $userData['id'] . ')');
            } else {
                $actualUserUuids[$userData['discord_id']] = $existingUser->id; // Use existing UUID from DB
                $this->command->info('User already exists: ' . $userData['name'] . ' (Existing UUID: ' . $existingUser->id . ')');
            }
        }

        // Map old user IDs to their respective Discord IDs for easier lookup
        $oldIdToDiscordIdMap = [
            1 => '1189658618761580664', // michaelninder_yt
            2 => '1275032645306155040', // jonas.xd_
            3 => '1332450921497493605', // oel30007
        ];


        // --- Images Data to be inserted (if they don't exist by filename) ---
        $imagesToSeed = [
            // List of images as provided, with their old_user_id
            [
                'old_image_id' => 2, 'old_user_id' => 1, 'type' => 'image', 'filename' => '1c5dc930-653d-4d04-bb06-8ad1acc2cc6d.png', 'original_name' => 'Bildschirmfoto 2024-12-17 um 14.10.29.png', 'mime' => 'image/png', 'size' => 1527016, 'is_public' => 1, 'created_at' => '2025-05-24 04:47:08', 'updated_at' => '2025-05-26 18:15:48',
            ],
            [
                'old_image_id' => 3, 'old_user_id' => 1, 'type' => 'image', 'filename' => '3c9f0fa5-9e82-451a-b1f9-4fef5c1f9494.jpg', 'original_name' => 'flxshed logo.jpg', 'mime' => 'image/jpeg', 'size' => 7494, 'is_public' => 0, 'created_at' => '2025-05-24 17:54:11', 'updated_at' => '2025-05-24 17:54:11',
            ],
            [
                'old_image_id' => 4, 'old_user_id' => 1, 'type' => 'image', 'filename' => '143b2f9e-9945-4938-9c61-28c077a72c87.png', 'original_name' => 'Handshake.png', 'mime' => 'image/png', 'size' => 841917, 'is_public' => 0, 'created_at' => '2025-05-24 17:55:35', 'updated_at' => '2025-05-24 17:55:35',
            ],
            [
                'old_image_id' => 5, 'old_user_id' => 1, 'type' => 'image', 'filename' => '0647da89-2223-4e54-bc68-59d1a862b636.gif', 'original_name' => 'Fire.gif', 'mime' => 'image/gif', 'size' => 437337, 'is_public' => 0, 'created_at' => '2025-05-24 18:08:14', 'updated_at' => '2025-05-24 18:08:14',
            ],
            [
                'old_image_id' => 6, 'old_user_id' => 1, 'type' => 'image', 'filename' => '1a23e257-b71c-4877-a906-421a8610520e.png', 'original_name' => 'A_large_blank_world_map_with_oceans_marked_in_blue.png', 'mime' => 'image/png', 'size' => 540502, 'is_public' => 0, 'created_at' => '2025-05-24 18:08:40', 'updated_at' => '2025-05-24 18:08:40',
            ],
            [
                'old_image_id' => 7, 'old_user_id' => 1, 'type' => 'image', 'filename' => '7d33da22-f7a0-4a4d-8fb3-d92d72301dde.png', 'original_name' => '1920x1080-sw-bg-4.png', 'mime' => 'image/png', 'size' => 906576, 'is_public' => 0, 'created_at' => '2025-05-24 18:09:14', 'updated_at' => '2025-05-24 18:09:14',
            ],
            [
                'old_image_id' => 8, 'old_user_id' => 1, 'type' => 'image', 'filename' => '1e76a2aa-d304-4798-ab16-9c8874ed7b6f.png', 'original_name' => 'Bildschirmfoto 2024-08-01 um 21.09.42.png', 'mime' => 'image/png', 'size' => 5103164, 'is_public' => 1, 'created_at' => '2025-05-24 18:14:46', 'updated_at' => '2025-05-26 18:15:38',
            ],
            [
                'old_image_id' => 9, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'bd7e0f50-04da-4132-83d8-27a35bb4bc7d.gif', 'original_name' => 'Enchanted_Diamond_Chestplate_(item).gif', 'mime' => 'image/gif', 'size' => 4015275, 'is_public' => 0, 'created_at' => '2025-05-24 18:17:48', 'updated_at' => '2025-05-24 18:17:48',
            ],
            [
                'old_image_id' => 10, 'old_user_id' => 1, 'type' => 'image', 'filename' => '612c8392-1c4c-49c1-8deb-acba7674fc08.gif', 'original_name' => 'Enchanted_Shield_(item).gif', 'mime' => 'image/gif', 'size' => 4052633, 'is_public' => 0, 'created_at' => '2025-05-24 18:18:43', 'updated_at' => '2025-05-24 18:18:43',
            ],
            [
                'old_image_id' => 12, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'bac8ab68-e101-46ab-b2b4-f15d77e22702.png', 'original_name' => 'Bildschirmfoto 2025-05-26 um 15.08.04.png', 'mime' => 'image/png', 'size' => 489718, 'is_public' => 0, 'created_at' => '2025-05-26 11:09:25', 'updated_at' => '2025-05-26 11:09:25',
            ],
            [
                'old_image_id' => 13, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'cc637a46-f3db-478f-9402-b06acadefa2b.png', 'original_name' => 'Bildschirmfoto 2025-05-26 um 15.09.54.png', 'mime' => 'image/png', 'size' => 1194817, 'is_public' => 1, 'created_at' => '2025-05-26 11:10:12', 'updated_at' => '2025-05-26 18:25:01',
            ],
            [
                'old_image_id' => 14, 'old_user_id' => 1, 'type' => 'image', 'filename' => '57b0f216-a7b7-4d05-a110-450500fadeb1.png', 'original_name' => 'Bildschirmfoto 2025-05-26 um 15.10.30.png', 'mime' => 'image/png', 'size' => 1957990, 'is_public' => 0, 'created_at' => '2025-05-26 11:10:43', 'updated_at' => '2025-05-26 11:10:43',
            ],
            [
                'old_image_id' => 15, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'e077343c-06ef-4c71-bdc7-63b9219616ef.png', 'original_name' => 'Bildschirmfoto 2025-05-26 um 15.10.56.png', 'mime' => 'image/png', 'size' => 2292584, 'is_public' => 0, 'created_at' => '2025-05-26 11:11:10', 'updated_at' => '2025-05-26 11:11:10',
            ],
            [
                'old_image_id' => 16, 'old_user_id' => 1, 'type' => 'image', 'filename' => '7acdd2fc-42a5-457b-9796-f7f85d8f68f3.png', 'original_name' => 'Bildschirmfoto 2025-05-26 um 15.11.16.png', 'mime' => 'image/png', 'size' => 2454068, 'is_public' => 0, 'created_at' => '2025-05-26 11:11:30', 'updated_at' => '2025-05-26 11:11:30',
            ],
            [
                'old_image_id' => 17, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'f64c5c8a-007c-4608-ab29-1feac1a69bbe.png', 'original_name' => 'Bildschirmfoto 2025-05-26 um 15.11.35.png', 'mime' => 'image/png', 'size' => 2537624, 'is_public' => 0, 'created_at' => '2025-05-26 11:11:52', 'updated_at' => '2025-05-26 11:11:52',
            ],
            [
                'old_image_id' => 18, 'old_user_id' => 1, 'type' => 'image', 'filename' => '36c3b1ac-7008-40d2-b6f6-3130e6e1ca15.png', 'original_name' => 'Bildschirmfoto 2025-05-26 um 15.58.26.png', 'mime' => 'image/png', 'size' => 241988, 'is_public' => 1, 'created_at' => '2025-05-26 11:58:53', 'updated_at' => '2025-05-26 18:08:11',
            ],
            [
                'old_image_id' => 19, 'old_user_id' => 1, 'type' => 'image', 'filename' => '474b4b85-1cd5-4f20-b8b8-30463f288b57.png', 'original_name' => 'Screenshot 2025-04-05 at 12.05.49.png', 'mime' => 'image/png', 'size' => 1717850, 'is_public' => 0, 'created_at' => '2025-05-27 12:23:56', 'updated_at' => '2025-05-27 12:23:56',
            ],
            [
                'old_image_id' => 20, 'old_user_id' => 1, 'type' => 'image', 'filename' => '42278ec8-3ea2-4e35-9aba-13459ac08988.png', 'original_name' => 'Bildschirmfoto 2025-02-17 um 07.32.17.png', 'mime' => 'image/png', 'size' => 5580947, 'is_public' => 1, 'created_at' => '2025-05-27 12:24:24', 'updated_at' => '2025-05-27 12:24:34',
            ],
            [
                'old_image_id' => 21, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'd8a0adcb-3796-45d7-affc-e26422e9d70c.png', 'original_name' => 'Screenshot 2025-05-27 at 21.27.46.png', 'mime' => 'image/png', 'size' => 78176, 'is_public' => 0, 'created_at' => '2025-05-27 17:28:21', 'updated_at' => '2025-05-27 17:28:21',
            ],
            [
                'old_image_id' => 22, 'old_user_id' => 1, 'type' => 'image', 'filename' => '474306a9-4b34-44ed-accb-ee8fa035e62c.mp4', 'original_name' => 'Snaptik.app_7292417130035694854.mp4', 'mime' => 'video/mp4', 'size' => 623010, 'is_public' => 0, 'created_at' => '2025-06-01 11:07:11', 'updated_at' => '2025-06-01 11:07:11',
            ],
            [
                'old_image_id' => 23, 'old_user_id' => 1, 'type' => 'image', 'filename' => '7300fb59-ecbd-4256-bb11-bcb965b271f7.mp4', 'original_name' => '0308 (1).mp4', 'mime' => 'video/quicktime', 'size' => 15996173, 'is_public' => 0, 'created_at' => '2025-06-01 11:08:46', 'updated_at' => '2025-06-01 11:08:46',
            ],
            [
                'old_image_id' => 25, 'old_user_id' => 1, 'type' => 'image', 'filename' => '10563656-6f0c-4bc2-9f27-96a3a11697ca.png', 'original_name' => 'Screenshot 2025-06-01 at 15.16.38.png', 'mime' => 'image/png', 'size' => 14742, 'is_public' => 1, 'created_at' => '2025-06-01 11:17:04', 'updated_at' => '2025-06-01 11:17:04',
            ],
            [
                'old_image_id' => 26, 'old_user_id' => 1, 'type' => 'image', 'filename' => '9b9152d7-1107-4749-948a-b848ee8c246c.png', 'original_name' => 'Screenshot 2025-06-01 at 15.16.38.png', 'mime' => 'image/png', 'size' => 14742, 'is_public' => 1, 'created_at' => '2025-06-01 11:30:31', 'updated_at' => '2025-06-01 11:30:31',
            ],
            [
                'old_image_id' => 27, 'old_user_id' => 1, 'type' => 'image', 'filename' => '05243fb7-7db8-47bd-948d-a7bb6fb47c8d.png', 'original_name' => 'Screenshot 2025-06-01 at 15.29.32.png', 'mime' => 'image/png', 'size' => 401600, 'is_public' => 1, 'created_at' => '2025-06-01 11:30:51', 'updated_at' => '2025-06-01 11:30:51',
            ],
            [
                'old_image_id' => 28, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'f05ff6df-8701-4a04-8b97-781b232ee3b1.png', 'original_name' => 'Screenshot 2025-06-01 at 15.37.12.png', 'mime' => 'image/png', 'size' => 50380, 'is_public' => 1, 'created_at' => '2025-06-01 11:37:38', 'updated_at' => '2025-06-01 11:37:38',
            ],
            [
                'old_image_id' => 29, 'old_user_id' => 2, 'type' => 'image', 'filename' => 'ba2d0a4f-a149-47e4-9047-f2d6ae23431b.png', 'original_name' => 'Screenshot 2025-06-01 172912.png', 'mime' => 'image/png', 'size' => 4253, 'is_public' => 1, 'created_at' => '2025-06-01 13:29:48', 'updated_at' => '2025-06-01 13:30:04',
            ],
            [
                'old_image_id' => 30, 'old_user_id' => 2, 'type' => 'image', 'filename' => '5b974ebf-6af8-4c3e-8e5c-da5f3761e343.mp4', 'original_name' => 'evidence (1).mp4', 'mime' => 'video/mp4', 'size' => 2967297, 'is_public' => 0, 'created_at' => '2025-06-01 14:56:17', 'updated_at' => '2025-06-01 14:56:17',
            ],
            [
                'old_image_id' => 31, 'old_user_id' => 1, 'type' => 'image', 'filename' => '3df741d7-dc41-40a8-a130-890482c5adb0.png', 'original_name' => 'Screenshot 2025-06-01 at 19.25.58.png', 'mime' => 'image/png', 'size' => 112527, 'is_public' => 1, 'created_at' => '2025-06-01 15:26:41', 'updated_at' => '2025-06-01 15:26:41',
            ],
            [
                'old_image_id' => 32, 'old_user_id' => 1, 'type' => 'image', 'filename' => '124e56aa-04f7-4a46-be29-589a5db13444.mp4', 'original_name' => 'IMG_0856.mp4', 'mime' => 'video/mp4', 'size' => 19454496, 'is_public' => 0, 'created_at' => '2025-06-02 11:23:30', 'updated_at' => '2025-06-02 11:23:30',
            ],
            [
                'old_image_id' => 33, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'c1e5d4e1-7108-43d0-a383-462c4c16011c.mp4', 'original_name' => 'wippe.mp4', 'mime' => 'video/mp4', 'size' => 1414430, 'is_public' => 0, 'created_at' => '2025-06-02 11:24:51', 'updated_at' => '2025-06-02 11:24:51',
            ],
            [
                'old_image_id' => 34, 'old_user_id' => 1, 'type' => 'image', 'filename' => '25393d6a-08c2-4b96-9825-c33d29fa06c3.mp4', 'original_name' => 'karusselle.mp4', 'mime' => 'video/mp4', 'size' => 1828256, 'is_public' => 0, 'created_at' => '2025-06-02 11:25:35', 'updated_at' => '2025-06-02 11:25:35',
            ],
            [
                'old_image_id' => 35, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'ec317c04-4899-494e-a87e-6ad5281036ec.png', 'original_name' => 'Screenshot 2025-06-07 at 12.46.45.png', 'mime' => 'image/png', 'size' => 25002, 'is_public' => 1, 'created_at' => '2025-06-07 08:48:11', 'updated_at' => '2025-06-07 08:48:11',
            ],
            [
                'old_image_id' => 36, 'old_user_id' => 1, 'type' => 'image', 'filename' => '7b9a5a76-4cd8-443e-8ad0-6e226e2630cf.png', 'original_name' => 'Screenshot 2025-06-07 at 12.49.46.png', 'mime' => 'image/png', 'size' => 18309, 'is_public' => 0, 'created_at' => '2025-06-07 08:50:10', 'updated_at' => '2025-06-07 08:50:10',
            ],
            [
                'old_image_id' => 37, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'e0419f75-c3fa-46c5-ad16-1cb6b25fd4c6.mp4', 'original_name' => 'Unbenanntes Video.mp4', 'mime' => 'video/mp4', 'size' => 11179638, 'is_public' => 0, 'created_at' => '2025-07-02 10:53:16', 'updated_at' => '2025-07-02 10:53:16',
            ],
            [
                'old_image_id' => 38, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'f1710fc9-f308-4e64-beab-d32278a5d9e3.png', 'original_name' => 'Screenshot 2025-07-02 at 15.02.26.png', 'mime' => 'image/png', 'size' => 272668, 'is_public' => 0, 'created_at' => '2025-07-02 11:03:07', 'updated_at' => '2025-07-02 11:03:07',
            ],
            [
                'old_image_id' => 39, 'old_user_id' => 1, 'type' => 'image', 'filename' => 'f75f0a8f-259a-4642-a396-a2000f6dd47d.png', 'original_name' => 'Screenshot 2025-07-02 at 20.40.18.png', 'mime' => 'image/png', 'size' => 16023, 'is_public' => 1, 'created_at' => '2025-07-02 16:56:35', 'updated_at' => '2025-07-02 16:56:35',
            ],
        ];

        // Process and insert images
        foreach ($imagesToSeed as $imageData) {
            $existingImage = Image::where('filename', $imageData['filename'])->first();

            if (!$existingImage) {
                // Get the Discord ID for the current old_user_id
                $targetDiscordId = $oldIdToDiscordIdMap[$imageData['old_user_id']] ?? null;

                $user_uuid = null;
                if ($targetDiscordId) {
                    $userModel = User::where('discord_id', $targetDiscordId)->first();
                    if ($userModel) {
                        $user_uuid = $userModel->id; // Get the actual UUID from the DB
                    }
                }

                if ($user_uuid) {
                    DB::table('images')->insert([
                        'id' => Str::uuid()->toString(), // Generate new UUID for each image
                        'user_id' => $user_uuid,
                        'type' => $imageData['type'],
                        'filename' => $imageData['filename'],
                        'original_name' => $imageData['original_name'],
                        'mime' => $imageData['mime'],
                        'size' => $imageData['size'],
                        'is_public' => $imageData['is_public'],
                        'created_at' => Carbon::parse($imageData['created_at']),
                        'updated_at' => Carbon::parse($imageData['updated_at']),
                    ]);
                    $this->command->info('Inserted image: ' . $imageData['original_name'] . ' for user ' . $user_uuid);
                } else {
                    $this->command->error('User with old ID ' . $imageData['old_user_id'] . ' (Discord ID: ' . $targetDiscordId . ') not found for image ' . $imageData['filename'] . '. Skipping image.');
                }
            } else {
                $this->command->info('Image already exists: ' . $imageData['original_name']);
            }
        }
    }
}