<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProfileActivatedMail;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function search($name): JsonResponse
    {
        $profiles = Profile::where('FirstName', 'like', "%$name%")
            ->orWhere('LastName', 'like', "%$name%")
            ->get();

        return response()->json($profiles);
    }

    public function profilesByCountry($country): JsonResponse
    {
        $profiles = Profile::where('Country', $country)->get();

        return response()->json($profiles);
    }

    public function profilesBySkill($skill): JsonResponse
    {
        $profiles = Profile::where('Skill', 'like', "%$skill%")->get();

        return response()->json($profiles);
    }

    public function activate($id): JsonResponse
    {
        /** @var Profile $profile */
        $profile = Profile::findOrFail($id);

        $profile->is_active = true;
        $profile->save();

        Mail::to($profile->Email)->queue(new ProfileActivatedMail($profile));

        return response()->json([
            'message' => 'Profile activated successfully. Email sent!',
            'profile' => $profile
        ]);
    }

    public function index(): JsonResponse
    {
        $profiles = Profile::where('user_id', auth()->id())->get();

        return response()->json($profiles);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'Skill' => 'required|string|max:255',
            'Cv' => 'nullable|url',
            'Summary' => 'nullable|string',
            'Email' => 'required|email|unique:profiles,Email',
            'Experience' => 'nullable|string',
            'Education' => 'nullable|string',
            'Country' => 'required|string|max:255',
            'City' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $profile = new Profile($validatedData);
        $profile->user_id = auth()->id();
        $profile->save();

        return response()->json($profile, 201);
    }

    public function show($id): JsonResponse
    {
        /** @var Profile $profile */
        $profile = Profile::findOrFail($id);

        $user = auth()->user();
        if (!$user || ($user->role !== 'admin' && $profile->user_id !== $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($profile);
    }

    public function update(Request $request, $id): JsonResponse
    {
        /** @var Profile $profile */
        $profile = Profile::findOrFail($id);

        $user = auth()->user();
        if (!$user || ($user->role !== 'admin' && $profile->user_id !== $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'Skill' => 'required|string|max:255',
            'Cv' => 'nullable|url',
            'Summary' => 'nullable|string',
            'Email' => 'required|email|unique:profiles,Email,' . $id,
            'Experience' => 'nullable|string',
            'Education' => 'nullable|string',
            'Country' => 'required|string|max:255',
            'City' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $profile->update($validatedData);

        return response()->json($profile, 200);
    }

    public function destroy($id): JsonResponse
    {
        /** @var Profile $profile */
        $profile = Profile::findOrFail($id);

        $user = auth()->user();
        if (!$user || ($user->role !== 'admin' && $profile->user_id !== $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $profile->delete();

        return response()->json(['message' => 'Profile deleted successfully.'], 200);
    }
}
