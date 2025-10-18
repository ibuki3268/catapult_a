<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// トップ・ログイン
Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [PageController::class, 'loginSubmit'])->name('login.submit');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::post('/register', [PageController::class, 'register']);


// タスク（TaskController に委譲）
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Ajax用: タスクのdone状態をトグル
Route::patch('/tasks/{task}/toggle-done', [TaskController::class, 'toggleDone'])->name('tasks.toggleDone');

Route::get('/tasks/delete-completed', [TaskController::class, 'deleteCompletedView'])->name('tasks.deleteCompleted.view');
Route::delete('/tasks/delete-completed', [TaskController::class, 'deleteCompletedExecute'])->name('tasks.deleteCompleted.execute');

// マイページ
Route::get('/mypage', [PageController::class, 'mypage'])->name('mypage');
// 検索（必要なら TaskController に移行）
Route::get('/tasks/search', [PageController::class, 'taskSearch'])->name('tasks.search');

// 共有メンバー
Route::get('/shared/members', [PageController::class, 'sharedMembers'])->name('shared.members');


//リスト
Route::post('/lists', [ListController::class, 'store'])->name('lists.store');
Route::put('/lists/{id}', [ListController::class, 'update'])->name('lists.update');
Route::delete('/lists/{id}', [ListController::class, 'destroy'])->name('lists.destroy');

