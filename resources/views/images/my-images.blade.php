@extends('layouts.main')

@section('main')
    <h1 class="text-2xl font-semibold mb-6">My Images</h1>

    @include('images._list', ['images' => $images])
@endsection
