<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\Free_SlotController;
use App\Http\Controllers\ConsultationController;
use App\Models\Lecturer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // \Illuminate\Support\Facades\Mail::send(new \App\Mail\TestMail());
    return view('app');
});
// Route::get('/main', function () {
//     // \Illuminate\Support\Facades\Mail::send(new \App\Mail\TestMail());
//     return view('hello');
// });
// * Login for all users
Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest:student,lecturer,admin');
Route::post('/login', [LoginController::class, 'authenticate']);

// * Logout route, by POST or GET method
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// * Register for student
Route::get('/register/student', function () {
    return view('testpages.register-student');
})->name('register.student')->middleware('auth:admin', 'role:admin');
Route::post('/register/student', [StudentController::class, 'store']);

// * View all students
Route::get('/students', [StudentController::class, 'index'])->name('student.index')->middleware(['auth:admin', 'role:admin']);
// * View a single student
Route::get('/students/{student}', [StudentController::class, 'show'])->name('student.show')->middleware(['auth:admin, lecturer', 'role:admin']);

// * Student Profile Edit
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('student.edit')->middleware('auth:student', 'role:student');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('student.update')->middleware('auth:student', 'role:student');

// * View all lecturers
// Route::get('/lecturers', [LecturerController::class, 'index'])->name('lecturer.index');
// * View a single lecturer
Route::get('/lecturers/{lecturer}', [LecturerController::class, 'view'])->name('lecturer.view');

// * Register for lecturer
Route::get('/register/lecturer', [LecturerController::class, 'create']);
// ->name('register.lecturer')->middleware('auth:admin', 'role:admin');
// Route::post('/register/lecturer', [LecturerController::class, 'store']);

// *Route to manage free slots
Route::get('/free-slots', [Free_SlotController::class, 'index'])->name('free_slots.index')->middleware('auth:lecturer', 'role:lecturer');
Route::post('/free-slots', [Free_SlotController::class, 'store'])->name('free_slot.index')->middleware('auth:lecturer', 'role:lecturer');
Route::delete('/free-slots/delete/{free_slot}', [Free_SlotController::class, 'destroy'])->name('free_slots.delete')->middleware('auth:lecturer', 'role:lecturer');
Route::put('/free-slots/edit/{free_slot}', [Free_SlotController::class, 'update'])->name('free_slots.edit')->middleware('auth:lecturer', 'role:lecturer');

// *To check the upcoming appointment
Route::get('/upcoming', [ConsultationController::class, 'upcomingAppointment'])->name('upcoming');

// *To check the upcoming slots of a lecturer
Route::get('/upcoming/{lecturer}', [Free_SlotController::class, 'upcomingTime'])->name('upcoming');

// *To approve an upcoming slot
Route::put('/approve/{consultation_slot}', [ConsultationController::class, 'approve'])->name('approve')->middleware('auth:lecturer', 'role:lecturer');

// *To book a slot
Route::get('/book/{lecturer}', [LecturerController::class, 'view'])->name('book')->middleware('auth:student', 'role:student');
Route::post('/book/{lecturer}', [ConsultationController::class, 'store'])->name('book')->middleware('auth:student', 'role:student');

// * To view the schedule
Route::get('/student/schedule', [ConsultationController::class, 'studentIndex'])->name('reschedule')->middleware('auth:student', 'role:student');
Route::get('/lecturer/schedule', [ConsultationController::class, 'lecturerIndex'])->name('reschedule')->middleware('auth:lecturer', 'role:lecturer');

// * To reschedule a slot
Route::put('student/reschedule/{consultation_slot}', [ConsultationController::class, 'studentUpdates'])->name('reschedule')->middleware('auth:student', 'role:student');
Route::put('lecturer/reschedule/{consultation_slot}', [ConsultationController::class, 'lecturerUpdates'])->name('reschedule')->middleware('auth:lecturer', 'role:lecturer');

// * To reject a slot
Route::delete('lecturer/reject/{consultation_slot}', [ConsultationController::class, 'lecturerDestroy'])->name('reject')->middleware('auth:lecturer', 'role:lecturer');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:student,lecturer,admin', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__.'/auth.php';
