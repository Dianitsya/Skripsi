<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil kategori dengan jumlah modul yang terkait
        $categories = Category::withCount('modules')->get();

        return view('category.index', compact('categories'));
    }

    public function create()
{
    $categories = Category::all(); // Ambil semua kategori dari database
    return view('modules.create', compact('categories')); // Kirim ke view
}

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|max:255|unique:categories,name',
        ]);

        // Membuat kategori baru
        Category::create([
            'name' => ucfirst($request->name),
        ]);

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        // Hanya admin yang boleh mengedit kategori
        if (auth()->user()->is_admin) {
            return view('category.edit', compact('category'));
        } else {
            return redirect()->route('category.index')->with('danger', 'You are not authorized to edit this category!');
        }
    }

    public function update(Request $request, Category $category)
    {
        // Hanya admin yang boleh memperbarui kategori
        if (auth()->user()->is_admin) {
            $request->validate([
                'name' => 'required|max:255|unique:categories,name,' . $category->id,
            ]);

            $category->update([
                'name' => ucfirst($request->name),
            ]);

            return redirect()->route('category.index')->with('success', 'Category updated successfully!');
        } else {
            return redirect()->route('category.index')->with('danger', 'You are not authorized to update this category!');
        }
    }

    public function destroy(Category $category)
    {
        // Hanya admin yang boleh menghapus kategori
        if (auth()->user()->is_admin) {
            $category->delete();
            return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
        } else {
            return redirect()->route('category.index')->with('danger', 'You are not authorized to delete this category!');
        }
    }
}
