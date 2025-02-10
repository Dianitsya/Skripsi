<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request, $taskId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        Feedback::create([
            'task_id' => $taskId,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }

    // Metode untuk menghapus feedback
    public function destroy($taskId, $feedbackId)
    {
        // Mencari task
        $task = Task::findOrFail($taskId);  // Pastikan Task diimpor

        // Mencari feedback yang sesuai dengan task dan feedbackId
        $feedback = Feedback::where('task_id', $task->id)
                            ->where('id', $feedbackId)
                            ->first();

        if ($feedback) {
            // Hapus feedback
            $feedback->delete();

            // Redirect ke halaman tugas dengan pesan sukses
            return redirect()->route('tasks.show', $taskId)
                             ->with('success', 'Feedback berhasil dihapus.');
        }

        // Jika feedback tidak ditemukan
        return redirect()->route('tasks.show', $taskId)
                         ->with('error', 'Feedback tidak ditemukan.');
    }
}
