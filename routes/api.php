<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\EmployeerController;
use App\Http\Controllers\JobbController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// فلترة الوظائف
Route::get('/jobs', [JobbController::class, 'index']);

// عرض أحدث الوظائف
Route::get('/jobs/latest', [JobbController::class, 'latestJobs']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('companies', CompanyController::class);
Route::apiResource('employeers', EmployeerController::class);
Route::get('employeers/search/{name}', [EmployeerController::class, 'search']);

Route::apiResource('jobbs', JobbController::class);
Route::get('jobbs/search/{name}', [JobbController::class, 'search']);
Route::post('jobbs/post', [JobbController::class, 'postJob']);
Route::get('jobbs/employer/{employeerId}', [JobbController::class, 'jobsByEmployer']);

Route::apiResource('applications', ApplicationController::class);
Route::post('applications/{id}/accept', [ApplicationController::class, 'accept']);
Route::post('applications/{id}/reject', [ApplicationController::class, 'reject']);
Route::get('applications/job/{jobbId}', [ApplicationController::class, 'applicantsByJob']);
