<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();

        $user->loadCount('images')->loadSum('images', 'size');

        $publicImagesCount = $user->images()->where('is_public', 1)->count();
        $privateImagesCount = $user->images()->where('is_public', 0)->count();

        // Determine avatar URL or use a fallback
        $avatarUrl = asset('img/default-avatar.png');
        if ($user->discord_id && $user->avatar) {
            $avatarUrl = "https://cdn.discordapp.com/avatars/{$user->discord_id}/{$user->avatar}.png";
        }
        $user->avatar_url = $avatarUrl;

        return view('profile.show', compact('user', 'publicImagesCount', 'privateImagesCount'));
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        Auth::logout();

        if ($user->images) {
            foreach ($user->images as $image) {
                if (Storage::disk('public')->exists($image->filename)) {
                    Storage::disk('public')->delete($image->filename);
                }
            }
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('home')->with('success', __('profile.account_deleted_success'));
    }
}
