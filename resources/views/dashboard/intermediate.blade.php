@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <h2 class="mb-4 text-2xl font-bold">Dashboard Menengah</h2>
    <p class="mb-6 text-gray-600">Berikut adalah modul yang cocok untuk tingkat menengah.</p>

    <!-- Grid untuk menampilkan modul -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($modules as $module)
        <div class="p-5 transition-transform transform bg-white border border-gray-200 rounded-lg shadow-lg hover:-translate-y-2 hover:shadow-xl">
            <!-- Judul Modul -->
            <h3 class="text-xl font-semibold text-gray-800">{{ $module->title }}</h3>

            <!-- Kategori -->
            <p class="text-sm text-gray-500">Kategori: {{ $module->category->name }}</p>

            <!-- Deskripsi -->
            <p class="mt-2 text-gray-700">{{ Str::limit($module->description, 100) }}</p>

            <!-- Download -->
            <div class="mt-4">
                @if($module->file_path)
                    <a href="{{ asset('storage/' . $module->file_path) }}"
                        download="{{ Str::slug($module->title) . '.' . pathinfo($module->file_path, PATHINFO_EXTENSION) }}"
                        class="block text-green-500 hover:underline">⬇️ Download Modul</a>
                @else
                    <span class="text-gray-400">File tidak tersedia</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
