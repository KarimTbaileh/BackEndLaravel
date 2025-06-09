<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        $this->middleware('abilitiesAny:admin,employer,job_seeker')->only(['search']);
        $this->middleware('abilitiesAny:admin,job_seeker')->only(['index', 'show']);
        $this->middleware('abilities:employer')->only(['update', 'destroy']);
    }

    public function index()
    {
        $employers = Employer::with('user')->get();
        return response()->json([
            'message' => 'All employers retrieved successfully',
            'employers' => $employers
        ], 200);
    }

    public function show($id)
    {
        $employer = Employer::with('user')->findOrFail($id);
        return response()->json([
            'message' => 'Employer retrieved successfully',
            'employer' => $employer
        ], 200);
    }

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

    public function destroy()
    {
        $user = Auth::user();

        if ($user->role !== 'employer' && $user->role !== 'admin') { // تصحيح الشرط
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $employer = Employer::where('user_id', $user->id)->first();

        if (!$employer) {
            return response()->json(['message' => 'Employer not found'], 404);
        }

        $employer->delete(); // حذف الـ Employer (سيحذف الـ User تلقائيًا بسبب cascade)
        return response()->json([
            'message' => 'Employer account deleted successfully',
        ], 204);
    }

    public function search($jobTitle) // تعديل $name إلى $jobTitle
    {
        $results = Employer::where('job_title', 'like', "%$jobTitle%") // تعديل من name إلى job_title
        ->with('jobbs')
            ->get();

        if ($results->isEmpty()) {
            return response()->json([
                'message' => 'No employers found with this job title.',
                'employers' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'Employers retrieved successfully.',
            'employers' => $results,
        ], 200);
    }
}
