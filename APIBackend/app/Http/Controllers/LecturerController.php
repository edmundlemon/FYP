<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LecturerController extends Controller
{
    //
    // public function index(){
    //     return view('testpages.view-all-lecturers', [
    //         'lecturers' => Lecturer::all()
    //     ]);
    // }
    public function index(){
        return response()->json(
            [
                'lecturer' => Lecturer::all(),
                'code' => 200
            ]
        );
    }

    public function view(Lecturer $lecturer){
        return response()->json(
            [
                'lecturer' => Lecturer::find($lecturer->id),
                'code' => 200
            ]
        );
    }

    public function create(){
        return view('testpages.register-lecturer');
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'id' => 'required|starts_with:MU|unique:lecturers',
            'name' => 'required',
            'email' => 'required|email|unique:lecturers',
            'password' => 'required|min:8|confirmed',
            'faculty' => 'required',
        ]);
        $formFields['password'] = bcrypt($formFields['password']);
        if ($request->hasFile('photo')) {

            $formFields['photo'] = $request->file('photo')->store('photos', 'public');
            $imgName = basename($formFields['photo']);
            $linkToImg = asset('/storage/photos/'.$imgName);
            $formFields['photo'] = $linkToImg;
        }
        // Log::channel('api_post_log')->error('Lecturer Information Form', $formFields);
        Lecturer::create($formFields);
        return response()->json(
            [
                'message' => 'Lecturer created successfully',
                'code' => 201
            ]
        );
        
        // redirect()->route('student.index');
    }
}
