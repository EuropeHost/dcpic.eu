<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function dashboard()
    {
        $latestImage = auth()->user()->images()->latest()->first();

        return view('pages.dashboard', compact('latestImage'));
    }
}
