<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Hamcrest\Type\IsString;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

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

    public function countStudent()
    {

        if (auth('sanctum')->user()->hasRole('admin')) {
            $count = Student::count();

            return response()->json(
                [
                    'count' => $count,
                    'code' => 200
                ]
            );
        }
        return response()->json(
            [
                'message' => 'Unauthorized',
                'code' => 401
            ]
        );
    }


    public function view(Student $student)
    {
        return response()->json(
            [
                'student' => Student::find($student->id),
                'code' => 200
            ]
        );
    }
    public function StudentFaculty()
    {
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
            'id' => 'required|unique:students|numeric',
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|confirmed|min:8',
            'faculty' => 'required',
            'program' => 'required',
            // 'photo' => 'required',
            // 'phone' => 'required|numeric',
            // 'address' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            // The line below would store the file in the public disk, in the logos folder
            // It would also return the path to the file
            $formFields['photo'] = $request->file('photo');
            $formFields['photo'] = $formFields['photo']->move(public_path('storage/photos'), $formFields['photo']->getClientOriginalName());
            $imgName = basename($formFields['photo']);
            $linkToImg = asset('/storage/photos/' . $imgName);
            $formFields['photo'] = $linkToImg;
        } else {
            $formFields['photo'] = 'https://ui-avatars.com/api/?name=' . urlencode($formFields['name']) . '&color=7F9CF5&background=EBF4FF';
        }
        // dd($formFields);
        // Hsshing the password for storage
        $formFields['password'] = bcrypt($formFields['password']);

        $student = Student::create($formFields);
        return response()->json(
            [
                'message' => 'Student created successfully',
                'code' => 201
            ]
        );
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
        if ($request->id != $student->id) {
            return response()->json(
                [
                    'message' => 'ID cannot be changed',
                    'code' => 400
                ]
            );
        }
        $formFields = $request->validate([
            // 'id'=> 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'faculty' => 'required',
            'program' => 'required',
        ]);
        if (!auth('sanctum')->user()->hasRole('admin')) {
            return response()->json(
                [
                    'message' => 'Unauthorized',
                    'code' => 401
                ]
            );
        }
        if ($request->hasFile('photo')) {
            // The line below would store the file in the public disk, in the logos folder
            // It would also return the path to the file
            $formFields['photo'] = $request->file('photo')->store('photos', 'public');

            $formFields['photo'] = $request->file('photo');
            $formFields['photo'] = $formFields['photo']->move(public_path('storage/photos'), $formFields['photo']->getClientOriginalName());
            $imgName = basename($formFields['photo']);
            $linkToImg = asset('/storage/photos/' . $imgName);
            $formFields['photo'] = $linkToImg;
        }

        $student->update($formFields);
        return response()->json(
            [
                'message' => 'Student updated successfully',
                'code' => 200
            ]
        );
    }

    public function editDetails(Request $request, Student $student)
    {
        $formFields = $request->validate([
            'email' => ['required', Rule::unique('students')->ignore(auth('sanctum')->user()->id)],
        ]);

        if (is_string($request->photo)) {
            $formFields['photo'] = $request->photo;
        } else if ($request->hasFile('photo')) {
            // The line below would store the file in the public disk, in the logos folder
            // It would also return the path to the file
            $formFields['photo'] = $request->file('photo');
            $formFields['photo'] = $formFields['photo']->move(public_path('storage/photos'), $formFields['photo']->getClientOriginalName());
            $imgName = basename($formFields['photo']);
            $linkToImg = asset('/storage/photos/' . $imgName);
            $formFields['photo'] = $linkToImg;
        }

        $student->update($formFields);
        $photo = $student->photo;
        return response()->json(
            [
                'message' => 'Photo updated successfully',
                'photo' => $photo,
                'code' => 200
            ]
        );
    }

    public function destroy(Student $student)
    {

        if (auth('sanctum')->user()->hasRole('admin')) {
            $student->delete();
            return response()->json(
                [
                    'message' => 'Student deleted successfully',
                    'code' => 200
                ]
            );
        }
        return response()->json(
            [
                'message' => 'Unauthorized',
                'code' => 401
            ]
        );
    }
}
