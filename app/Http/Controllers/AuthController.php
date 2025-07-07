<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function redirectToDiscord()
    {
        $query = http_build_query([
            'client_id' => env('DISCORD_CLIENT_ID'),
            'redirect_uri' => env('DISCORD_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => 'identify email',
        ]);

        return redirect("https://discord.com/api/oauth2/authorize?$query");
    }
	
	public function showLogin()
	{
		return view('auth.login');
	}

	public function handleDiscordCallback(Request $request)
	{
	    $code = $request->get('code');
	
	    $response = Http::asForm()->post('https://discord.com/api/oauth2/token', [
	        'client_id' => env('DISCORD_CLIENT_ID'),
	        'client_secret' => env('DISCORD_CLIENT_SECRET'),
	        'grant_type' => 'authorization_code',
	        'code' => $code,
	        'redirect_uri' => env('DISCORD_REDIRECT_URI'),
	    ]);
	
	    $responseData = $response->json();
	
	    if (!isset($responseData['access_token'])) {
	        logger()->error('Discord token response error', $responseData);
	        abort(400, __('content.discord_auth_failed'));
	    }
	
	    $accessToken = $responseData['access_token'];
	
	    $discordUser = Http::withHeaders([
	        'Authorization' => "Bearer $accessToken",
	    ])->get('https://discord.com/api/users/@me')->json();
	
	    $user = User::updateOrCreate(
	        ['discord_id' => $discordUser['id']],
	        [
	            'id' => Str::uuid()
	            'name' => $discordUser['username'],
	            'email' => $discordUser['email'] ?? null,
	            'avatar' => $discordUser['avatar'],
	        ]
	    );
	
	    Auth::login($user);
	    return redirect()->route('dashboard');
	}
	
	public function logout(Request $request)
	{
	    $locale = session('locale');
	    $dismissed = session('dismissed_announcements');
	
	    Auth::logout();
	    $request->session()->flush();
	
	    // Restore important session values
	    $request->session()->put('locale', $locale);
	    $request->session()->put('dismissed_announcements', $dismissed);
	
	    return redirect('/');
	}
}
