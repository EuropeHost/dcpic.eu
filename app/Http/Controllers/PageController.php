<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\User;

class PageController extends Controller
{
    public function home()
    {
        $totalUsed = Image::sum('size');
        $totalUsers = User::count();
        $totalImages = Image::count();
        $avgPerUser = $totalUsers > 0 ? $totalUsed / $totalUsers : 0;

        $totalLimit = env('STORAGE_LIMIT', 100) * 1024 * 1024 * 1024; // STORAGE_LIMIT GiB in bytes, added default
        $storagePercentage = min(100, ($totalUsed / $totalLimit) * 100);

        // --- Top Users by Storage ---
        $topStorageUsers = User::withSum('images', 'size')
            ->orderByDesc('images_sum_size')
            ->take(3)
            ->get()
            ->map(function ($user) {
                // Determine avatar URL or use a fallback
                $avatarUrl = asset('img/default-avatar.png'); // Default fallback
                if ($user->discord_id && $user->avatar) {
                    $avatarUrl = "https://cdn.discordapp.com/avatars/{$user->discord_id}/{$user->avatar}.png";
                }
                return (object) [
                    'name' => $user->name,
                    'avatar_url' => $avatarUrl,
                    'storage_used_mb' => number_format($user->images_sum_size / 1048576, 2), // Bytes to MB
                ];
            });

        // --- Top Users by Image Count ---
        $topImageUsers = User::withCount('images')
            ->orderByDesc('images_count')
            ->take(3)
            ->get()
            ->map(function ($user) {
                // Determine avatar URL or use a fallback
                $avatarUrl = asset('img/default-avatar.png'); // Default fallback
                if ($user->discord_id && $user->avatar) {
                    $avatarUrl = "https://cdn.discordapp.com/avatars/{$user->discord_id}/{$user->avatar}.png";
                }
                return (object) [
                    'name' => $user->name,
                    'avatar_url' => $avatarUrl,
                    'image_count' => $user->images_count,
                ];
            });


        return view('pages.home', [
            'totalUsed' => $totalUsed,
            'totalUsers' => $totalUsers,
            'totalImages' => $totalImages,
            'avgPerUser' => $avgPerUser,
            'totalLimit' => $totalLimit,
            'storagePercentage' => $storagePercentage,
            'topStorageUsers' => $topStorageUsers,
            'topImageUsers' => $topImageUsers,
        ]);
    }

    public function dashboard()
    {
        $latestImages = auth()->user()->images()->latest()->take(3)->get();
        return view('pages.dashboard', compact('latestImages'));
    }
}
