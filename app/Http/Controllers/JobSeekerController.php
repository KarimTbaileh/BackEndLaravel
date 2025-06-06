<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\JobSeeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JobSeekerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');

        $this->middleware('abilities:admin')->only(['index', 'destroy','search']);

        $this->middleware('abilities:employer')->only(['index','search']);

        $this->middleware('abilities:job_seeker')->only(['index', 'update','destroy','search']);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'job_seeker') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'country' => 'sometimes|string|max:255',
            'gender' => 'sometimes|in:male,female',
            'day' => 'sometimes|integer|min:1|max:31',
            'month' => 'sometimes|integer|min:1|max:12',
            'year' => 'sometimes|integer|min:1900|max:2100',
        ]);

        $jobSeeker = $user->jobSeeker;

        $jobSeeker->update($request->only(['country', 'gender', 'day', 'month', 'year']));

        return response()->json([
            'message' => 'Job seeker profile updated successfully',
            'job_seeker' => $jobSeeker,
        ], 200);
    }

    public function destroy()
    {
        $user = Auth::user();

        if ($user->role !== 'job_seeker') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'Job seeker account deleted successfully',
        ], 204);
    }

    public function index()
    {
        $jobSeekers = JobSeeker::with('user')->get();

        return response()->json([
            'message' => 'All job seekers retrieved successfully',
            'job_seekers' => $jobSeekers,
        ], 200);
    }

    public function search($name)
{
    $jobSeekers = JobSeeker::whereHas('user', function ($query) use ($name) {
        $query->where('name', 'like', "%$name%");
    })->with('user')->get();

    return response()->json([
        'message' => 'Job seekers retrieved successfully',
        'job_seekers' => $jobSeekers,
    ], 200);
}

}
