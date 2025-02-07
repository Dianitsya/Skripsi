@extends('layouts.app')

@section('content')
<div class="max-w-4xl p-6 mx-auto mt-16 bg-white rounded-lg shadow-lg">
    <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Categories</h2>

    <!-- Form Tambah Category -->
    <form action="{{ route('category.store') }}" method="POST" class="mb-8">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Category Name</label>
            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
        </div>
        <button type="submit" class="w-full py-2 text-white transition duration-300 bg-blue-500 rounded-md hover:bg-blue-600">
            Add Category
        </button>
    </form>

    <!-- List Categories -->
    <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b">No</th>
                    <th class="px-6 py-3 text-left border-b">Name</th>
                    <th class="px-6 py-3 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr class="transition duration-200 hover:bg-gray-50">
                    <td class="px-6 py-4 text-center border-b">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 border-b">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-center border-b">
                        <a href="{{ route('category.edit', $category->id) }}" class="mr-4 font-medium text-yellow-500 hover:text-yellow-600">Edit</a>
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="font-medium text-red-500 hover:text-red-600" onclick="return confirm('Delete this category?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
