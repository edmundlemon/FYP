<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\api\v1\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::get('fetchImage/{lecturer}', [FileController::class, 'fetchImage']);

Route::post('/login', [LoginController::class, 'authenticate']);
// Route::middleware('auth:sanctum')->get('/lecturers', [LecturerController::class, 'index'])->name('lecturer.index');
Route::post('/register/lecturer', [LecturerController::class, 'store']);
// Route::get('/register/lecturer', [LecturerController::class, 'store']);

Route::post('/login', [LoginController::class, 'authenticate']);


Route::get('/lecturers', [LecturerController::class, 'index']);
// Route::group(['middleware' => 'auth:lecturer'], function () {
// });