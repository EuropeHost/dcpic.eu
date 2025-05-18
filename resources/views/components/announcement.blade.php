@if(session('announcement'))
    <div class="bg-yellow-200 p-2 text-center">
        {{ session('announcement') }}
    </div>
@endif
