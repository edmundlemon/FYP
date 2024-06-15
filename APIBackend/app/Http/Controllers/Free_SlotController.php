<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Free_slot;
use App\Rules\TimeCollision;
use Illuminate\Http\Request;
use App\Rules\FreeSlotCollision;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function index(Lecturer $lecturer)
    {
        return response()->json(
            [
                // 'freeslots' => $lecturer->free_slots()->get(),
                'freeslots' => $lecturer->upcoming_free_slots()->get(),
                'code' => 200
            ]
        );
    }

    public function store(Request $request)
    {
        $lecturer = auth('sanctum')->user();
        Log::channel('api_post_log')->error('Lecturer: ', ['lecturer' => $lecturer]);
        $formFields = $request->validate([
            'date' => 'required|date_format:Y-m-d|after:tomorrow',
            'start_time' => ['required', 'date_format:H:i', new FreeSlotCollision($request->start_time, $request->end_time, $request->date, $lecturer->id)],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        $formFields['lecturer_id'] = $lecturer->id;

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
        if (auth()->guard('sanctum')->id() !== $free_slot->lecturer_id) {
            abort(403, 'Unauthorized Action!');
        }

        $formFields = $request->validate([
            'date' => 'required|date_format:Y-m-d|after:tomorrow',
            'start_time' => ['required', 'date_format:H:i', new FreeSlotCollision($request->start_time, $request->end_time, $request->date, $free_slot->lecturer_id, $free_slot->id)],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // $formFields = $request->validate([
        //     'date' => 'required|date_format:Y-m-d|after:tomorrow',
        //     'start_time' => 'required|time_format:H:i',
        //     'end_time' => 'required|time_format:H:i|after:start_time',
        // ]);

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
        $lecturer = auth('sanctum')->user();
        if ($lecturer->id !== $free_slot->lecturer_id) {
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
