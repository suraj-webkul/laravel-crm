<?php


use Illuminate\Support\Facades\Route;
use Webkul\Chatter\Http\Controllers\TaskController;

Route::get('/tasks/{taskId}/followers', [TaskController::class, 'getFollowers'])->name('tasks.getFollowers');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::post('/tasks/{taskId}/followers/{userId}', [TaskController::class, 'addFollower'])->name('tasks.addFollower');
Route::delete('/tasks/{taskId}/followers/{userId}', [TaskController::class, 'removeFollower'])->name('tasks.removeFollower');
Route::get('/tasks/{taskId}/messages', [TaskController::class, 'showMessages'])->name('tasks.showMessages');
Route::post('/tasks/{taskId}/messages', [TaskController::class, 'postMessage'])->name('tasks.postMessage');
