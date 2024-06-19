<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Lecturer;
use App\Models\Consultation_slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Laravel\Sanctum\Sanctum;

class ReviewController extends Controller
{
    //
    public function index(Request $request, Lecturer $lecturer)
    {
        $reviews = Review::where('lecturer_id', $lecturer->id)->get();
        $rating = $reviews->avg('rating');
        return response()->json([
            'reviews' => $reviews,
            'rating' => $rating,
            'code' => 200
        ]);
    }

    public function store(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'string'
        ]);

        Consultation_slot::where('id', $request->slot_id)->update(['status' => 'Completed & Reviewed']);


        $review = new Review();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->lecturer_id = $lecturer->id;
        $review->student_id = auth()->guard('sanctum')->user()->id;
        $review->save();

        return response()->json([
            'message' => 'Review created successfully',
            'code' => 201
        ]);
    }

    public function view(Student $student)
    {
        $reviews = Review::where('student_id', $student->id)->get();
        return response()->json([
            'reviews' => $reviews,
            'code' => 200
        ]);
    }

}
