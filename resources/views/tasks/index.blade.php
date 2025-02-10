@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Daftar Tugas</h1>

        @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->id === 1))
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded hover:bg-blue-600">
                ➕ Tambah Tugas
            </a>
        @endif
    </div>

    @foreach ($tasks as $task)
        <div class="p-4 mb-4 bg-white border rounded-lg shadow-md">
            <h2 class="text-lg font-bold">{{ $task->title }}</h2>
            <p class="text-gray-700">{{ $task->description }}</p>

            <a href="{{ route('tasks.show', $task->id) }}" class="block mt-2 text-green-500 hover:underline">
                📖 Lihat Detail
            </a>

            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->id === 1))
                <!-- Delete Button -->
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">
                        🗑️ Hapus Tugas
                    </button>
                </form>
            @endif
        </div>
    @endforeach
</div>
@endsection
