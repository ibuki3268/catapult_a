<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/tasks', [PageController::class, 'taskIndex'])->name('tasks.index');
Route::get('/tasks/create', [PageController::class, 'taskCreate'])->name('tasks.create');
Route::get('/tasks/edit', [PageController::class, 'taskEdit'])->name('tasks.edit');
Route::get('/mypage', [PageController::class, 'mypage'])->name('mypage');