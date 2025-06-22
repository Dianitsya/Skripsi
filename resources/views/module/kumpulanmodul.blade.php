@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Kumpulan Modul</h1>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($modules as $module)
            <div class="p-4 bg-white rounded-lg shadow">
                <h2 class="text-lg font-semibold">{{ $module->title }}</h2>
                <p class="text-gray-600">{{ $module->description }}</p>
                <a href="{{ asset('storage/' . $module->file_path) }}" download="{{ Str::slug($module->title) . '.' . pathinfo($module->file_path, PATHINFO_EXTENSION) }}" class="inline-block mt-2 text-blue-500">
                    Download Modul
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
