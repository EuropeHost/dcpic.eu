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
	    $totalUsers = \App\Models\User::count();
	    $avgPerUser = $totalUsers > 0 ? $totalUsed / $totalUsers : 0;
	
	    $totalLimit = env('STORAGE_LIMIT') * 1024 * 1024 * 1024; // STORAGE_LIMIT GiB in bytes
	    $storagePercentage = min(100, ($totalUsed / $totalLimit) * 100);
	
	    return view('pages.home', [
	        'totalUsed' => $totalUsed,
	        'avgPerUser' => $avgPerUser,
	        'totalLimit' => $totalLimit,
	        'storagePercentage' => $storagePercentage,
	    ]);
	}

    public function dashboard()
    {
        $latestImage = auth()->user()->images()->latest()->first();
        return view('pages.dashboard', compact('latestImage'));
    }
}
