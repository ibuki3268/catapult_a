<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// トップ・ログイン
Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [PageController::class, 'loginSubmit'])->name('login.submit');

// タスク
Route::get('/tasks', [PageController::class, 'taskIndex'])->name('tasks.index');
Route::get('/tasks/create', [PageController::class, 'taskCreate'])->name('tasks.create');
Route::post('/tasks', [PageController::class, 'taskStore'])->name('tasks.store');
Route::get('/tasks/{id}/edit', [PageController::class, 'taskEdit'])->name('tasks.edit');
Route::put('/tasks/{id}', [PageController::class, 'taskUpdate'])->name('tasks.update');
Route::delete('/tasks/{id}', [PageController::class, 'taskDestroy'])->name('tasks.destroy');

// マイページ
Route::get('/mypage', [PageController::class, 'mypage'])->name('mypage');
// 検索
Route::get('/tasks/search', [PageController::class, 'taskSearch'])->name('tasks.search');

// 共有メンバー
Route::get('/shared/members', [PageController::class, 'sharedMembers'])->name('shared.members');

// 完了タスク削除
Route::get('/tasks/delete-completed', [PageController::class, 'deleteCompletedView'])->name('tasks.deleteCompleted');
Route::delete('/tasks/delete-completed', [PageController::class, 'deleteCompletedExecute'])->name('tasks.deleteCompleted');