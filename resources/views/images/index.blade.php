@extends('layouts.main')

@section('main')
    <h2 class="text-2xl font-semibold mb-4">Your Uploaded Images</h2>

    @if($images->count())
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($images as $image)
                <div class="border rounded shadow p-2 bg-white">
                    <img src="{{ route('images.show', $image) }}" class="w-full h-40 object-cover rounded mb-2">

					<div class="flex justify-between items-center text-sm mt-2">
					    <a href="{{ route('images.show', $image) }}" target="_blank" class="text-blue-500 hover:underline">
					        <i class="bi bi-eye"></i> View
					    </a>
					
					    <a href="{{ route('images.show', $image) }}" target="_blank" class="text-gray-500 hover:text-gray-800" onclick="navigator.clipboard.writeText(this.href); return false;">
					        <i class="bi bi-clipboard"></i> Copy Link
					    </a>
					</div>

                    <div class="text-sm text-gray-700 truncate">{{ $image->original_name }}</div>

                    <form method="POST" action="{{ route('images.destroy', $image) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline text-sm">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $images->links() }}
        </div>
    @else
        <p class="text-gray-500">No images uploaded yet.</p>
    @endif
@endsection
