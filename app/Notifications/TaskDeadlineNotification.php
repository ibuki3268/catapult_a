<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;
    public $type; // 'approaching' or 'expired'

    /**
     * Create a new notification instance.
     */
    public function __construct($task, $type = 'expired')
    {
        $this->task = $task;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->type === 'approaching' 
            ? 'タスクの期限が近づいています' 
            : 'タスクの期限が過ぎています';
            
        $greeting = $this->type === 'approaching'
            ? 'タスクの期限が24時間以内に迫っています。'
            : 'タスクの期限が過ぎています。確認してください。';

        return (new MailMessage)
            ->subject($subject)
            ->line($greeting)
            ->line("タスク: {$this->task->title}")
            ->line("期限: {$this->task->deadline->format('Y年m月d日')}")
            ->action('タスクを確認', url('/tasks/' . $this->task->id))
            ->line('早めの対応をお願いします。');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }

    public function toDatabase($notifiable)
    {
        $message = $this->type === 'approaching'
            ? "「{$this->task->title}」の期限が24時間以内に迫っています！"
            : "「{$this->task->title}」の期限が過ぎています！";

        return [
            'type' => $this->type,
            'message' => $message,
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'deadline' => $this->task->deadline->toDateString(),
            'url' => url('/tasks/' . $this->task->id),
        ];
    }
}
