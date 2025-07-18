<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\User;
use App\Models\Link;

class PageController extends Controller
{
	public function home()
	{
	    $totalUsed = Image::sum('size');
	    $totalUsers = User::count();
	    $totalImages = Image::count();
	    $totalLinks = Link::count();
	    $avgPerUser = $totalUsers > 0 ? $totalUsed / $totalUsers : 0;
	
	    $totalLimit = env('STORAGE_LIMIT', 100) * 1024 * 1024 * 1024; // STORAGE_LIMIT GiB in bytes
	    $storagePercentage = min(100, ($totalUsed / $totalLimit) * 100);
	
	    // --- Top Users by Storage ---
	    $topStorageUsers = User::withSum('images', 'size')
	        ->orderByDesc('images_sum_size')
	        ->take(2)
	        ->get()
	        ->map(function ($user) {
	            $avatarUrl = asset('img/default-avatar.png');
	            if ($user->discord_id && $user->avatar) {
	                $avatarUrl = "https://cdn.discordapp.com/avatars/{$user->discord_id}/{$user->avatar}.png";
	            }
	            return (object) [
	                'name' => $user->name,
	                'avatar_url' => $avatarUrl,
	                'storage_used_mb' => number_format($user->images_sum_size / 1048576, 2),
	            ];
	        });
	
	    // --- Top Users by Image Count ---
	    $topImageUsers = User::withCount('images')
	        ->orderByDesc('images_count')
	        ->take(4)
	        ->get()
	        ->map(function ($user) {
	            $avatarUrl = asset('img/default-avatar.png');
	            if ($user->discord_id && $user->avatar) {
	                $avatarUrl = "https://cdn.discordapp.com/avatars/{$user->discord_id}/{$user->avatar}.png";
	            }
	            return (object) [
	                'name' => $user->name,
	                'avatar_url' => $avatarUrl,
	                'image_count' => $user->images_count,
	            ];
	        });
	
	    // --- Top Users by Link Count ---
	    $topLinkUsers = User::withCount('links')
	        ->orderByDesc('links_count')
	        ->take(4)
	        ->get()
	        ->map(function ($user) {
	            $avatarUrl = asset('img/default-avatar.png');
	            if ($user->discord_id && $user->avatar) {
	                $avatarUrl = "https://cdn.discordapp.com/avatars/{$user->discord_id}/{$user->avatar}.png";
	            }
	            return (object) [
	                'name' => $user->name,
	                'avatar_url' => $avatarUrl,
	                'link_count' => $user->links_count,
	            ];
	        });
	
	    return view('pages.home', compact(
	        'totalUsed',
	        'totalUsers',
	        'totalImages',
	        'totalLinks',
	        'avgPerUser',
	        'totalLimit',
	        'storagePercentage',
	        'topStorageUsers',
	        'topImageUsers',
	        'topLinkUsers'
	    ));
	}

    public function dashboard()
    {
        $latestImages = auth()->user()->images()->latest()->take(3)->get();
        $latestLinks = auth()->user()->links()->latest()->take(5)->get();
        return view('pages.dashboard', compact(['latestImages', 'latestLinks']));
    }
}
