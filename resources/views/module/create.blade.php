@extends('layouts.app')

@section('content')
<div class="max-w-2xl p-6 mx-auto mt-10 bg-white rounded-lg shadow-md">
    <h2 class="mb-4 text-2xl font-bold text-center text-gray-800">Upload Module</h2>

    <form action="{{ route('module.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateFile()">
        @csrf

        <label for="title" class="block text-sm font-medium text-gray-700">Judul Modul</label>
        <input id="title" type="text" name="title" class="block w-full p-2 mt-1 border rounded-md" required>

        <label for="description" class="block mt-3 text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea id="description" class="block w-full p-2 mt-1 border rounded-md" name="description"></textarea>

        <label for="category_id" class="block mt-3 text-sm font-medium text-gray-700">Kategori</label>
        <select id="category_id" name="category_id" class="block w-full p-2 mt-1 border rounded-md">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <!-- Upload File -->
        <label for="file" class="block mt-3 text-sm font-medium text-gray-700">Upload File (PDF, Word, PPT)</label>
        <input id="file" type="file" name="file" class="block w-full p-2 mt-1 border rounded-md" accept=".pdf,.doc,.docx,.ppt,.pptx">

        <!-- Pesan error -->
        <p id="error-message" class="hidden mt-2 text-sm text-red-500"></p>

        <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-md hover:bg-blue-600">
            Upload
        </button>
    </form>
</div>

<!-- JavaScript untuk validasi file -->
<script>
    function validateFile() {
        let fileInput = document.getElementById("file");
        let errorMessage = document.getElementById("error-message");

        let allowedFileExtensions = ["pdf", "doc", "docx", "ppt", "pptx"];

        // Validasi file dokumen
        if (fileInput.files.length > 0) {
            let file = fileInput.files[0];
            let fileExt = file.name.split('.').pop().toLowerCase();

            if (!allowedFileExtensions.includes(fileExt)) {
                errorMessage.innerText = "File hanya boleh dalam format PDF, Word, atau PPT!";
                errorMessage.classList.remove("hidden");
                return false;
            }

            if (file.size > 5 * 1024 * 1024) { // Maks 5MB
                errorMessage.innerText = "Ukuran file terlalu besar! Maksimal 5MB.";
                errorMessage.classList.remove("hidden");
                return false;
            }
        }

        // Jika semua valid, submit form
        errorMessage.classList.add("hidden");
        return true;
    }
</script>
@endsection
