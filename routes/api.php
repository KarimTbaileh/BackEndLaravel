<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobbController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobSeekerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SavedJobController;


Route::get('/users', function(Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware(['auth:sanctum', 'abilities:employer'])->group(function () {
    Route::get('applications/job/{jobbId}', [ApplicationController::class, 'applicantsByJob']);
    Route::post('applications/{id}/accept', [ApplicationController::class, 'accept']);
    Route::post('applications/{id}/reject', [ApplicationController::class, 'reject']);

});

Route::middleware(['auth:sanctum', 'abilities:job_seeker'])->group(function () {
    Route::post('applications', [ApplicationController::class, 'store']);
    Route::get('applications', [ApplicationController::class, 'index']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/jobs', [JobbController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{id}', [JobbController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/search/{name}', [JobbController::class, 'search'])->name('jobs.search');

    Route::middleware(['auth:sanctum', 'abilitiesAny:admin,employer'])->group(function () {
        Route::put('/jobs/{id}', [JobbController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{id}', [JobbController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/jobs/employer/{employerId}', [JobbController::class, 'jobsByEmployer'])->name('jobs.byEmployer');
    });

    Route::middleware(['auth:sanctum', 'abilities:employer'])->group(function () {
        Route::post('/jobs', [JobbController::class, 'postJob'])->name('jobs.post');
        Route::post('/jobs/{id}/close', [JobbController::class, 'closeApplication'])->name('jobs.close');
        Route::post('/jobs/{id}/open', [JobbController::class, 'openApplication'])->name('jobs.open');
    });


    Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
        Route::post('/jobs/{id}/approve', [JobbController::class, 'approveJob'])->name('jobs.approve');
    });
});


    // ---------- Public Routes (No auth required) ----------
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);


    // ---------- Authenticated but General Access (Just auth:sanctum) ----------
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('user/{id}/employer', [UserController::class, 'getEmployer'])->middleware('auth:sanctum');


    // ========== Admin Routes ==========
    Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {

    // UserController (Admin only)
    Route::post('/create', [UserController::class, 'store']);
    Route::get('/print_all', [UserController::class, 'index']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::get('/show/{id}', [UserController::class, 'show']);
    Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    Route::apiResource('user', UserController::class)->only(['index', 'store', 'update', 'destroy', 'show']);

    // EmployerController (Admin abilities)
    Route::get('/print_all_employer', [EmployerController::class, 'index']);
    Route::get('/show_employer/{id}', [EmployerController::class, 'show']);
    Route::put('/update_employer/{id}', [EmployerController::class, 'update']);
    Route::delete('/delete_employer/{id}', [EmployerController::class, 'destroy']);
    Route::get('employer/search', [EmployerController::class, 'search']);
    Route::apiResource('employer', EmployerController::class)->only(['index', 'show', 'update', 'destroy']);

    // JobSeekerController (Admin abilities)
    Route::get('job_seeker/search', [JobSeekerController::class, 'search']);
    Route::apiResource('job_seeker', JobSeekerController::class)->only(['index', 'update', 'destroy']);
});


// ========== Employer Routes ==========
Route::middleware(['auth:sanctum', 'abilities:employer'])->group(function () {

    // EmployerController (Employer abilities)
    Route::put('/update_employer/{id}', [EmployerController::class, 'update']);
    Route::delete('/delete_employer/{id}', [EmployerController::class, 'destroy']);
    Route::get('employer/search', [EmployerController::class, 'search']);

    // JobSeekerController (Employer abilities)
    Route::get('job_seeker/search', [JobSeekerController::class, 'search']);
    Route::get('/job_seeker', [JobSeekerController::class, 'index']);
});


// ========== Job Seeker Routes ==========
Route::middleware(['auth:sanctum', 'abilities:job_seeker'])->group(function () {

    // EmployerController (Job Seeker abilities)
    Route::get('/print_all_employer', [EmployerController::class, 'index']);
    Route::get('/show_employer/{id}', [EmployerController::class, 'show']);
    Route::get('employer/search', [EmployerController::class, 'search']);

    // JobSeekerController (Job Seeker abilities)
    Route::get('job_seeker/search', [JobSeekerController::class, 'search']);
    Route::put('/update_job_seeker', [JobSeekerController::class, 'update']);
    Route::delete('/delete_job_seeker', [JobSeekerController::class, 'destroy']);
    Route::get('/job_seeker', [JobSeekerController::class, 'index']);
});


Route::middleware(['auth:sanctum', 'abilities:job_seeker'])->group(function () {
    Route::get('/saved-jobs', [SavedJobController::class, 'index']);
    Route::post('/saved-jobs', [SavedJobController::class, 'store']);
    Route::delete('/saved-jobs/{id}', [SavedJobController::class, 'destroy']);
});
