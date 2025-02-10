@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <!-- Judul Halaman -->
    <h2 class="mb-6 text-3xl font-bold text-center text-gray-800">Dashboard</h2>

    <!-- Grid untuk menampilkan setiap module sebagai card -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($modules as $module)
        <div class="p-5 transition-transform transform bg-white border border-gray-200 rounded-lg shadow-lg hover:-translate-y-2 hover:shadow-xl">
            <!-- Gambar Modul -->
            <div class="flex justify-center">
                @if($module->image_path)
                    <img src="{{ asset('storage/' . $module->image_path) }}" alt="Module Image" class="object-cover w-32 h-32 rounded-lg shadow">
                @else
                    <div class="flex items-center justify-center w-32 h-32 text-gray-400 bg-gray-200 rounded-lg">
                        No Image
                    </div>
                @endif
            </div>

            <!-- Judul Modul -->
            <h3 class="mt-4 text-xl font-semibold text-center text-gray-800">{{ $module->title }}</h3>

            <!-- Kategori -->
            <p class="text-sm text-center text-gray-500">Kategori: {{ $module->category->name }}</p>

            <!-- Deskripsi -->
            <p class="mt-2 text-center text-gray-700">{{ Str::limit($module->description, 100) }}</p>

            <!-- File Preview & Download -->
            <div class="mt-4 text-center">
                @if($module->file_path)
                <a href="{{ route('module.show', $module->id) }}" class="block text-blue-500 hover:underline">📖 Lihat Materi</a>
                <a href="{{ route('module.show', $module->id) }}" download class="block mt-2 text-green-500 hover:underline">⬇️ Download</a>
                <a href="{{ route('tasks.index') }}" class="block mt-2 text-blue-500 hover:underline">📋 Lihat Daftar Tugas</a>
                @else
                    <span class="text-gray-400">No File</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
