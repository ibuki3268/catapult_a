<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * 対応するモデル
     * @var string
     */
    protected $model = Task::class;

    /**
     * モデルのデフォルト状態を定義する
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fakerライブラリを使用してダミーデータを定義
        return [
            // 誰のタスクか：既存のユーザーのIDをランダムに設定
            'user_id' => User::factory(), 
            
            // タスクのタイトル：5語程度の文章
            'title' => $this->faker->sentence(5), 
            
            // タスクの内容：段落をランダムに生成
            'content' => $this->faker->paragraph, 
            
            // 完了フラグ：trueかfalseをランダムに設定
            'done' => $this->faker->boolean(20), // 20%の確率でtrue（完了）
            
            // 期限日：今日から30日以内の日付をランダムに設定
            'deadline' => $this->faker->optional()->dateTimeBetween('now', '+30 days'),
            
            // 優先度：ランダムな数字（例: 1=高, 2=中, 3=低）
            'priority' => $this->faker->numberBetween(1, 3), 
        ];
    }
    
    /**
     * 完了したタスクの状態を定義するステートメソッド
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'done' => true,
        ]);
    }
}
