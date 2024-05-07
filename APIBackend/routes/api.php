<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\api\v1\CommentController;
use App\Http\Middleware\AuthLecturer;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthStudent;

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

// Middleware to only allow lecturers
Route::group(['middleware' => AuthLecturer::class], function () {
    Route::get('/lecturers', [LecturerController::class, 'index']);
});

// Middleware to only allow admins
Route::group(['middleware' => AuthAdmin::class], function () {
    
});

// Middleware to only allow students
Route::group(['middleware' => AuthStudent::class], function () {

});