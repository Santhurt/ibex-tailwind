@if ($message = Session::get('success'))
    <div class="bg-green-500 text-white font-bold p-4 rounded-lg mb-4">
        <p>{{ $message }}</p>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="bg-red-500 text-white font-bold p-4 rounded-lg mb-4">
        <p>{{ $message }}</p>
    </div>
@endif
