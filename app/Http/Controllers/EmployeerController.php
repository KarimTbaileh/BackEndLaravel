<?php

namespace App\Http\Controllers;

use App\Models\Employeer;
use Illuminate\Http\Request;

class EmployeerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Employeer::with('jobbs')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'language' => 'required|string',
            'job_title' => 'required|string',
        ]);

        $employeer = Employeer::create($validated);
        return response()->json($employeer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Employeer::with('jobbs')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employeer = Employeer::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'language' => 'sometimes|string',
            'job_title' => 'sometimes|string',
        ]);
        $employeer->update($validated);
        return response()->json($employeer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Employeer::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function search($name)
    {
        return Employeer::where('name', 'like', "%$name%")->with('jobbs')->get();
    }
}
