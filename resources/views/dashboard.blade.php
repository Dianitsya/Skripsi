@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <!-- Judul Halaman -->
    <h2 class="mb-6 text-3xl font-bold text-center text-gray-800">Dashboard</h2>

    <!-- Grid untuk menampilkan setiap module sebagai card -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($modules as $module)
        <div class="p-5 transition-transform transform bg-white border border-gray-200 rounded-lg shadow-lg hover:-translate-y-2 hover:shadow-xl">
            <!-- Judul Modul -->
            <h3 class="mb-2 text-xl font-semibold text-gray-800">{{ $module->title }}</h3>

            <!-- Kategori -->
            <p class="text-sm text-gray-500">Kategori: {{ $module->category->name }}</p>

            <!-- Deskripsi -->
            <p class="mt-2 text-gray-700">{{ Str::limit($module->description, 100) }}</p>

            <!-- Gambar Modul -->
            <div class="mt-3">
                @if($module->image)
                <img src="{{ Storage::url($module->image) }}" alt="Module Image" class="object-cover w-full h-40 rounded-md shadow-md">
                @else
                    <div class="flex items-center justify-center w-full h-40 bg-gray-200 rounded-md">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
            </div>

            <!-- File Download -->
            <div class="mt-4">
                @if($module->file)
                <a href="{{ Storage::url($module->file) }}" target="_blank" class="px-3 py-2 text-white transition bg-blue-500 rounded-md hover:bg-blue-600">
                    Download File
                </a>
                @else
                    <span class="text-gray-500">No File Available</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
