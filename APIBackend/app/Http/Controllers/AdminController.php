<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'id' => 'required|string|unique:admins',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:6',
        ]);
        $user = Auth::guard('sanctum')->user();
        if ($user->hasRole('admin')) {
            $formFields['password'] = bcrypt($request->password);
            $user = Admin::create($formFields);
            return response()->json(['message' => 'Admin created successfully', 'user' => $user], 201);
        }
    }

    public function destroy(Admin $admin)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user->hasRole('admin')) {
            $admin->delete();
            return response()->json(['message' => 'Admin deleted successfully'], 200);
        }
    }

    public function update(Request $request, Admin $admin)
    {
        $formFields = $request->validate([
            'id' => 'required|string|unique:admins',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:6',
        ]);
        $user = Auth::guard('sanctum')->user();
        if ($user->hasRole('admin')) {
            $formFields['password'] = bcrypt($request->password);
            $admin->update($formFields);
            return response()->json(['message' => 'Admin updated successfully', 'user' => $admin], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

}
