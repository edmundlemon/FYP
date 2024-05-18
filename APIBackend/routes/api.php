<?php

use Illuminate\Http\Request;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthStudent;
use App\Http\Middleware\AuthLecturer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\Free_SlotController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\api\v1\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// Route::middleware('auth:sanctum')->get('/lecturers', [LecturerController::class, 'index'])->name('lecturer.index');
Route::post('/register/lecturer', [LecturerController::class, 'store']);
// Route::get('/register/lecturer', [LecturerController::class, 'store']);

Route::middleware('guest:sanctum')->post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/upload', [FileController::class, 'store']);
    // Route::post('/comments', [CommentController::class, 'store']);
    
    Route::get('/lecturers', [LecturerController::class, 'index']);
    Route::get('/lecturers/{lecturer}', [LecturerController::class, 'view']);
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{student}', [StudentController::class, 'view']);
    Route::get('/free-slots', [Free_SlotController::class, 'index']);
    Route::get('/upcoming/{lecturer}', [Free_SlotController::class, 'upcomingTime']);
});

// Middleware to only allow lecturers
Route::group(['middleware' => AuthLecturer::class], function () {
    Route::get('/lecturer/schedule', [ConsultationController::class, 'lecturerIndex']);
    Route::get('/lecturers', [LecturerController::class, 'index']);
    Route::post('/free-slots', [Free_SlotController::class, 'store']);
    Route::delete('/free-slots/delete/{free_slot}',[Free_SlotController::class, 'destroy']);
    Route::put('/free-slots/edit/{free_slot}', [Free_SlotController::class, 'update']);
    Route::put('/approve/{consultation_slot}', [ConsultationController::class, 'approve']);
    Route::put('lecturer/reschedule/{consultation_slot}', [ConsultationController::class, 'lecturerUpdates']);
    Route::delete('lecturer/reject/{consultation_slot}', [ConsultationController::class, 'lecturerDestroy']);
});

// Middleware to only allow admins
Route::group(['middleware' => AuthAdmin::class], function () {
    Route::post('/register/student', [StudentController::class, 'store']);
    Route::post('/register/lecturer', [LecturerController::class, 'store']);
});

// Middleware to only allow students
Route::group(['middleware' => AuthStudent::class], function () {
    Route::get('/student/schedule', [ConsultationController::class, 'studentIndex']);
    Route::post('/book/{lecturer}', [LecturerController::class, 'store']);
    Route::put('/students/{student}', [StudentController::class, 'update']);
    Route::get('/students/{student}/edit', [StudentController::class, 'edit']);
    Route::put('student/reschedule/{consultation_slot}', [ConsultationController::class, 'studentUpdates']);
});