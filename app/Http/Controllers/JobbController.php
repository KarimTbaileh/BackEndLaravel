<?php

namespace App\Http\Controllers;

use App\Models\Jobb;
use Illuminate\Http\Request;

class JobbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Jobb::with('employeer')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            'Status' => 'required|string',
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
    public function update(Request $request, $id)
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
            'Status' => 'sometimes|string',
            'employeer_id' => 'sometimes|exists:employeers,id',
        ]);
        $job->update($validated);
        return response()->json($job);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
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

    public function postJob(Request $request)
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
            'Status' => 'required|string',
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

}
