<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class LinkController extends Controller
{
    public function show(Link $link)
    {
        $link->increment('visits'); // Increment visit count
        return Redirect::to($link->original_url);
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url|max:2048',
            'custom_slug' => ['nullable', 'string', 'min:5', 'max:7', Rule::unique('links', 'slug')], //optional
        ]);

        $slug = $request->custom_slug ?: Link::generateUniqueSlug();

        $link = Link::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'original_url' => $request->original_url,
            'slug' => $slug,
        ]);

        return back()->with('success', __('links.link_created', ['short_link' => route('links.show', $link->slug)]));
    }

    public function myLinks()
    {
        $links = auth()->user()->links()->latest()->paginate(10);
        return view('links.my', compact('links'));
    }

    public function destroy(Link $link)
    {
        if (auth()->id() !== $link->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $link->delete();

        return back()->with('success', __('links.link_deleted'));
    }
}
