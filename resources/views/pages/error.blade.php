@extends('layouts.app')

@section('title', $title ?? __('error.title'))

@section('content')
    <div class="text-center py-20">
        <h1 class="text-5xl font-bold text-red-600">{{ $code ?? 500 }}</h1>
        <p class="text-xl mt-4">{{ $message ?? __('error.unexpected') }}</p>
        <a href="/" class="mt-6 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            {{ __('error.go_home') }}
        </a>
    </div>
@endsection