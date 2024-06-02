<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $search = $request->get('search');
        Log::channel('api_post_log')->error($search);
        Log::channel('api_post_log')->error('request', $request->all());
        $students = Student::where('name', 'like', '%'.$search.'%')->get();
        $lecturers = Lecturer::where('name', 'like', '%'.$search.'%')->get();
        return response()->json([
            'students' => $students,
            'lecturers' => $lecturers
        ]);}
}
