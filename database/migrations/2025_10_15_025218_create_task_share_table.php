<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_share', function (Blueprint $table) {
            $table->id();
            // 共有されるタスクのID
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            // 共有先のユーザーID
            $table->foreignId('shared_with_user_id')->constrained('users')->cascadeOnDelete();
            // 共有の種類（例: 'read', 'edit'など）
            $table->enum('premission', ['read', 'edit'])->default('read');

            $table->unique(['task_id', 'shared_with_user_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_share');
    }
};
