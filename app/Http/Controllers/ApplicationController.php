<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

/**
 * @method static \Illuminate\Routing\ControllerMiddlewareOptions middleware(string $middleware)
 */
class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        $this->middleware('abilities:employer')->only(['applicantsByJob', 'accept', 'reject']);

        $this->middleware('abilities:job_seeker')->only(['store', 'index']);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'job_seeker') {
            // التحقق من وجود JobSeeker
            if (!$user->jobSeeker) {
                return response()->json(['error' => 'Job seeker profile not found'], 404);
            }

            return Application::where('job_seeker_id', $user->jobSeeker->id)
                ->with(['jobb', 'jobSeeker'])
                ->paginate(10);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        // التحقق من وجود سجل JobSeeker للمستخدم
        $jobSeeker = $user->jobSeeker;
        if (!$jobSeeker) {
            return response()->json(['error' => 'Job seeker profile not found'], 404);
        }

        $validated = $request->validate([
            'position applied' => 'required|string',
            'Status' => 'required|in:pending,Accepted,Rejected',
            'jobb_id' => 'required|exists:jobbs,id',
        ]);

        $application = Application::create([
            'position applied' => $validated['position applied'],
            'Status' => $validated['Status'],
            'jobb_id' => $validated['jobb_id'],
            'job_seeker_id' => $jobSeeker->id, // استخدام معرف JobSeeker
        ]);

        return response()->json($application, 201);
    }





    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        Application::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function accept($id): \Illuminate\Http\JsonResponse
    {
        $application = Application::findOrFail($id);
        $user = auth()->user();

        // التحقق من وجود علاقة employer للمستخدم
        if (!$user->employer) {
            return response()->json(['error' => 'Unauthorized - Employer profile not found'], 403);
        }

        // التحقق من وجود الوظيفة المرتبطة
        if (!$application->jobb) {
            return response()->json(['error' => 'Job not found for this application'], 404);
        }

        // التحقق من صلاحية الـ Employer
        if ($application->jobb->employer_id !== $user->employer->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // تحديث حالة الطلب
        $application->update(['Status' => 'Accepted']);

        return response()->json($application);
    }

    public function reject($id): \Illuminate\Http\JsonResponse
    {
        $application = Application::findOrFail($id);
        $user = auth()->user();

        // التحقق من وجود علاقة employer للمستخدم
        if (!$user->employer) {
            return response()->json(['error' => 'Unauthorized - Employer profile not found'], 403);
        }

        if ($application->jobb->employer_id !== $user->employer->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $application->update(['Status' => 'Rejected']);
        return response()->json($application);
    }

    public function applicantsByJob($jobbId): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        // التحقق من وجود علاقة employer للمستخدم
        if (!$user->employer) {
            return response()->json(['error' => 'Unauthorized - Employer profile not found'], 403);
        }

        $applications = Application::where('jobb_id', $jobbId)
            ->whereHas('jobb', function ($query) use ($user) {
                $query->where('employer_id', $user->employer->id);
            })
            ->with(['jobSeeker', 'jobb'])
            ->paginate(10);

        if ($applications->isEmpty()) {
            return response()->json(['message' => 'No applications found for this job'], 404);
        }
        return response()->json($applications);
    }
}
