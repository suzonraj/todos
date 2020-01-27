<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//

Route::apiResource('todos', 'TodoController');
Route::post('todos/clear-completed', [TodoController::class, 'clearCompleted'])->name('todo.clear_complete');

// Specific Todo
Route::group(['prefix' => 'todo/{id}'], function () {
    Route::patch('/complete', [TodoController::class, 'complete'])->name('todo.complete');
});
