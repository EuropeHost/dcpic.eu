@extends('layouts.main')

@section('main')
    <h1 class="text-2xl font-semibold mb-6">{{ __('content.my_images') }}</h1>

    @include('images._list', ['images' => $images])
@endsection
