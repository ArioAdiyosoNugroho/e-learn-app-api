<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResultController;
use App\Models\question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // =====categories=====
    Route::apiResource('category', CategoryController::class);
    // =====Materi=========
    Route::apiResource('materi', MateriController::class);
    // =====Quiz===========
    Route::apiResource('quiz', QuizController::class);

    // proses dulu ygy
    // =====Questions======
    Route::apiResource('question', QuestionController::class);
    // =====questions options=======
    Route::apiResource('question-option', QuestionOptionController::class);
    // =====Results=======
    Route::apiResource('result', ResultController::class);
    // =====Answers=======
    Route::apiResource('answer', AnswerController::class);
});
