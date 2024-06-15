<?php

use Illuminate\Http\Request;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthStudent;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AuthLecturer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\Free_SlotController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\QueueJob;
use App\Http\Controllers\api\v1\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/expire-slots', [ConsultationController::class, 'expire Slots']);

// Route::middleware('auth:sanctum')->get('/lecturers', [LecturerController::class, 'index'])->name('lecturer.index');
// Route::post('/register/lecturer', [LecturerController::class, 'store']);
// Route::get('/register/lecturer', [LecturerController::class, 'store']);

Route::get('/rating/{lecturer}', [ReviewController::class, 'index']);

Route::middleware('guest:sanctum')->post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/upload', [FileController::class, 'store']);
    // Route::post('/comments', [CommentController::class, 'store']);
    Route::get('/studentsfaculty', [StudentController::class, 'StudentFaculty']);
    Route::get('/lecturersfaculty', [LecturerController::class, 'LecturerFaculty']);
    //test api that return distincy lecturer faculty
    Route::get('/lecturers', [LecturerController::class, 'index']);
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/view/lecturer/{lecturer}', [LecturerController::class, 'view']);
    Route::get('/view/student/{student}', [StudentController::class, 'view']);
    Route::get('/free-slots/{lecturer}', [Free_SlotController::class, 'index']);
    Route::get('/upcoming/{lecturer}', [Free_SlotController::class, 'upcomingTime']);
    Route::get('/search', [SearchController::class, 'search']);
});

// Middleware to only allow lecturers
Route::group(['middleware' => AuthLecturer::class], function () {
    Route::get('/lecturer/schedule', [ConsultationController::class, 'lecturerIndex']);
    Route::get('/lecturer/pending', [ConsultationController::class, 'pending']);
    Route::get('/lecturer/approved', [ConsultationController::class, 'lecturerApproved']);
    Route::get('/lecturer/past', [ConsultationController::class, 'history']);
    Route::post('/free-slots', [Free_SlotController::class, 'store']);
    Route::delete('/free-slots/delete/{free_slot}', [Free_SlotController::class, 'destroy']);
    Route::put('/free-slots/edit/{free_slot}', [Free_SlotController::class, 'update']);
    Route::put('/lecturer/approve/{consultation_slot}', [ConsultationController::class, 'approve']);
    Route::put('/lecturer/reschedule/{consultation_slot}', [ConsultationController::class, 'lecturerUpdates']);
    Route::delete('/lecturer/reject/{consultation_slot}', [ConsultationController::class, 'lecturerDestroy']);
    Route::get('/lecturer/rejected', [ConsultationController::class, 'lecturerRejected']);
    Route::get('/lecturer/past', [ConsultationController::class, 'history']);
    Route::get('/lecturer/all-pending', [ConsultationController::class, 'allPending']);
    Route::get('/lecturer/all-past', [ConsultationController::class, 'allPast']);

});

// Middleware to only allow admins
Route::group(['middleware' => AuthAdmin::class], function () {
    Route::post('/register/student', [StudentController::class, 'store']);
    Route::post('/register/lecturer', [LecturerController::class, 'store']);
    Route::post('/register/admin', [AdminController::class, 'store']);
    Route::delete('/delete/admin/{admin}', [AdminController::class, 'destroy']);
});

// Middleware to only allow students
Route::group(['middleware' => AuthStudent::class], function () {
    Route::get('/student/schedule', [ConsultationController::class, 'studentIndex']);
    Route::get('/student/approved', [ConsultationController::class, 'studentApproved']);
    Route::get('/student/pending', [ConsultationController::class, 'pending']);
    Route::get('/student/past', [ConsultationController::class, 'history']);
    Route::post('/book/{lecturer}', [ConsultationController::class, 'store']);
    Route::put('/students/{student}', [StudentController::class, 'update']);
    Route::get('/students/{student}/edit', [StudentController::class, 'edit']);
    Route::put('/student/reschedule/{consultation_slot}', [ConsultationController::class, 'studentUpdates']);
    Route::get('/student/past', [ConsultationController::class, 'history']);
    Route::get('/student/rejected', [ConsultationController::class, 'studentRejected']);
    Route::put('/student/approve/{consultation_slot}', [ConsultationController::class, 'approve']);
    Route::get('/student/all-pending', [ConsultationController::class, 'allPending']);
    Route::get('/student/all-past', [ConsultationController::class, 'allPast']);
});
