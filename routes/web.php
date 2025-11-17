<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseTopicController;
use App\Http\Controllers\QuizController;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/admin', function () {
    return 'Welcome Admin!';
})->middleware('role:admin');
 
Route::get('/signup', [AuthController::class, 'showSignUp'])->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.store');

 
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

 Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//   Dashboard (protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

 
Route::get('password/reset', [ForgetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ForgetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ForgetPasswordController::class, 'reset'])->name('password.update');

// Course Management (AJAX)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

 
Route::get('/courses/{id}/topics', [CourseTopicController::class, 'index'])->name('topics.index');
Route::post('/courses/{id}/topics', [CourseTopicController::class, 'store'])->name('topics.store');
Route::delete('/topics/{id}', [CourseTopicController::class, 'destroy'])->name('topics.destroy');


Route::get('/topics/{topic}/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
Route::post('/topics/{topic}/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
