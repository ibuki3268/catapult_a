<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // list_idカラムがなければ追加
            if (!Schema::hasColumn('tasks', 'list_id')) {
                $table->foreignId('list_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // list_idカラムがあれば削除
            if (Schema::hasColumn('tasks', 'list_id')) {
                $table->dropForeign(['list_id']);
                $table->dropColumn('list_id');
            }
        });
    }
};