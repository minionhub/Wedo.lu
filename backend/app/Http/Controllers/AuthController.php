<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use MikeMcLin\WpPassword\Facades\WpPassword;

class AuthController extends Controller
{
    /**
     * Login user and return a token
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            if (!$user->is_blocked)
                return response()->json(['status' => 'success', 'token' => $token], 200);
            return response()->json(['status' => 'failure', 'error' => 'User is blocked'], 403);
        } else {
            $user = User::where('email', $credentials['email'])->first();

            if ($user) {
                if (WpPassword::check($credentials['password'], $user->password)) {
                    $user->password = Hash::make($credentials['password']);
                    $user->save();
                    if ($token = $this->guard()->attempt($credentials)) {
                        if (!$user->is_blocked)
                            return response()->json(['status' => 'success', 'token' => $token], 200);
                        return response()->json(['status' => 'failure', 'error' => 'User is blocked'], 403);
                    }
                }
            }
        }
        return response()->json(['error' => 'login_error'], 401);
    }

    /**
     * Register User
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:12|max:50|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
        ]);


        if ($validator->fails()) {
            $duplicates = User::where('email', $request->get('email'))->count();

            if ($duplicates > 0)
                $errors = $validator->errors()->add('exist', 'ExistEmail');
            else
                $errors = $validator->errors();

            return response()->json(['status' => 'failure', 'errors' => $errors], 400);
        }

        $user = User::create([
            'display_name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['status' => 'success', 'user' => $user, 'token' => $token], 201);
    }
    /**
     * Logout User
     */
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out successfully.'
        ], 200);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    // it receives user's currentPassword and newPassword in request
    public function changePassword(Request $request)
    {
        // it extracts user's id from submitted token
        // and uses it to get that user from DB
        $user = User::find(Auth::user()->id);

        /* a double check in case of a stolen token, it checks
           if submitted user's current password is actually
           the right one, if yes, only then it continues */
        if (Hash::check($request->get('currentPassword'), Auth::user()->password)) {

            // if current and new passwords are the same, then fail
            if ($request->get('currentPassword') == $request->get('newPassword')) {
                return response()->json(['status' => 'failure'], 400);
            }

            // validate new password
            $validator = Validator::make($request->all(), [
                'newPassword' => 'required|string|min:12|max:50|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
            ]);

            // fail with an explanation, if password is not strong enough
            if ($validator->fails()) {
                return response()->json(['status' => 'failure', 'errors' => $validator->errors()], 400);
            }

            // persist user's new password to DB
            $user->password = Hash::make($request->get('newPassword'));
            $user->save();

            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'failure'], 400);
    }

    /**
     * Refresh JWT token
     */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'success'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    /**
     * Return auth guard
     */
    private function guard()
    {
        return Auth::guard();
    }
}
