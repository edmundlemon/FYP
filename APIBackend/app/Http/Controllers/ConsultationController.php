<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use App\Rules\WeekdayOnly;
use App\Jobs\AutomatedEmail;
use App\Rules\TimeCollision;
use Illuminate\Http\Request;
use App\Mail\RescheduleEmail;
use App\Jobs\AutomatedApproved;
use App\Jobs\AutomatedRejected;
use App\Jobs\AutomatedReschedule;
use App\Models\Consultation_slot;
use App\Rules\RescheduleCollision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ConsultationController extends Controller
{
    //
    public function studentIndex()
    {
        $user = Student::find(auth()->guard('sanctum')->user()->id);
        Log::channel('api_post_log')->error('User', ['user' => $user]);
        $consultation_slots = $user->consultation_slots()->where('date', '>=', today())->with('lecturer')->orderBy('date')->orderBy('start_time')->get();
        

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function studentApproved()
    {
        $user = Student::find(auth()->guard('sanctum')->user()->id);
        $consultation_slots = $user->consultation_slots()->with('lecturer')->where('status', 'Approved')->where('date', '>=', today())->orderBy('date')->orderBy('start_time')->get();
        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function lecturerApproved()
    {
        $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
        $consultation_slots = $user->consultation_slots()->with('student')->where('status', 'Approved')->where('date', '>=', today())->orderBy('date')->orderBy('start_time')->get();
        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function history(){
        if(auth()->guard('sanctum')->user()->hasRole('student')){
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->where('date', '<', today())->orderBy('date')->orderBy('start_time')->get();
        }
        else{
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->where('date', '<', today())->orderBy('date')->orderBy('start_time')->get();
        }
        
        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function pending(){
        if(auth()->guard('sanctum')->user()->hasRole('student')){
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->where('status', 'Pending')->orderBy('date')->orderBy('start_time')->get();
        }
        else{
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->where('status', 'Pending')->orderBy('date')->orderBy('start_time')->get();
        }
        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function cancelled(){
        if(auth()->guard('sanctum')->user()->hasRole('student')){
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->where('status', 'Cancelled')->orderBy('date')->orderBy('start_time')->get();
        }
        else{
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->where('status', 'Cancelled')->orderBy('date')->orderBy('start_time')->get();
        }

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function lecturerIndex()
    {
        $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
        $consultation_slots = $user->consultation_slots()->with('student')->orderBy('date')->orderBy('start_time')->get();

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function store(Request $request, Lecturer $lecturer)
    {
        $formFields = $request->validate([
            'date' => ['required', 'date_format:Y-m-d', 'after:tomorrow', new WeekdayOnly],
            'start_time' =>['required', 'date_format:H:i', new TimeCollision($request->start_time, $request->end_time, $request->date, $lecturer->id)],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        
        $formFields['lecturer_id'] = $lecturer->id;
        $formFields['student_id'] = auth()->guard('sanctum')->user()->id;
        $formFields['status'] = 'Pending';
        $formFields['topic'] = $request->topic;
        
        Log::channel('api_post_log')->error('Form Fields', ['formFields' => $formFields]);
        Consultation_slot::create($formFields);
        // return redirect()->route('dashboard');
        return response()->json(
            [
                'message' => 'Slot Created',
                'code' => 201
            ]
        );
    }

    public function studentUpdates(Request $request, Consultation_slot $consultation_slot)
    {
        Log::channel('api_post_log')->error('Request', ['request' => $request->lecturer_id]);
        $formFields = $request->validate([
            'date' => 'required|date_format:Y-m-d|after:tomorrow',
            // 'start_time' => 'required|date_format:H:i',
            'start_time' =>['required', 'date_format:H:i', new RescheduleCollision($request->start_time, $request->end_time, $request->date, $consultation_slot->lecturer_id, $consultation_slot->id)],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        Log::channel('api_post_log')->error('Slot', ['request' => $request->all()]);
        if(auth()->guard('sanctum')->id() !== $consultation_slot->student_id){
            abort(403, 'Unauthorized Action!');
        }

        $formFields['status'] = 'Student Rescheduled';
        AutomatedReschedule::dispatch($consultation_slot->student->name, $consultation_slot, $formFields)->onConnection('sync');
        $consultation_slot->update($formFields);
        return response()->json(
            [
                'message' => 'Slot Rescheduled',
                'code' => 200
            ]
        );
    }

    public function lecturerUpdates(Request $request, Consultation_slot $consultation_slot)
    {
        $formFields = $request->validate([
            'date' => 'required|date_format:Y-m-d|after:tomorrow',
            // 'start_time' => 'required|date_format:H:i',
            'start_time' =>['required', 'date_format:H:i', new RescheduleCollision($request->start_time, $request->end_time, $request->date, $consultation_slot->lecturer_id, $consultation_slot->id)],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        if(auth()->guard('sanctum')->id() !== $consultation_slot->lecturer_id){
            return response()->json(
                [
                    'message' => 'Unauthorized Action!',
                    'code' => 403
                ]
            );
        }
        $formFields['status'] = 'Lecturer Rescheduled';
        AutomatedReschedule::dispatch($consultation_slot->lecturer->name, $consultation_slot, $formFields)->onConnection('sync');
        $consultation_slot->update($formFields);
        return response()->json(
            [
                'message' => 'Slot Rescheduled',
                'code' => 200
            ]
        );
        return redirect()->route('free_slots.index');
    }

    public function approve(Consultation_slot $consultation_slot)
    {
        // dd($consultation_slot);
        if(auth()->guard('sanctum')->id() !== $consultation_slot->lecturer_id){
            abort(403, 'Unauthorized Action!');
        }
        $collision = $consultation_slot->collision($consultation_slot);
        
        // dd($collision);
        if($collision){
            return back()->with('error', 'This slot has been taken!');
        }
        
        AutomatedApproved::dispatch($consultation_slot)->onConnection('sync');
        $consultation_slot->status = 'Approved';
        $consultation_slot->save();
        return response()->json(
            [
                'message' => 'Slot Approved',
                'code' => 200
            ]
        );
        return redirect()->route('free_slots.index');
    }

    public function lecturerDestroy(Consultation_slot $consultation_slot)
    {
        if(auth()->guard('sanctum')->id() !== $consultation_slot->lecturer_id){
            return response()->json(
                [
                    'message' => 'Unauthorized Action!',
                    'code' => 403
                ]
            );
            abort(403, 'Unauthorized Action!');
        }
        AutomatedRejected::dispatch($consultation_slot)->onConnection('sync');
        $consultation_slot->status = 'Rejected';
        $consultation_slot->save();
        return response()->json(
            [
                'message' => 'Slot Rejected',
                'code' => 200
            ]
        );
        return redirect()->route('free_slots.index');
    }

    public function lecturerRejected()
    {
        $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
        $consultation_slots = $user->consultation_slots()->with('student')->where('status', 'Rejected')->orderBy('date')->orderBy('start_time')->get();
        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function studentRejected()
    {
        $user = Student::find(auth()->guard('sanctum')->user()->id);
        $consultation_slots = $user->consultation_slots()->with('lecturer')->where('status', 'Rejected')->orderBy('date')->orderBy('start_time')->get();
        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

}
