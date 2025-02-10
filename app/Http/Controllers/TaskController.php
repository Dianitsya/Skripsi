<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Submission;
use Illuminate\Http\Request;
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
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:2048', // File max 2MB
    ]);

    $filePath = null;
    if ($request->hasFile('file')) {
        $filePath = $request->file('file')->store('tasks', 'public'); // Simpan di storage/public/tasks
    }

    Task::create([
        'title' => $request->title,
        'description' => $request->description,
        'file_path' => $filePath,
        'user_id' => Auth::id(), // Tambahkan user_id
    ]);

    return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan!');
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
}
