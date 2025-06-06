<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\EmployerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/users', function(Request $request) {
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
