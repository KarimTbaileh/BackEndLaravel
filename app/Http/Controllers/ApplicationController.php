<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Application::with('jobb')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'position_applied' => 'required|string',
            'cv' => 'required|string',
            'cover_letter' => 'required|string',
            'status' => 'required|string',
            'jobb_id' => 'required|exists:jobbs,id',
            'job_seeker_id' => 'required|exists:job_seekers,id',
        ]);

        $application = Application::create($validated);
        return response()->json($application, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Application::with('jobb')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $validated = $request->validate([

            'position_applied' => 'sometimes|string',
            'cv' => 'sometimes|string',
            'cover_letter' => 'sometimes|string',
            'status' => 'sometimes|string',
            'jobb_id' => 'sometimes|exists:jobbs,id',
            'job_seeker_id' => 'required|exists:job_seekers,id',
        ]);
        $application->update($validated);
        return response()->json($application);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Application::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function accept($id)
    {
        $application = Application::findOrFail($id);
        $application->update(['status' => 'Accepted']);
        return response()->json($application);
    }

    public function reject($id)
    {
        $application = Application::findOrFail($id);
        $application->update(['status' => 'Rejected']);
        return response()->json($application);
    }

    public function applicantsByJob($jobbId)
    {
        $applications = Application::where('jobb_id', $jobbId)
            ->with(['jobSeeker', 'jobb'])
            ->paginate(10);
        return response()->json($applications);
    }
}
