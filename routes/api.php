<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\EmployeerController;
use App\Http\Controllers\JobbController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
    Route::apiResource('employeers', EmployeerController::class);
    Route::apiResource('jobbs', JobbController::class)->only(['update', 'destroy', 'store']);
    Route::post('jobbs/post', [JobbController::class, 'postJob']);
    Route::get('jobbs/employer/{employeerId}', [JobbController::class, 'jobsByEmployer']);
    Route::post('jobbs/{id}/approve', [JobbController::class, 'approveJob']);
    Route::post('jobbs/{id}/close', [JobbController::class, 'closeApplication']);
    Route::apiResource('applications', ApplicationController::class)->only([ 'show', 'update', 'destroy']);
});

Route::middleware(['auth:sanctum', 'abilities:employeer'])->group(function () {
    Route::get('applications/job/{jobbId}', [ApplicationController::class, 'applicantsByJob']);
    Route::post('applications/{id}/accept', [ApplicationController::class, 'accept']);
    Route::post('applications/{id}/reject', [ApplicationController::class, 'reject']);
    Route::apiResource('jobbs', JobbController::class)->only(['update', 'destroy', 'store']);
    Route::post('jobbs/post', [JobbController::class, 'postJob']);
    Route::get('jobbs/employer/{employeerId}', [JobbController::class, 'jobsByEmployer']);
    Route::post('jobbs/{id}/close', [JobbController::class, 'closeApplication']);
    Route::get('employeers', [EmployeerController::class, 'index']);
    Route::get('employeers/{id}', [EmployeerController::class, 'show']);
    Route::get('employeers/search/{name}', [EmployeerController::class, 'search']);
});

Route::middleware(['auth:sanctum', 'abilities:job_seeker'])->group(function () {
    Route::post('applications', [ApplicationController::class, 'store']);
    Route::get('applications', [ApplicationController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('jobbs', [JobbController::class, 'index']);
    Route::get('jobbs/{id}', [JobbController::class, 'show']);
    Route::get('jobbs/search/{name}', [JobbController::class, 'search']);
});
