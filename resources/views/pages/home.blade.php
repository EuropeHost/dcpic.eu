@extends('layouts.main')

@section('main')
    <div class="text-center py-12">
        <h1 class="text-4xl font-bold">{{ __('content.home_title') }}</h1>
        <p class="text-lg mt-4 text-gray-600">{{ __('content.home_subtitle') }}</p>

        <a href="{{ route('login') }}"
           class="mt-6 inline-block bg-sky-600 text-white px-6 py-3 rounded hover:bg-sky-700 transition text-lg">
            <i class="bi bi-discord"></i> {{ __('content.login_with_discord') }}
        </a>
    </div>
@endsection
