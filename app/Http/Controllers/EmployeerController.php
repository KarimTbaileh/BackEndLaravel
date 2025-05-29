<?php

namespace App\Http\Controllers;

use App\Models\Employeer;
use Illuminate\Http\Request;

/**
 * @method middleware(string $string)
 */
class EmployeerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        $this->middleware('abilities:admin')->only(['store', 'update', 'destroy','index', 'show', 'search']);

        $this->middleware('abilities:employeer')->only(['index', 'show', 'search']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'employeer') {
            return Employeer::where('id', $user->id)->with('jobbs')->paginate(10);
        }

        return Employeer::with('jobbs')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
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
        $user = auth()->user();

        if ($user->role === 'employeer') {
            $employeer = Employeer::where('id', $user->id)->with('jobbs')->findOrFail($id);
            return response()->json($employeer);
        }

        return Employeer::with('jobbs')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
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
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        Employeer::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function search($name)
    {
        $user = auth()->user();

        if ($user->role === 'employeer') {
            return Employeer::where('name', 'like', "%$name%")
                ->where('id', $user->id)
                ->with('jobbs')
                ->get();
        }


        return Employeer::where('name', 'like', "%$name%")->with('jobbs')->get();
    }
}
