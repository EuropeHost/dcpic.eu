<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $totalUsers = User::count();
        $totalImages = Image::count();
        $totalStorageUsedBytes = Image::sum('size');
        $totalStorageUsedMB = $totalStorageUsedBytes / 1024 / 1024;

        $systemStorageLimitBytes = (int)env('SYSTEM_STORAGE_LIMIT_GB', 1024) * 1024 * 1024 * 1024;
        $systemStoragePercentage = ($systemStorageLimitBytes > 0) ? ($totalStorageUsedBytes / $systemStorageLimitBytes) * 100 : 0;
        $systemStoragePercentage = min(100, $systemStoragePercentage);


        $users = User::withCount('images')
                     ->withSum('images', 'size')
                     ->orderBy('created_at', 'desc')
                     ->paginate(15);

        $users->getCollection()->transform(function ($user) {
            $avatarUrl = asset('img/default-avatar.png'); // Default fallback
            if ($user->discord_id && $user->avatar) {
                $avatarUrl = "https://cdn.discordapp.com/avatars/{$user->discord_id}/{$user->avatar}.png";
            }
            $user->avatar_url = $avatarUrl; // custom attribute
            return $user;
        });

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalImages',
            'totalStorageUsedMB',
            'systemStorageLimitBytes',
            'systemStoragePercentage',
            'users'
        ));
    }

    public function showUser(User $user)
    {
        $user->loadCount('images')->loadSum('images', 'size');

        $userImages = $user->images()->latest()->paginate(10);

        $avatarUrl = asset('img/default-avatar.png');
        if ($user->discord_id && $user->avatar) {
            $avatarUrl = "https://cdn.discordapp.com/avatars/{$user->discord_id}/{$user->avatar}.png";
        }
        $user->avatar_url = $avatarUrl;

        return view('admin.user_insights', compact('user', 'userImages'));
    }
}
