<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDeadlineNotification;
use Carbon\Carbon;

class CheckTaskDeadlines extends Command
{
    protected $signature = 'tasks:check-deadlines';
    protected $description = '期限が近いタスクと期限切れタスクを確認して通知を送る';

    public function handle()
    {
        $now = Carbon::now();
        $notificationCount = 0;

        // 期限が24時間以内に迫っているタスク（未完了）
        $approachingTasks = Task::where('deadline', '<=', $now->copy()->addDay())
                               ->where('deadline', '>=', $now)
                               ->where('done', false)
                               ->whereNull('deadline_notified_at')
                               ->with('user')
                               ->get();

        foreach ($approachingTasks as $task) {
            $task->user->notify(new TaskDeadlineNotification($task, 'approaching'));
            
            // 共有ユーザーにも通知
            foreach ($task->sharedWithUsers as $sharedUser) {
                $sharedUser->notify(new TaskDeadlineNotification($task, 'approaching'));
            }
            
            // 通知済みフラグを設定
            $task->update(['deadline_notified_at' => $now]);
            $notificationCount++;
        }

        // 期限切れタスク（未完了）
        $expiredTasks = Task::where('deadline', '<', $now)
                           ->where('done', false)
                           ->whereNull('deadline_notified_at')
                           ->with('user')
                           ->get();

        foreach ($expiredTasks as $task) {
            $task->user->notify(new TaskDeadlineNotification($task, 'expired'));
            
            // 共有ユーザーにも通知
            foreach ($task->sharedWithUsers as $sharedUser) {
                $sharedUser->notify(new TaskDeadlineNotification($task, 'expired'));
            }
            
            // 通知済みフラグを設定
            $task->update(['deadline_notified_at' => $now]);
            $notificationCount++;
        }

        $this->info("期限通知を確認しました。{$notificationCount}件のタスクに通知を送信しました。");
    }
}
