@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Buat Tugas Baru</h1>
        <a href="{{ route('tasks.index') }}" class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600">
            🔙 Kembali
        </a>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Input Judul -->
            <div class="mb-4">
                <label for="title" class="block mb-1 text-sm font-semibold">Judul Tugas:</label>
                <input type="text" name="title" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
            </div>

            <!-- Input Deskripsi -->
            <div class="mb-4">
                <label for="description" class="block mb-1 text-sm font-semibold">Deskripsi:</label>
                <textarea name="description" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required></textarea>
            </div>

            <!-- Input Deadline -->
            <div class="mb-4">
                <label for="deadline" class="block mb-1 text-sm font-semibold">Deadline:</label>
                <input type="datetime-local" name="deadline" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
            </div>

            <!-- Input Upload File -->
            <div class="mb-4">
                <label for="file" class="block mb-1 text-sm font-semibold">Upload File (Opsional):</label>
                <input type="file" name="file" class="w-full p-2 border rounded">
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 text-white transition bg-blue-500 rounded hover:bg-blue-600">
                    ✅ Simpan Tugas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
