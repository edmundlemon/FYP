<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Free_slot;
use Illuminate\Http\Request;

class Free_SlotController extends Controller
{
    //
    public function upcomingTime(Lecturer $lecturer)
    {
        return response()->json(
            [
                'upcomings' => $lecturer->upcoming()->get(),
                'code' => 200
            ]
        );
    }

    public function index()
    {
        return response()->json(
            [
                'freeslots' => Free_slot::all(),
                'code' => 200
            ]
        );
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'date' => 'required|date_format:Y-m-d|after:tomorrow',
            'start_time' => 'required|time_format:H:i',
            'end_time' => 'required|time_format:H:i|after:start_time',
        ]);
        $formFields['lecturer_id'] = auth()->user()->id;

        Free_slot::create($formFields);
        return response()->json(
            [
                'message' => 'Free slot created successfully',
                'code' => 201
            ]
        );
        return redirect()->route('free_slot.index');
    }

    public function update(Request $request, Free_slot $free_slot)
    {
        if(auth()->id() !== $free_slot->lecturer_id){
            abort(403, 'Unauthorized Action!');
        }
        $formFields = $request->validate([
            'date' => 'required|date_format:Y-m-d|after:tomorrow',
            'start_time' => 'required|time_format:H:i',
            'end_time' => 'required|time_format:H:i|after:start_time',
        ]);

        $free_slot->update($formFields);
        return response()->json(
            [
                'message' => 'Free slot updated successfully',
                'code' => 200
            ]
        );
        return redirect()->route('free_slot.index');
    }

    public function destroy(Free_slot $free_slot)
    {
        if(auth()->id() !== $free_slot->lecturer_id){
            abort(403, 'Unauthorized Action!');
        }
        $free_slot->delete();
        return response()->json(
            [
                'message' => 'Free slot deleted successfully',
                'code' => 200
            ]
        );
        return redirect()->route('free_slot.index');
    }

}
