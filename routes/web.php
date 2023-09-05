<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    // return view('welcome');
    return view('index')->
    with("user", User::find(1));
})->name('home');


Route::get('/students/profile', [LoginController::class, "index"])->name('students.profile');


Route::get("/students/courses", [LoginController::class, "courses"])->name("students.courses");

Route::get("/students/timetable", [TimetableController::class, "index"])->name("students.timetable");
