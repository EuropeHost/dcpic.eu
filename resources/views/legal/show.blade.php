@extends('layouts.main')

@section('main')
	<style>
	    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
	        color: #0369a1; /* Tailwind sky-700 */
	        margin-top: 1.5rem;
	        margin-bottom: 0.75rem;
	        font-weight: 600;
	    }
	
	    .prose a {
	        color: #2563eb; /* Tailwind blue-600 */
	        text-decoration: underline;
	    }
	
	    .prose a:hover {
	        color: #1d4ed8; /* Tailwind blue-700 */
	    }
	
	    .prose p {
	        margin-bottom: 1rem;
	        line-height: 1.6;
	    }
	
	    .prose ul, .prose ol {
	        margin-left: 1.5rem;
	        margin-bottom: 1rem;
	    }
	
	    .prose li::marker {
	        color: #6b7280; 
	    }
	</style>

    <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">{{ $title }}</h1>

		<article class="prose max-w-none">
		    {!! \Illuminate\Support\Str::markdown($content) !!}
		</article>


        <div class="mt-10 text-sm text-gray-500">
            <a href="{{ route('legal.show', 'imprint') }}" class="underline hover:text-blue-500">{{ __('legal.imprint.title') }}</a> •
            <a href="{{ route('legal.show', 'privacy') }}" class="underline hover:text-blue-500">{{ __('legal.privacy.title') }}</a> •
            <a href="{{ route('legal.show', 'terms') }}" class="underline hover:text-blue-500">{{ __('legal.terms.title') }}</a>
        </div>
    </div>
@endsection
