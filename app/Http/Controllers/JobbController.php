<?php

namespace App\Http\Controllers;

use App\Models\Jobb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobbController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'latestJobs']);

        $this->middleware('abilities:admin')->only(['approveJob']);
        $this->middleware('abilities:employer')->only(['postJob','closeApplication','openApplication']);

        $this->middleware('abilitiesAny:admin,employer')->only(['jobsByEmployer', 'update', 'destroy']);
    }

    // فلترة وظائف شغل عبد الكريم شافعي 
    public function index(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = Jobb::query()->with('employer');

        if ($request->filled('location')) {
            $query->where('Location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        if ($request->filled('status')) {
            $query->where('Status', $request->status); // open / closed
        }

        if ($request->filled('salary_min')) {
            $query->where('Salary', '>=', $request->salary_min);
        }

        if ($request->filled('salary_max')) {
            $query->where('Salary', '<=', $request->salary_max);
        }

        return $query->paginate(10);
    }

    // عرض وظائف شغل عبد الكريم شافعي
    public function latestJobs()
    {
        return Jobb::with('employer')->latest()->take(10)->get();
    }

    public function postJob(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'Requirements' => 'required|string',
            'Location' => 'required|string',
            'job_type' => 'required|string',
            'Currency' => 'required|string',
            'Frequency' => 'required|string',
            'Salary' => 'required|numeric',
            'Type' => 'required|string',
            'Title' => 'required|string',
            'Description' => 'required|string',
            'Status' => 'required|in:open,closed',
            'publication_status' => 'required|in:pending,approved,rejected',
            'employer_id' => 'required|exists:employers,id',
            'logo' => 'required|url',
            'document' => 'nullable|url',
        ]);

        if ($user->role !== 'admin' && $validated['employer_id'] != $user->employer->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $job = Jobb::create($validated);
            return response()->json($job, 201);
        } catch (\Exception $e) {
            Log::error('Job creation failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to create job',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $job = Jobb::with('employer')->findOrFail($id);
        return $job;
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $job = Jobb::findOrFail($id);
        $user = auth()->user();

        if ($user->role !== 'admin' && $job->employer_id !== $user->employer->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'Requirements' => 'sometimes|string',
            'Location' => 'sometimes|string',
            'job_type' => 'sometimes|string',
            'Currency' => 'sometimes|string',
            'Frequency' => 'sometimes|string',
            'Salary' => 'sometimes|numeric',
            'Type' => 'sometimes|string',
            'Title' => 'sometimes|string',
            'Description' => 'sometimes|string',
            'Status' => 'sometimes|in:open,closed',
            'publication_status' => 'sometimes|in:pending,approved,rejected',
            'employer_id' => 'sometimes|exists:employers,id',
            'logo' => 'sometimes|url',
            'document' => 'nullable|url',
        ]);

        $job->update($validated);
        return response()->json($job);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $job = Jobb::findOrFail($id);
        $user = auth()->user();

        if ($user->role !== 'admin' && $job->employer_id !== $user->employer->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $job->delete();
        return response()->json(null, 204);
    }

    public function search($name)
    {
        return Jobb::where('Title', 'like', "%$name%")
            ->with('employer')
            ->get();
    }

    public function jobsByEmployer($employerId): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $employerId != $user->employer->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $jobs = Jobb::where('employer_id', $employerId)->with('employer')->paginate(10);
        return response()->json($jobs);
    }

    public function approveJob(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $job = Jobb::findOrFail($id);
        $validated = $request->validate([
            'publication_status' => 'required|in:approved,rejected',
        ]);

        $job->update(['publication_status' => $validated['publication_status']]);
        return response()->json(['message' => 'Job publication status updated', 'job' => $job]);
    }

    public function closeApplication($id): \Illuminate\Http\JsonResponse
    {
        $job = Jobb::findOrFail($id);
        $user = auth()->user();

        if ($job->employer_id !== $user->employer->id && $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $job->update(['Status' => 'closed']);
        return response()->json(['message' => 'Application closed', 'job' => $job]);
    }

    public function openApplication($id): \Illuminate\Http\JsonResponse
    {
        $job = Jobb::findOrFail($id);
        $user = auth()->user();

        if ($job->employer_id !== $user->employer->id && $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $job->update(['Status' => 'open']);
        return response()->json(['message' => 'Application opened', 'job' => $job]);
    }
}
