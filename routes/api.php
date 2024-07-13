<?php

use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\Api\LectureController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

Route::resource('students', StudentController::class);
Route::resource('classrooms', ClassroomController::class);
Route::get('/classrooms/{id}/lectures', [ClassroomController::class, 'lectures']);
Route::post('/classrooms/{id}/setlectures', [ClassroomController::class, 'setlectures']);
Route::resource('lectures', LectureController::class);
