@extends('layouts.main')

@section('main')
    <div class="text-center py-20">
        <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">
            <i class="bi bi-discord"></i> {{ __('content.login_with_discord') }}
        </a>
    </div>
@endsection
