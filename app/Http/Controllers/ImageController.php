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
	    $user = auth()->user();
	
	    if ($user->storage_used >= $user->storage_limit_mb * 1024 * 1024) {
	        return back()->with('error', __('content.storage_limit_exceeded') . ' (' . $user->storage_limit_mb . ' MB)');
	    }
	
		$request->validate([
		    'file' => 'required|file|mimetypes:video/mp4,image/jpeg,image/webp,image/png,image/gif|max:51200',
		    'is_public' => 'nullable|boolean',
		]);
	
	    $file = $request->file('file');
	    $mime = $file->getMimeType();
	
	    $isImage = Str::startsWith($mime, 'image/');
	    $isVideo = Str::startsWith($mime, 'video/');
	
	    if (!$isImage && !$isVideo) {
	        return back()->with('error', __('Only images or videos are allowed.'));
	    }
	
		/*
		if ($isVideo && $mime !== 'video/mp4') {
		    return back()->with('error', __('content.only_mp4_allowed'));
		}
		*/

	    $fileid = Str::uuid();
	    $filename = $fileid . '.' . $file->getClientOriginalExtension();
	    $file->storeAs('public/images', $filename); // optional: use separate folder later
	
	    Image::create([
			'id' => $fileid,
	        'user_id' => $user->id,
	        'type' => $isVideo ? 'video' : 'image',
	        'filename' => $filename,
	        'original_name' => $file->getClientOriginalName(),
	        'mime' => $mime,
	        'size' => $file->getSize(),
	        'is_public' => $request->boolean('is_public'),
	    ]);
	
	    return back()->with('success', $isVideo
	        ? __('content.video_uploaded')
	        : __('content.image_uploaded'));
	}

	public function show(Image $image)
	{
	    $path = storage_path("app/public/images/{$image->filename}");
	
	    if (!file_exists($path)) {
	        abort(404);
	    }
	
	    $headers = [
	        'Content-Type' => $image->mime, // from DB
	        'Content-Disposition' => 'inline; filename="' . $image->original_name . '"'
	    ];
	
	  //  return response()->file($path, $headers);
		return response()->file($path, [
		    'Content-Type' => $image->mime,
		    'Content-Disposition' => 'inline; filename="' . $image->original_name . '"'
		]);
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
