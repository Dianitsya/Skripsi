<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('category')->get();
        return view('module.index', compact('modules'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('module.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maks 2MB
            'file' => 'nullable|mimes:pdf,doc,docx,ppt,pptx|max:5120', // Maks 5MB
        ]);

        // Simpan file ke storage
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('modules_images', 'public') : null;
        $filePath = $request->hasFile('file') ? $request->file('file')->store('modules_files', 'public') : null;

        // Simpan ke database
        Module::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imagePath,
            'file' => $filePath,
        ]);

        return redirect()->route('module.index')->with('success', 'Module berhasil diupload!');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $categories = Category::all();
        return view('module.edit', compact('module', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update file jika ada perubahan
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($module->file) {
                Storage::disk('public')->delete($module->file);
            }
            $module->file = $request->file('file')->store('modules_files', 'public');
        }

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($module->image) {
                Storage::disk('public')->delete($module->image);
            }
            $module->image = $request->file('image')->store('modules_images', 'public');
        }

        // Update data ke database
        $module->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('module.index')->with('success', 'Module berhasil diperbarui');
    }

    public function destroy($id)
    {
        $module = Module::findOrFail($id);

        // Hapus file dari storage jika ada
        if ($module->file) {
            Storage::disk('public')->delete($module->file);
        }

        if ($module->image) {
            Storage::disk('public')->delete($module->image);
        }

        // Hapus data dari database
        $module->delete();

        return redirect()->route('module.index')->with('success', 'Module berhasil dihapus!');
    }
}
