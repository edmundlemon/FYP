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
        return view('testpages.upcoming-free', [
            'upcomings' => $lecturer->upcoming()->get()
        ]);
    }

    public function index()
    {
        return view('testpages.free-slots', [
            'freeslots' => Free_slot::all()
        ]);
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
        return redirect()->route('free_slot.index');
    }

    public function destroy(Free_slot $free_slot)
    {
        if(auth()->id() !== $free_slot->lecturer_id){
            abort(403, 'Unauthorized Action!');
        }
        $free_slot->delete();
        return redirect()->route('free_slot.index');
    }

}
