<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Todo;
use App\Notifications\TaskDeadlinePassed;
use Carbon\Carbon;

class CheckTaskDeadlines extends Command
{
    protected $signature = 'tasks:check-deadlines';
    protected $description = '期限切れタスクを確認して通知を送る';

    public function handle()
    {
        $now = Carbon::now();

        $expiredTasks = Todo::where('due_date', '<', $now)
                            ->where('is_completed', false)
                            ->get();

        foreach ($expiredTasks as $task) {
            $task->user->notify(new TaskDeadlinePassed($task));
        }

        $this->info('期限切れタスクを確認しました。');
    }
}
