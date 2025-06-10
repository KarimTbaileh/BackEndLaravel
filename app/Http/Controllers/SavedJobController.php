<?php

namespace App\Http\Controllers;

use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('abilities:job_seeker')->only(['store', 'destroy', 'index']);
    }

    public function index()
    {
        $user = Auth::user();
        $jobSeeker = $user->jobSeeker;

        if (!$jobSeeker) {
            return response()->json(['message' => 'Job seeker not found'], 404);
        }

        $savedJobs = SavedJob::with(['job'])
            ->where('job_seeker_id', $jobSeeker->id)
            ->get();

        return response()->json([
            'message' => 'Saved jobs retrieved successfully',
            'saved_jobs' => $savedJobs
        ], 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $jobSeeker = $user->jobSeeker;

        if (!$jobSeeker) {
            return response()->json(['message' => 'Job seeker not found'], 404);
        }

        $request->validate([
            'job_id' => 'required|exists:jobs,id',
        ]);

        $exists = SavedJob::where('job_seeker_id', $jobSeeker->id)
            ->where('job_id', $request->job_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Job already saved'], 409);
        }

        $savedJob = SavedJob::create([
            'job_seeker_id' => $jobSeeker->id,
            'job_id' => $request->job_id,
        ]);

        return response()->json([
            'message' => 'Job saved successfully',
            'saved_job' => $savedJob
        ], 201);
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $jobSeeker = $user->jobSeeker;

        if (!$jobSeeker) {
            return response()->json(['message' => 'Job seeker not found'], 404);
        }

        $savedJob = SavedJob::where('id', $id)
            ->where('job_seeker_id', $jobSeeker->id)
            ->first();

        if (!$savedJob) {
            return response()->json(['message' => 'Saved job not found'], 404);
        }

        $savedJob->delete();

        return response()->json([
            'message' => 'Saved job deleted successfully'
        ], 204);
    }
}
