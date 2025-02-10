<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Feedback;
use App\Notifications\NewTaskNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'deadline' => 'required|date',
        'file' => 'nullable|file|mimes:jpg,png,pdf,docx',  // Validasi file yang diupload
    ]);

    // Menyimpan file jika ada
    $filePath = null;
    if ($request->hasFile('file')) {
        $filePath = $request->file('file')->store('tasks');  // Menyimpan file di folder 'tasks'
    }

    // Membuat tugas baru dan menyimpan data
    Task::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'deadline' => $validated['deadline'],
        'file' => $filePath,  // Menyimpan path file ke database
        'user_id' => auth()->id(),  // Menyimpan user_id yang sedang login
    ]);

    return redirect()->route('tasks.index');
}



    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function submitAnswer(Request $request, $taskId)
    {
        $request->validate([
            'answer_file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:2048',
        ]);

        $filePath = $request->file('answer_file')->store('submissions', 'public');

        Submission::create([
            'task_id' => $taskId,
            'user_id' => Auth::id(),
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Jawaban berhasil dikumpulkan!');
    }
    public function destroy($id)
    {
        // Temukan task berdasarkan ID
        $task = Task::findOrFail($id);

        // Hapus task dari database
        $task->delete();

        // Kembalikan response, bisa dengan pesan atau redirect
        return redirect()->route('tasks.index')->with('success', 'Task berhasil dihapus!');
    }
    public function deleteFeedback($taskId, $feedbackId)
{
    $feedback = Feedback::findOrFail($feedbackId);
    // Pastikan feedback milik task yang benar
    if ($feedback->task_id === $taskId) {
        $feedback->delete();
        return redirect()->route('tasks.show', $taskId)->with('success', 'Feedback berhasil dihapus.');
    }

    return redirect()->route('tasks.show', $taskId)->with('error', 'Feedback tidak ditemukan.');
}

}
