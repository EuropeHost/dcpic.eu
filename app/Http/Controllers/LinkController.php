<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\LinkView;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function show(Link $link)
    {
        LinkView::create([
            'link_id' => $link->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'viewer_user_id' => Auth::id(),
        ]);

        return Redirect::to($link->original_url);
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url|max:2048',
            'custom_slug' => ['nullable', 'string', 'min:5', 'max:12', Rule::unique('links', 'slug')],
        ]);

        $slug = $request->custom_slug ?: Link::generateUniqueSlug();

        $link = Link::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'original_url' => $request->original_url,
            'slug' => $slug,
        ]);

        return back()->with('success', __('links.link_created', ['short_link' => route('links.show', $link->slug)]));
    }

    public function myLinks()
    {
        $links = auth()->user()->links()->withCount('views')->latest()->paginate(10);
        return view('links.my', compact('links'));
    }

    public function destroy(Link $link)
    {
        if (Auth::id() !== $link->user_id && Auth::user()->role !== 'admin') { // Changed Auth::user()->role from Auth::user()->id
            abort(403);
        }

        $link->delete();

        return back()->with('success', __('links.link_deleted'));
    }
}