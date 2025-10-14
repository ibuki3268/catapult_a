<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'welcome']);
Route::get('/login', [PageController::class, 'login']);
Route::get('/tasks', [PageController::class, 'taskIndex']);
Route::get('/tasks/create', [PageController::class, 'taskCreate']);
Route::get('/tasks/edit', [PageController::class, 'taskEdit']);
Route::get('/mypage', [PageController::class, 'mypage']);
