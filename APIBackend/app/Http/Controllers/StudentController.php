<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    //
    public function index()
    {
        return response()->json(
            [
                'students' => Student::all(),
                'code' => 200
            ]
        );
    }

    public function view(Student $student){
        return response()->json(
            [
                'student' => Student::find($student->id),
                'code' => 200
            ]
        );
    }
    public function StudentFaculty(){
        return response()->json(
            [
                'student' => Student::distinct()->get('faculty'),
                'code' => 200
            ]
        );
    }
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'id'=> 'required|unique:students|numeric',
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|confirmed|min:8',
            'faculty' => 'required',
            'program' => 'required',
            // 'photo' => 'required',
            // 'phone' => 'required|numeric',
            // 'address' => 'required',
        ]);

        if($request->hasFile('photo')){
            // The line below would store the file in the public disk, in the logos folder
            // It would also return the path to the file
            $formFields['photo'] = $request->file('photo')->store('photos', 'public');
            $imgName = basename($formFields['photo']);
            $linkToImg = asset('photos/'.$imgName);
            $formFields['photo'] = $linkToImg;
        }
        // dd($formFields);
        // Hsshing the password for storage
        $formFields['password'] = bcrypt($formFields['password']);

        $student = Student::create($formFields);
        return view('/welcome');
        // redirect()->route('login');
    }

    public function edit(Student $student)
    {
        return view('testpages.student-edit-profile', [
            'student' => $student
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $formFields = $request->validate([
            'id'=> 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            // 'password' => 'required|confirmed|min:8',
            'faculty' => 'required',
            'program' => 'required',
            // 'photo' => 'required',
            // 'phone' => 'required|numeric',
            // 'address' => 'required',
        ]);
        if(auth()->user()->id != $request->id){
            return abort(403, 'Unauthorized Action!');
        }
        if($request->hasFile('photo')){
            // The line below would store the file in the public disk, in the logos folder
            // It would also return the path to the file
            $formFields['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $student->update($formFields);
        return view('/dashboard');
    }
}
