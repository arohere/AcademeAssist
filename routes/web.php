<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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
    return view('index');
})->name('home');


Route::get('/students/profile', [LoginController::class, "index"])->name('students.profile');

Route::get("/students/timetable", [LoginController::class, "timetable"])->name("students.timetable");

Route::get("/students/attendance", [LoginController::class, "attendance"])->name("students.attendance");
