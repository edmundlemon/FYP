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

    public function countLecturer(){
        if(auth('sanctum')->user()->hasRole('admin')){
            $count = Lecturer::count();
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

    public function view(Lecturer $lecturer){
        return response()->json(
            [
                'lecturer' => Lecturer::find($lecturer->id),
                'code' => 200
            ]
        );
    }

    public function LecturerFaculty(){
        return response()->json(
            [
                'lecturer' => Lecturer::distinct()->get('faculty'),
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

            // $formFields['photo'] = $request->file('photo')->store('photos', 'public');
            $formFields['photo'] = $request->file('photo');
            $formFields['photo'] = $formFields['photo']->move(public_path('storage/photos'), $formFields['photo']->getClientOriginalName());
            //  $request->file('photo')->getClientOriginalName();
            $imgName = basename($formFields['photo']);
            $linkToImg = asset('/storage/photos/'.$imgName);
            $formFields['photo'] = $linkToImg;
        }
        else{
            $formFields['photo'] = 'https://ui-avatars.com/api/?name='.urlencode($formFields['name']).'&color=7F9CF5&background=EBF4FF';
        }
        // Log::channel('api_post_log')->error('Lecturer Information Form', $formFields);
        Lecturer::create($formFields);
        return response()->json(
            [
                'message' => 'Lecturer created successfully',
                'code' => 201
            ]
        );
    }

    public function update(Request $request, Lecturer $lecturer){
        if ($request->id != $lecturer->id) {
            return response()->json(
                [
                    'message' => 'ID cannot be changed',
                    'code' => 400
                ]
            );
        }
        $formFields = $request->validate([
            // 'id' => 'required|starts_with:MU|unique:lecturers',
            'name' => 'required',
            'email' => 'required|email',
            'faculty' => 'required',
            'office' => 'required',
        ]);
        if (!auth('sanctum')->user()->hasRole('admin')) {
            return response()->json(
                [
                    'message' => 'Unauthorized',
                    'code' => 401
                ]
            );
        }
        if($request->hasFile('photo')){
            // The line below would store the file in the public disk, in the logos folder
            // It would also return the path to the file
            $formFields['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $lecturer->update($formFields);
        return response()->json(
            [
                'message' => 'Lecturer updated successfully',
                'code' => 200
            ]
        );
    }

    public function destroy(Lecturer $lecturer){
        if(auth('sanctum')->user()->hasRole('admin')){
            $lecturer->delete();
            return response()->json(
                [
                    'message' => 'Lecturer deleted successfully',
                    'code' => 200
                ]
            );
        }
    }
}
