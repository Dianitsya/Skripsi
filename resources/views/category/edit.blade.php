@extends('layouts.app')

@section('content')
<div class="max-w-3xl p-6 mx-auto bg-white rounded-lg shadow-lg">
    <h2 class="mb-4 text-2xl font-bold text-gray-800">Edit Category</h2>

    <form action="{{ route('category.update', $category->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Category Name</label>
            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" value="{{ $category->name }}" required>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="w-full py-2 text-white transition duration-300 bg-blue-500 rounded-md hover:bg-blue-600">
                Update
            </button>
            <a href="{{ route('category.index') }}" class="w-full py-2 text-center text-white transition duration-300 bg-gray-500 rounded-md hover:bg-gray-600">
                Back
            </a>
        </div>
    </form>
</div>
@endsection
