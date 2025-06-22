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
            'file' => 'nullable|mimes:pdf,doc,docx,ppt,pptx|max:5120',
        ]);

        // Simpan file ke storage dengan path yang benar
        $filePath = $request->hasFile('file')
            ? $request->file('file')->store('modules/files', 'public')
            : null;

        // Simpan ke database
        Module::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'file_path' => $filePath,
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
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
        ]);

        // Update file jika ada perubahan
        if ($request->hasFile('file')) {
            if ($module->file_path) {
                Storage::disk('public')->delete($module->file_path);
            }
            $module->update(['file_path' => $request->file('file')->store('modules/files', 'public')]);
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
        if ($module->file_path) {
            Storage::disk('public')->delete($module->file_path);
        }

        // Hapus data dari database
        $module->delete();

        return redirect()->route('module.index')->with('success', 'Module berhasil dihapus!');
    }
//     public function show($id)
// {
//     $module = Module::with('category')->findOrFail($id);
//     return view('module.show', compact('module'));
// }

}
