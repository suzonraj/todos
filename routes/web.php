<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('index');
});

Route::apiResource('todos', 'TodoController');
Route::post('todos/clear-completed', [TodoController::class, 'clearCompleted'])->name('todo.clear_complete');

// Specific Todo
Route::group(['prefix' => 'todo/{id}'], function () {
    Route::patch('/complete', [TodoController::class, 'complete'])->name('todo.complete');
});
