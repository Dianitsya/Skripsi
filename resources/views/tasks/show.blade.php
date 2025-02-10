@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto bg-white rounded-lg shadow-md">
    <h1 class="mb-4 text-3xl font-bold text-gray-800">{{ $task->title }}</h1>

    <!-- Menampilkan Deadline -->
    <p class="text-gray-500">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y, H:i') }}</p>

    <p class="text-gray-700">{{ $task->description }}</p>

    @if ($task->file_path)
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-gray-800">Pratinjau Materi</h2>
            @php
                $fileExtension = pathinfo($task->file_path, PATHINFO_EXTENSION);
            @endphp

            <div class="p-4 mt-3 bg-gray-100 border rounded-lg">
                @if ($fileExtension === 'pdf')
                    <iframe src="{{ asset('storage/' . $task->file_path) }}" class="w-full border rounded-lg h-96" allowfullscreen></iframe>
                @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                    <img src="{{ asset('storage/' . $task->file_path) }}" class="w-full max-w-2xl border rounded-lg">
                @elseif(in_array($fileExtension, ['txt', 'csv']))
                    <pre class="p-4 border rounded bg-gray-50">{{ file_get_contents(storage_path('app/public/' . $task->file_path)) }}</pre>
                @else
                    <p class="text-gray-500">Format file tidak dapat ditampilkan secara langsung.</p>
                @endif
            </div>
        </div>
    @endif

    <!-- Form Upload Jawaban -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-800">Kumpulkan Jawaban</h2>
        <form action="{{ route('tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            <input type="file" name="answer_file" class="w-full p-2 border rounded" required>
            <button type="submit" class="px-4 py-2 mt-3 text-white transition bg-green-500 rounded-lg hover:bg-green-600">Upload Jawaban</button>
        </form>
    </div>

    <!-- List Jawaban yang Sudah Dikirim -->
    @if ($task->submissions->count() > 0)
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800">Jawaban Terkumpul</h2>
            @foreach ($task->submissions as $submission)
                <div class="p-4 mt-3 border rounded bg-gray-50">
                    <p class="font-medium">{{ $submission->user->name }}</p>
                    <a href="{{ asset('storage/' . $submission->file_path) }}" class="text-blue-500 hover:underline" download>📄 Lihat Jawaban</a>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Form Feedback -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-800">Feedback</h2>
        <form action="{{ route('tasks.feedback.store', $task->id) }}" method="POST" class="mt-3">
            @csrf
            <textarea name="comment" class="w-full p-2 border rounded" required></textarea>
            <button type="submit" class="px-4 py-2 mt-3 text-white transition bg-blue-500 rounded-lg hover:bg-blue-600">Kirim</button>
        </form>
    </div>

    <!-- List Feedback -->
    @if ($task->feedback->count() > 0)
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-800">Komentar & Feedback</h2>
            @foreach ($task->feedback as $feedback)
                <div class="p-4 mt-3 border rounded bg-gray-50">
                    <p class="font-medium">{{ $feedback->user->name }}:</p>
                    <p class="text-gray-700">{{ $feedback->comment }}</p>
                    <form action="{{ route('tasks.feedback.delete', [$task->id, $feedback->id]) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE') <!-- Menambahkan method DELETE -->
                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
