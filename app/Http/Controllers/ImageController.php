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
			return back()->with('error', __('content.storage_limit_exceeded') . ' (' . $user_storage_limit . ').');
        }

		$request->validate([
		    'file' => 'required|file|max:51200', // up to 50MB
		    'is_public' => 'nullable|boolean',
		]);
		
		$file = $request->file('file');
		$mime = $file->getMimeType();
		
		$isImage = Str::startsWith($mime, 'image/');
		$isVideo = Str::startsWith($mime, 'video/');
		
		if (!$isImage && !$isVideo) {
		    return back()->with('error', __('Only images or videos are allowed.'));
		}
		
		$filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
		$file->storeAs('public/images', $filename); // Consider renaming path later
		
		Image::create([
		    'user_id' => auth()->id(),
		    'type' => $isVideo ? 'video' : 'image',
		    'filename' => $filename,
		    'original_name' => $file->getClientOriginalName(),
		    'mime' => $mime,
		    'size' => $file->getSize(),
		    'is_public' => $request->boolean('is_public'),
		]);

		if($isVideo)
		{
        	return back()->with('success', __('content.video_uploaded'));
		};
		
		if(!$isVideo)
		{
        	return back()->with('success', __('content.image_uploaded'));
		};
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
