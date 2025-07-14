@extends('layouts.main')

@section('main')
    <div x-data="{ emailHover: false, showDeleteModal: false }" class="bg-white shadow rounded-lg p-8 mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('profile.my_profile') }}</h1>

        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('profile.information') }}</h2>
            @include('profile._info')
        </div>

        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('profile.my_stats') }}</h2>
            @include('profile._stats')
        </div>

        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-red-600 mb-4">{{ __('profile.danger_zone') }}</h2>
            @include('profile._danger')
        </div>
    </div>
@endsection
