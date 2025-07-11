@extends('layouts.app')

@section('content')
	<div class="container mx-auto p-4">
        @include('components.alert')
    	@yield('main')
	</div>
@endsection
