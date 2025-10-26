<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskShareController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ユーザーIDを指定して、共有相手を追加
Route::post('/share/{user}', [TaskShareController::class, 'create'])
     ->name('share.create');
    
// 共有相手の削除
Route::delete('/share/{user}', [TaskShareController::class, 'destroy'])
     ->name('share.destroy');


require __DIR__.'/auth.php';
require __DIR__.'/ui.php';

// 通知機能
Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
Route::get('/create-notifications', [TaskController::class, 'createNotifications']);