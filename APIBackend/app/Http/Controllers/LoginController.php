<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function login(){
        return view('auth.login');
    }

    public function authenticate(Request $request){
        // dd($request->all());
        $id = $request->id;
        $password = $request->password;

        Log::channel('api_post_log')->error('Request', $request->all());
        $formFields = $request->validate([
            'id' => 'required',
            'password' => 'required'
        ]);

        // Check if ID starts with a number
        if (ctype_digit($formFields['id'])) {
            Log::channel('api_post_log')->error('ID: {id}, Password: {password}', ['id' => $formFields['id'], 'password' => $formFields['password']]);

            if (Auth::guard('student')->attempt(['id' => $formFields['id'], 'password' => $formFields['password']])) {
                // Authentication successful for student

                Log::channel('api_post_log')->error('User Authenticated: ', ['user' => $request->user()]);
                $token = $request->user()->createToken('userToken')->plainTextToken;
                return response()->json([
                    'message' => 'Success!',
                    'token' => $token,
                    'user' => $request->user(),
                    'role' => $request->user()->role()
                ], 200);

                // return redirect()->route('dashboard');
            }
        }

        // Check if ID starts with "MU"
        if (strpos($id, 'MU') === 0) {
            if (Auth::guard('lecturer')->attempt(['id' => $formFields['id'], 'password' => $formFields['password']])) {
                // Authentication successful for lecturer
                Log::channel('api_post_log')->error('User Authenticated: ', $request->all());
                $lecturer = Auth::guard('lecturer')->user();
                // $lecturer = Lecturer::find($formFields['id']);
                $token = $lecturer->createToken('userToken')->plainTextToken;
                return response()->json([
                    'message' => 'Success!',
                    'token' => $token,
                    'user' => $lecturer,
                    'role' => $lecturer->role()
                ], 200);
            }
        }

        // Check if ID starts with "AD"
        if (strpos($id, 'AD') === 0) {
            $auth = Auth::guard('admin')->attempt(['id' => $formFields['id'], 'password' => $formFields['password']]);
            Log::channel('api_post_log')->error('Admin Auth: ', ['auth' => $auth]);
            if (Auth::guard('admin')->attempt(['id' => $formFields['id'], 'password' => $formFields['password']])) {
                // Authentication successful for admin
                Log::channel('api_post_log')->error('User Authenticated: ', ['user' => auth()->guard('admin')->user()]);
                // $admin = Admin::find($formFields['id']);
                $admin = Auth::guard('admin')->user();
                $token = $admin->createToken('userToken')->plainTextToken;

                return response()->json([
                    'message' => 'Success!',
                    'token' => $token,
                    'user' => $admin,
                    'role' => $admin->role()
                ], 200);
            }
        }

        // Authentication failed
        return response()->json([
            'message' => 'Invalid ID or password',
            'code' => 401
        ], 401);
        // return redirect()->route('login')->with('error', 'Invalid ID or password');
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
