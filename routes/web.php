<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndustryPartnerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

use App\Models\User;



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

Route::resource('IndustryPartner', IndustryPartnerController::class);
Route::get('/', [IndustryPartnerController::class, 'index']);
Route::get('/IndustryPartner/{id}', [IndustryPartnerController::class, 'show']);

Route::get('/Project/{id}', [IndustryPartnerController::class, 'showProject']);
Route::get('/projectsList', [ProjectController::class, 'projectsList']);
Route::post('/project/{id}/apply', [ProjectController::class, 'apply'])->name('project.apply');
Route::delete('/project/tempDeleteFile/{fileId}', [ProjectController::class, 'fileDelete'])->name('project.fileDelete');
Route::get('/auto-assign', [ProjectController::class, 'autoAssign'])->name('auto.assign');
Route::resource('project', ProjectController::class);


Route::get('/student/{id}/profile', [StudentController::class, 'showProfile'])->name('student.profile');
Route::get('/student/{id}/edit', [StudentController::class, 'editProfile'])->name('student.edit');
Route::put('/student/{id}', [StudentController::class, 'updateProfile'])->name('student.update');

Route::get('/teacher/approvals', [TeacherController::class, 'showApprovals'])->name('teacher.approvals');
Route::post('/teacher/approve/{id}', [TeacherController::class, 'approve'])->name('teacher.approve');
Route::post('/teacher/reject/{id}', [TeacherController::class, 'reject'])->name('teacher.reject');
Route::get('/teacher/students', [TeacherController::class, 'students'])->name('teacher.students');
Route::get('/teacher/studentProfile/{id}', [TeacherController::class, 'studentProfile'])->name('teacher.studentProfile');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
