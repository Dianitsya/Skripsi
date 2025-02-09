<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Str;
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file' => 'nullable|mimes:pdf,doc,docx,ppt,pptx|max:5120',
        ]);

        // Simpan file ke storage dengan path yang benar
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('modules/images', 'public')
            : null;

        $filePath = $request->hasFile('file')
            ? $request->file('file')->store('modules/files', 'public')
            : null;

        // Simpan ke database
        Module::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image_path' => $imagePath,
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update file jika ada perubahan
        if ($request->hasFile('file')) {
            if ($module->file_path) {
                Storage::disk('public')->delete($module->file_path);
            }
            $module->update(['file_path' => $request->file('file')->store('modules/files', 'public')]);
        }

        if ($request->hasFile('image')) {
            if ($module->image_path) {
                Storage::disk('public')->delete($module->image_path);
            }
            $module->update(['image_path' => $request->file('image')->store('modules/images', 'public')]);
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

        if ($module->image_path) {
            Storage::disk('public')->delete($module->image_path);
        }

        // Hapus data dari database
        $module->delete();

        return redirect()->route('module.index')->with('success', 'Module berhasil dihapus!');
    }
    public function show($id)
    {
        $module = Module::findOrFail($id);

        if (!$module->file_path || !Storage::disk('public')->exists($module->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $fileUrl = asset('storage/' . $module->file_path);
        $extension = strtolower(pathinfo($module->file_path, PATHINFO_EXTENSION));

        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        $isPdf = $extension === 'pdf';
        $isTextFile = in_array($extension, ['txt', 'csv']);
        $isDoc = in_array($extension, ['doc', 'docx']);
        $isPpt = in_array($extension, ['ppt', 'pptx']);

        $fileContent = null;
        $googleViewerUrl = null;

        if ($isTextFile) {
            $fileContent = Storage::disk('public')->get($module->file_path);
        }

        if ($isDoc || $isPpt) {
            $pdfPath = storage_path('app/public/' . pathinfo($module->file_path, PATHINFO_FILENAME) . '.pdf');

            if (!file_exists($pdfPath)) {
                \PhpOffice\PhpWord\Settings::setPdfRendererName(\PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF);
                \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));

                $phpWord = \PhpOffice\PhpWord\IOFactory::load(storage_path('app/public/' . $module->file_path));
                $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
                $pdfWriter->save($pdfPath);
            }

            $fileUrl = asset('storage/' . pathinfo($module->file_path, PATHINFO_FILENAME) . '.pdf');
            $isPdf = true;
        }

        return view('module.show', compact(
            'fileUrl', 'isImage', 'isPdf', 'isTextFile',
            'isDoc', 'isPpt', 'fileContent', 'googleViewerUrl'
        ));
    }

}
