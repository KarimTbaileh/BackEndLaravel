<?php

namespace App\Http\Controllers;

use App\Models\Jobb;
use Illuminate\Http\Request;

/**
 * @method middleware(string $string)
 */
class JobbController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        $this->middleware('abilities:admin')->only(['approveJob','closeApplication','update','destroy','store','postJob','jobsByEmployer']);

        $this->middleware('abilities:employeer')->only(['closeApplication','update','destroy','store','postJob','jobsByEmployer']);;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Jobb::with('employeer')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'Requirements' => 'required|string',
            'Location' => 'required|string',
            'Job Type' => 'required|string',
            'Currency' => 'required|string',
            'Frequency' => 'required|string',
            'Salary' => 'required|numeric',
            'Type' => 'required|string',
            'Title' => 'required|string',
            'Description' => 'required|string',
            'Status' => 'required|in:open,closed',
            'publication_status' => 'required|in:pending,approved,rejected',
            'employeer_id' => 'required|exists:employeers,id',
        ]);

        $job = Jobb::create($validated);
        return response()->json($job, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Jobb::with('employeer')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $job = Jobb::findOrFail($id);
        $validated = $request->validate([
            'Requirements' => 'sometimes|string',
            'Location' => 'sometimes|string',
            'Job Type' => 'sometimes|string',
            'Currency' => 'sometimes|string',
            'Frequency' => 'sometimes|string',
            'Salary' => 'sometimes|numeric',
            'Type' => 'sometimes|string',
            'Title' => 'sometimes|string',
            'Description' => 'sometimes|string',
            'Status' => 'sometimes|in:open,closed',
            'publication_status' => 'sometimes|in:pending,approved,rejected',
            'employeer_id' => 'sometimes|exists:employeers,id',
        ]);
        $job->update($validated);
        return response()->json($job);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        Jobb::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function search($name)
    {
        return Jobb::whereHas('employeer', function ($query) use ($name) {
            $query->where('name', 'like', "%$name%");
        })->with('employeer')->get();
    }

    public function postJob(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'Requirements' => 'required|string',
            'Location' => 'required|string',
            'Job Type' => 'required|string',
            'Currency' => 'required|string',
            'Frequency' => 'required|string',
            'Salary' => 'required|numeric',
            'Type' => 'required|string',
            'Title' => 'required|string',
            'Description' => 'required|string',
            'Status' => 'required|in:open,closed',
            'publication_status' => 'required|in:pending,approved,rejected',
            'employeer_id' => 'required|exists:employeers,id',
        ]);

        $job = Jobb::create($validated);
        return response()->json($job, 201);
    }

    public function jobsByEmployer($employeerId): \Illuminate\Http\JsonResponse
    {
        $jobs = Jobb::where('employeer_id', $employeerId)->with('employeer')->paginate(10);
        return response()->json($jobs);
    }

    /**
     * Approve or reject a job publication by Admin.
     */
    public function approveJob(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $job = Jobb::findOrFail($id);
        $validated = $request->validate([
            'publication_status' => 'required|in:approved,rejected',
        ]);

        $job->update(['publication_status' => $validated['publication_status']]);
        return response()->json(['message' => 'Job publication status updated', 'job' => $job]);
    }

    /**
     * Close application for a job by Employeer.
     */
    public function closeApplication($id): \Illuminate\Http\JsonResponse
    {
        $job = Jobb::findOrFail($id);
        $user = auth()->user();

        if ($job->employeer_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $job->update(['Status' => 'closed']);
        return response()->json(['message' => 'Application closed', 'job' => $job]);
    }
}
