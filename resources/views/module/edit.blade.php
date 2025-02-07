@extends('layouts.app')

@section('content')
<div class="max-w-3xl p-6 mx-auto mt-10 bg-white rounded-lg shadow-md"> <!-- Tambah mt-10 -->
    <h2 class="mb-4 text-2xl font-bold text-center text-gray-800">Edit Module</h2>

    <form action="{{ route('module.update', $module->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label class="block text-sm font-medium text-gray-700">Module Title</label>
            <input type="text" name="title" class="w-full p-2 mt-1 border rounded-md focus:ring focus:ring-blue-200 focus:outline-none" value="{{ $module->title }}" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" class="w-full p-2 mt-1 border rounded-md focus:ring focus:ring-blue-200 focus:outline-none" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $module->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" class="w-full p-2 mt-1 border rounded-md focus:ring focus:ring-blue-200 focus:outline-none" required>{{ $module->description }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Upload New File (Optional)</label>
            <input type="file" name="file_path" class="w-full p-2 mt-1 border rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        <div class="flex justify-between">
            <a href="javascript:history.back();" class="px-4 py-2 text-gray-700 transition duration-300 bg-gray-200 rounded-md hover:bg-gray-300">
                Back
            </a>
            <button type="submit" class="px-4 py-2 text-white transition duration-300 bg-blue-500 rounded-md hover:bg-blue-600">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
