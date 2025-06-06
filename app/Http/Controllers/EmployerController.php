<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEmployerRequest;
use App\Http\Requests\UpdateEmployerRequest;
use Illuminate\Http\Request;
/**
* @method middleware(string $string)
*/

class EmployerController extends Controller
{

   public function __construct()
    {

        $this->middleware('auth:sanctum');

        $this->middleware('abilitiesAny:admin,employer,job_seeker')->only(['search']);
        $this->middleware('abilitiesAny:admin,job_seeker')->only(['index','show']);
        $this->middleware('abilities:admin')->only(['index', 'show']);
        $this->middleware('abilities:employer')->only(['update', 'destroy']);
    }

    // for admins
    public function index()
    {
        $employers = Employer::with('user')->get();
        return response()->json([
            'message' => 'All employers retrieved successfully',
            'employers' => $employers
        ], 200);
    }

    // show specific employer by id
    public function show($id)
    {
        $employer = Employer::with('user')->findOrFail($id);
        return response()->json([
            'message' => 'Employer retrieved successfully',
            'employer' => $employer
        ], 200);
    }

    // update specific employer by id
    public function update(Request $request, $id)
{
    $employer = Employer::find($id);

    if (!$employer) {
        return response()->json(['message' => 'Employer not found'], 404);
    }

    $request->validate([
        'language' => 'sometimes|string|max:255',
        'job_title' => 'sometimes|string|max:255',
    ]);

    $employer->update($request->only('language', 'job_title'));

    return response()->json([
        'message' => 'Employer profile updated successfully',
        'employer' => $employer
    ], 200);
}

    // delete specific employer by id with Auth
    public function destroy()
    {
        $user = Auth::user();

        if ($user->role !== 'employer' && !$user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $user->delete();
        return response()->json([
            'message' => 'Employer account deleted successfully',
        ], 204);
    }

    public function search($name)
{
    $results = Employer::where('name', 'like', "%$name%")
        ->with('jobbs')
        ->get();

    if ($results->isEmpty()) {
        return response()->json([
            'message' => 'No employers found with this name.',
            'employers' => [],
        ], 404);
    }

    return response()->json([
        'message' => 'Employers retrieved successfully.',
        'employers' => $results,
    ], 200);
}

}

