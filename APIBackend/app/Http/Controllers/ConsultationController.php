<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use App\Jobs\AutomatedEmail;
use App\Rules\TimeCollision;
use Illuminate\Http\Request;
use App\Mail\RescheduleEmail;
use App\Jobs\AutomatedApproved;
use App\Jobs\AutomatedRejected;
use App\Jobs\AutomatedReschedule;
use App\Models\Consultation_slot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ConsultationController extends Controller
{
    //
    public function studentIndex()
    {
        $user = Student::find(auth()->user()->id);
        $consultation_slots = $user->consultation_slots()->with('lecturer')->orderBy('date')->orderBy('start_time')->get();

        return view('testpages.consultation-index',
            // compact('consultation_slots')
            [
                'consultation_slots' => $consultation_slots
            ]
        );
    
    }
    public function lecturerIndex()
    {
        $user = Lecturer::find(auth()->user()->id);
        $consultation_slots = $user->consultation_slots()->with('student')->orderBy('date')->orderBy('start_time')->get();

        return view('testpages.lecturer-consultation-index',
            // compact('consultation_slots')
            [
                'consultation_slots' => $consultation_slots
            ]
        );
    }

    public function store(Request $request, Lecturer $lecturer)
    {
        // dd($request->all());
        $formFields = $request->validate([
            'date' => 'required|date_format:Y-m-d|after:tomorrow',
            'start_time' =>['required', 'date_format:H:i', new TimeCollision($request->start_time, $request->end_time, $request->date, $lecturer->id)],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $formFields['lecturer_id'] = $lecturer->id;
        $formFields['student_id'] = auth()->user()->id;
        $formFields['status'] = 'requested';

        Consultation_slot::create($formFields);
        return redirect()->route('dashboard');
    }

    public function studentUpdates(Request $request, Consultation_slot $consultation_slot)
    {
        $formFields = $request->validate([
            'date' => 'required|date_format:Y-m-d|after:tomorrow',
            'start_time' => 'required|time_format:H:i',
            'end_time' => 'required|time_format:H:i|after:start_time',
        ]);

        if(auth()->id() !== $consultation_slot->student_id){
            abort(403, 'Unauthorized Action!');
        }

        $formFields['status'] = 'Student Rescheduled';
        AutomatedReschedule::dispatch($consultation_slot->student->name, $consultation_slot, $formFields)->onConnection('sync');
        $consultation_slot->update($formFields);
        return redirect()->route('dashboard');
    }

    public function lecturerUpdates(Request $request, Consultation_slot $consultation_slot)
    {
        $formFields = $request->validate([
            'date' => 'required|date_format:Y-m-d|after:tomorrow',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        if(auth()->id() !== $consultation_slot->lecturer_id){
            abort(403, 'Unauthorized Action!');
        }
        $formFields['status'] = 'Lecturer Rescheduled';
        AutomatedReschedule::dispatch($consultation_slot->lecturer->name, $consultation_slot, $formFields)->onConnection('sync');
        $consultation_slot->update($formFields);
        return redirect()->route('free_slots.index');
    }

    public function approve(Consultation_slot $consultation_slot)
    {
        // dd($consultation_slot);
        if(auth()->id() !== $consultation_slot->lecturer_id){
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
        return redirect()->route('free_slots.index');
    }

    public function lecturerDestroy(Consultation_slot $consultation_slot)
    {
        if(auth()->id() !== $consultation_slot->lecturer_id){
            abort(403, 'Unauthorized Action!');
        }
        AutomatedRejected::dispatch($consultation_slot)->onConnection('sync');
        $consultation_slot->status = 'Rejected';
        $consultation_slot->save();
        return redirect()->route('free_slots.index');
    }

}
