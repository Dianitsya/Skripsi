@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Daftar Tugas</h1>

        @if(auth()->user() && auth()->user()->role === 'admin')
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
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
        </div>
    @endforeach
</div>
@endsection
