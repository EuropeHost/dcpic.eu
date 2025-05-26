<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\User;
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
        $images = Image::where('is_public', true)->latest()->paginate(12);
        return view('images.recent-uploads', compact('images'));
    }

    public function store(Request $request)
    {
			
        if (auth()->user()->storage_used >= auth()->user()->storage_limit_mb * 1024 * 1024) {
            return back()->with('error', 'Storage limit exceeded (' . $user_storage_limit . ').');
        }

        $request->validate([
            'image' => 'required|image|max:10240', // max 10MB per image
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
		    'is_public' => $request->boolean('is_public'),
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

        return back()->with('success', __('content.image_deleted'));
    }
	
	public function toggleVisibility(Request $request, Image $image)
	{
	    if ($image->user_id !== auth()->id()) {
	        abort(403);
	    }
	
	    $request->validate([
	        'is_public' => 'required|boolean',
	    ]);
	
	    $image->is_public = $request->boolean('is_public');
	    $image->save();
	
	    return back()->with('success', __('content.visibility_updated'));
	}

}
