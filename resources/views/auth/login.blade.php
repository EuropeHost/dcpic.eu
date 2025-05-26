@extends('layouts.main')

@section('main')
    <div class="text-center py-20">
		<button class="discord-login-btn mb-4" type="button" href="{{ route('login') }}">
    	    <i class="bi bi-discord" aria-hidden="true"></i>
    	    {{ __('content.login_with_discord') }}
    	</button>
    </div>
@endsection
