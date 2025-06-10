<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobbController;

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/jobbs/index',
    [JobbController::class, 'index']);

Route::get('/jobbs/create',
    [JobbController::class, 'create']);

Route::post('/login', [UserController::class, 'login']);


Route::get('/jobSeekers/index',
    [JobseekerController::class, 'index']);
