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
        $images = auth()->user()->images()->latest()->paginate(12);
        return view('images.my-images', compact('images'));
    }

    public function recentUploads()
    {
        $images = Image::where('is_public', true)->latest()->paginate(12);
        return view('images.recent-uploads', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimetypes:video/mp4,image/jpeg,image/png,image/gif,image/webp|max:' . (env('MAX_FILE_SIZE', 50) * 1024),
            'is_public' => 'nullable|boolean',
        ]);

        $user = auth()->user();

        // Check storage limit (in bytes)
        $currentStorageUsed = $user->images()->sum('size');
        $fileSize = $request->file('file')->getSize();
        $storageLimitBytes = $user->storage_limit_mb * 1024 * 1024;

        if (($currentStorageUsed + $fileSize) > $storageLimitBytes) {
            return back()->with('error', __('content.storage_limit_exceeded') . ' (' . $user->storage_limit_mb . ' MB)');
        }

        $file = $request->file('file');
        $mime = $file->getMimeType();

        $isImage = Str::startsWith($mime, 'image/');
        $isVideo = Str::startsWith($mime, 'video/');

        if (!$isImage && !$isVideo) {
            return back()->with('error', __('Only images or videos are allowed.'));
        }

        $filePath = $file->store('images', 'public');
        $fileName = basename($filePath);

        $user->images()->create([
            'type' => $isVideo ? 'video' : 'image',
            'filename' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'mime' => $mime,
            'size' => $fileSize,
            'is_public' => $request->boolean('is_public'),
            'slug' => Str::random(7),
        ]);

        return back()->with('success', $isVideo ? __('content.video_uploaded') : __('content.image_uploaded'));
    }

    public function show(Image $image)
    {
        if (!$image->is_public && (auth()->guest() || auth()->id() !== $image->user_id)) {
            abort(403);
        }

        $path = Storage::disk('public')->path('images/' . $image->filename);

        if (!Storage::disk('public')->exists('images/' . $image->filename)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => $image->mime,
            'Content-Disposition' => 'inline; filename="' . $image->original_name . '"',
        ]);
    }

    public function destroy(Image $image)
    {
        if ($image->user_id !== auth()->id()) {
            abort(403);
        }

        if (Storage::disk('public')->exists('images/' . $image->filename)) {
            Storage::disk('public')->delete('images/' . $image->filename);
        }

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
