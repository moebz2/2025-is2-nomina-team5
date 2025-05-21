@if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        <span class="font-medium">Exito!</span> {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
        <span class="font-medium">Error!</span> {{ session('error') }}
    </div>
@endif
