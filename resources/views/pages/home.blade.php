@extends('layouts.main')

@section('main')
    <div class="text-center py-12 home">
        <h1 class="text-4xl font-bold">{{ __('content.home_title') }}</h1>
        <p class="text-lg mt-4 text-gray-600">{{ __('content.home_subtitle') }}</p>

        @guest
            <!--a href="{{ route('login') }}"
               class="mt-6 inline-block bg-sky-600 text-white px-6 py-3 rounded hover:bg-sky-700 transition text-lg">
                <i class="bi bi-discord"></i> {{ __('content.login_with_discord') }}
            </a-->
			<a href="{{ route('login') }}" class="discord-login-btn mt-6">
			    <i class="bi bi-discord"></i> {{ __('content.login_with_discord') }}
			</a>
        @endguest

        <div class="mt-10 max-w-md mx-auto bg-white border shadow rounded p-6 text-left">
            <h2 class="text-xl font-semibold mb-3">{{ __('content.storage_overview') }}</h2>

            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-sky-600 h-4 rounded-full transition-all" style="width: {{ $storagePercentage }}%"></div>
            </div>
            <p class="text-sm mt-1 text-gray-600">
                {{ number_format($totalUsed / 1048576, 2) }} MB /
                {{ number_format($totalLimit / 1073741824, 2) }} GiB
                ({{ number_format($storagePercentage, 1) }}%)
            </p>

            <p class="text-sm text-gray-700 mt-3">
                <strong>{{ __('content.average_per_user') }}:</strong>
                {{ number_format($avgPerUser / 1048576, 2) }} MB
            </p>
        </div>
    </div>
@endsection
