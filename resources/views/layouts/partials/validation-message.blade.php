

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
            <span class="font-medium">Error!</span> {{ $error }}
        </div>
    @endforeach
@endif
