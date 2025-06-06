<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

/**
 * @method static \Illuminate\Routing\Router middleware(string $middleware)
 */
class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        $this->middleware('abilities:admin')->only(['show', 'update', 'destroy']);

        $this->middleware('abilities:employeer')->only(['applicantsByJob', 'accept', 'reject']);

        $this->middleware('abilities:job_seeker')->only(['store','index']);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'job_seeker') {
            return Application::where('job_seeker_id', $user->id)
                ->with(['jobb', 'jobSeeker'])
                ->paginate(10);
        }

        return Application::with(['jobb', 'jobSeeker'])->paginate(10);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'position applied' => 'required|string',
            'Cv' => 'required|string',
            'Cover Letter' => 'required|string',
            'Status' => 'required|string',
            'jobb_id' => 'required|exists:jobbs,id',
        ]);

        $application = Application::create([
            'position applied' => $validated['position applied'],
            'Cv' => $validated['Cv'],
            'Cover Letter' => $validated['Cover Letter'],
            'Status' => $validated['Status'],
            'jobb_id' => $validated['jobb_id'],
            'job_seeker_id' => $user->id,
        ]);

        return response()->json($application, 201);
    }

    public function show($id)
    {
        return Application::with(['jobb', 'jobSeeker'])->findOrFail($id);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $application = Application::findOrFail($id);
        $validated = $request->validate([
            'position applied' => 'sometimes|string',
            'Cv' => 'sometimes|string',
            'Cover Letter' => 'sometimes|string',
            'Status' => 'sometimes|string',
            'jobb_id' => 'sometimes|exists:jobbs,id',
        ]);

        $application->update($validated);
        return response()->json($application);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        Application::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function accept($id): \Illuminate\Http\JsonResponse
    {
        $application = Application::findOrFail($id);
        $application->update(['Status' => 'Accepted']);
        return response()->json($application);
    }

    public function reject($id): \Illuminate\Http\JsonResponse
    {
        $application = Application::findOrFail($id);
        $application->update(['Status' => 'Rejected']);
        return response()->json($application);
    }

    public function applicantsByJob($jobbId): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();


        $applications = Application::where('jobb_id', $jobbId)
            ->whereHas('jobb', function ($query) use ($user) {
                $query->where('employeer_id', $user->id);
            })
            ->with(['jobSeeker', 'jobb'])
            ->paginate(10);

        return response()->json($applications);
    }
}
