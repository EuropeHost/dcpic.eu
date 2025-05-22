<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function myImages()
    {
        $images = Image::where('user_id', auth()->id())->latest()->paginate(12);
        return view('images.my-images', compact('images'));
    }

    public function recentUploads()
    {
        $images = Image::latest()->paginate(12);
        return view('images.recent-uploads', compact('images'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->storage_used >= 25 * 1024 * 1024) {
            return back()->with('error', 'Storage limit exceeded (25MiB).');
        }

        $request->validate([
            'image' => 'required|image|max:5120', // max 5MB per image
        ]);

        $file = $request->file('image');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $filename);

        Image::create([
            'user_id' => auth()->id(),
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return back()->with('success', __('image_uploaded'));
    }

    public function show(Image $image)
    {
        return response()->file(storage_path("app/public/images/{$image->filename}"));
    }

    public function destroy(Image $image)
    {
        if ($image->user_id !== auth()->id()) {
            abort(403);
        }

        Storage::delete("public/images/{$image->filename}");
        $image->delete();

        return back()->with('success', __('image_deleted'));
    }
}
