<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\JobSeeker;
use App\Models\Employer;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Mail\VerifyEmail;



class UserController extends Controller
{

public function __construct()
{
    $this->middleware('auth:sanctum')->except(['register', 'login', 'logout']);

    $this->middleware('abilities:admin')->only(['index', 'store', 'update', 'destroy', 'show', 'getEmployer']);
}

    public function register(Request $request)
{
    $request->validate([
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:employer,job_seeker,admin',

        // more specific validation rules based on role
        'country' => 'required_if:role,job_seeker|string|max:255',
        'gender' => 'required_if:role,job_seeker|in:male,female',
        'day' => 'required_if:role,job_seeker|integer|min:1|max:31',
        'month' => 'required_if:role,job_seeker|integer|min:1|max:12',
        'year' => 'required_if:role,job_seeker|integer|min:1900|max:2100',

        'language' => 'required_if:role,employer|string|max:255',
        'job_title' => 'required_if:role,employer|string|max:255',

        'name' => 'required_if:role,admin|string|max:255',
    ]);

    DB::beginTransaction();

    try {
        // create user
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // create role-specific profile
    if ($request->role === 'job_seeker') {
        \App\Models\JobSeeker::create([
            'user_id' => $user->id,
            'country' => $request->country,
            'gender' => $request->gender,
            'day' => $request->day,
            'month' => $request->month,
            'year' => $request->year,
        ]);
    } else if ($request->role === 'employer') {
        \App\Models\Employer::create([
            'user_id' => $user->id,
            'language' => $request->language,
            'job_title' => $request->job_title,
        ]);
    } else if ($request->role === 'admin') {
         \App\Models\Admin::create([
        'user_id' => $user->id,
        'name' => $request->name,
    ]);
    }
        DB::commit();

    event(new Registered($user));

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
         Carbon::now()->addMinutes(60),
         ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    Mail::to($user->email)->send(new VerifyEmail($user, $verificationUrl));

    return response()->json([
      'message1' => 'User registration successful',
      'message2' => 'Please check your email to verify your account.',
      'user' => $user
    ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => 'Registration failed',
            'message' => $e->getMessage()
        ], 500);
    }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'role' => 'required|in:employer,job_seeker,admin',
        ]);
        if (!Auth::attempt($request->only('email','password'))) {
    return response()->json([
        'message' => 'Invalid email or password',
    ], 401);
}

    $user = User::where('email', $request->email)->firstOrFail();

    if (! $user->hasVerifiedEmail()) {
     return response()->json([
        'message' => 'Please verify your email before logging in.',
     ], 403);
    }

    if ($user->role !== $request->role) {
     return response()->json([
        'message' => 'You are not authorized to login as ' . $request->role,
     ], 403);
    }

    $abilities = match($user->role) {
        'admin' => ['admin'],
        'employer' => ['employer'],
        'job_seeker' => ['job_seeker'],
     default => [],
    };

    $token = $user->createToken('auth_token', $abilities)->plainTextToken;

    Mail::to($user->email)->send(new WelcomeMail($user));

    return response()->json([
        'message' => 'User login successful',
        'user' => $user,
        'token' => $token
    ], 200);
    }

        public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User logged out successfully',
        ], 200);
    }

     /** Display a listing of the users.
     * @return \Illuminate\Http\JsonResponse
      */


        public function index()
    {
        User::all();
        return response()->json([
            'message' => 'All Users retrieved successfully',
            'users' => User::all()
        ], 200);
    }


     /** Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
      */


    public function store(StoreUserRequest $request)
    {
        $user=User::create($request->validated());
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }


     /** Update any field in specified user.
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
      */

    public function update($id, UpdateUserRequest $request)
    {
        $user=User::findOrFail($id);
        $user->update($request->validated());

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 201);
    }


     /** Get specified users by id.
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
      * */

    public function show($id)
    {
       $user=User::findOrFail($id);

       return response()->json([
            'message' => 'Specified User retrieved successfully',
            'user' => $user
        ], 200);
    }

     /** Delete the specified user.
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
      * */


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
        ], 204);
    }

    public function getEmployer($id)
    {
        $employer=User::find($id)->employer;
        return response()->json([
            'message' => 'Employer retrieved successfully',
            'employer' => $employer,
        ], 200);
    }
}
