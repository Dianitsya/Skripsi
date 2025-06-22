@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <h2 class="mb-4 text-2xl font-bold">Dashboard Lanjutan</h2>
    <p class="mb-6 text-gray-600">Modul tingkat lanjut tersedia untuk Anda.</p>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($modules as $module)
            <div class="p-5 bg-white rounded-lg shadow-lg">
                <h3 class="mb-2 text-lg font-semibold">{{ $module->title }}</h3>
                <p class="mb-4 text-gray-700">{{ Str::limit($module->description, 100) }}</p>
                <div class="flex items-center gap-4">
                    <a href="{{ asset('storage/' . $module->file_path) }}"
                        download="{{ Str::slug($module->title) . '.' . pathinfo($module->file_path, PATHINFO_EXTENSION) }}"
                        class="text-green-500 hover:underline">
                        ⬇️ Download Modul
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
