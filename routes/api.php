<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('student', [StudentsController::class, 'index']);
    Route::get('student/{id}', [StudentsController::class, 'view']);
    Route::get('student/{id}/edit', [StudentsController::class, 'edit']);
    Route::put('student/{id}/edit', [StudentsController::class, 'update']);
    Route::delete('student/{id}/delete', [StudentsController::class, 'delete']);
    Route::post('student/logout', [AuthController::class, 'logout']);
});

