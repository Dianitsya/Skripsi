<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class NewTaskNotification extends Notification
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->task->title,  // Hanya judul tugas
            'deadline' => Carbon::parse($this->task->deadline)->format('d M Y H:i'),  // Format deadline dengan tanggal dan jam
            'url' => route('tasks.show', $this->task->id),
        ];
    }
}
