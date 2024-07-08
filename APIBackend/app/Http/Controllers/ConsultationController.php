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
use App\Jobs\AutomatedCancellation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Jobs\AutomatedCancellationEmail;
use App\Jobs\UpdateExpiredConsultationSlots;

class ConsultationController extends Controller
{
    //

    public function studentIndex()
    {
        $user = Student::find(auth()->guard('sanctum')->user()->id);
        Log::channel('api_post_log')->error('User', ['user' => $user]);
        $consultation_slots = $user->consultation_slots()
            ->with('lecturer')
            ->where('date', '>=', today())
            ->whereIn('status', ['Approved', 'Student Reschedule Approved', 'Lecturer Reschedule Approved'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

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
        $consultation_slots = $user->consultation_slots()->with('lecturer')->whereIn('status', ['Approved', 'Student Reschedule Approved', 'Lecturer Reschedule Approved'])->where('date', '>=', today())->orderBy('date')->orderBy('start_time')->get();
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
        $consultation_slots = $user->consultation_slots()->with('student')->whereIn('status', ['Approved', 'Student Reschedule Approved', 'Lecturer Reschedule Approved'])->where('date', '>=', today())->orderBy('date')->orderBy('start_time')->get();
        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function history()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->where('date', '<', today())->orderBy('date')->orderBy('start_time')->get();
        } else {
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

    public function pending()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->whereIn('status', ['Pending', 'Student Rescheduled'])->orderBy('date')->orderBy('start_time')->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->whereIn('status', ['Pending', 'Lecturer Rescheduled'])->where('date', '>=', today())->orderBy('date')->orderBy('start_time')->get();
        }

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function cancelled()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->where('status', 'Cancelled')->orderBy('date')->orderBy('start_time')->get();
        } else {
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
        $consultation_slots = $user->consultation_slots()
            ->with('student')
            ->where('date', '>=', today())
            ->whereIn('status', ['Approved', 'Student Reschedule Approved', 'Lecturer Reschedule Approved'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function store(Request $request, Lecturer $lecturer)
    {
        // dd($request->all());

        $formFields = $request->validate([
            'date' => ['required', 'date_format:Y-m-d', 'after:tomorrow', new WeekdayOnly],
            'start_time' => ['required', 'date_format:H:i', new TimeCollision($request->start_time, $request->end_time, $request->date, $lecturer->id)],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $formFields['lecturer_id'] = $lecturer->id;
        $formFields['student_id'] = auth()->guard('sanctum')->user()->id;
        $formFields['status'] = 'Pending';
        $formFields['topic'] = $request->topic;

        // Log::channel('api_post_log')->error('Form Fields', ['formFields' => $formFields]);
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
            'date' => ['required', 'date_format:Y-m-d', 'after:tomorrow', new WeekdayOnly],
            // 'start_time' => 'required|date_format:H:i',
            'start_time' => ['required', 'date_format:H:i', new TimeCollision($request->start_time, $request->end_time, $request->date, $consultation_slot->lecturer_id)],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        Log::channel('api_post_log')->error('Slot', ['request' => $request->all()]);
        if (auth()->guard('sanctum')->id() !== $consultation_slot->student_id) {
            abort(403, 'Unauthorized Action!');
        }

        $formFields['status'] = 'Student Rescheduled';
        $formFields['lecturer_read'] = false;
        $formFields['student_read'] = true;
        AutomatedReschedule::dispatch($consultation_slot->student->name, $consultation_slot, $formFields, $consultation_slot->lecturer->email)->onConnection('sync');
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
            'start_time' => ['required', 'date_format:H:i', new TimeCollision($request->start_time, $request->end_time, $request->date, $consultation_slot->lecturer_id)],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        if (auth()->guard('sanctum')->id() !== $consultation_slot->lecturer_id) {
            return response()->json(
                [
                    'message' => 'Unauthorized Action!',
                    'code' => 403
                ]
            );
        }
        $formFields['status'] = 'Lecturer Rescheduled';
        $formFields['lecturer_read'] = true;
        $formFields['student_read'] = false;
        AutomatedReschedule::dispatch($consultation_slot->lecturer->name, $consultation_slot, $formFields, $consultation_slot->student->email)->onConnection('sync');
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
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            if (auth()->guard('sanctum')->id() !== $consultation_slot->student_id) {
                abort(403, 'Unauthorized Action!');
            }
        } else {
            if (auth()->guard('sanctum')->id() !== $consultation_slot->lecturer_id) {
                abort(403, 'Unauthorized Action!');
            }
        }
        $collision = $consultation_slot->collision();
        Log::channel('api_post_log')->error('Collision', ['collision' => $collision]);
        if ($collision) {
            return response()->json(
                [
                    'message' => 'Time Collision',
                    'code' => 409
                ]
            );
        }


        if ($consultation_slot->status === 'Student Rescheduled') {
            $consultation_slot->status = 'Student Reschedule Approved';
            $consultation_slot->lecturer_read = true;
            $consultation_slot->student_read = false;
        } else if ($consultation_slot->status === 'Lecturer Rescheduled') {
            $consultation_slot->status = 'Lecturer Reschedule Approved';
            $consultation_slot->student_read = true;
            $consultation_slot->lecturer_read = false;
        } else {
            $consultation_slot->status = 'Approved';
        }

        AutomatedApproved::dispatch($consultation_slot)->onConnection('sync');
        $consultation_slot->save();
        return response()->json(
            [
                'message' => 'Slot Approved',
                'code' => 200
            ]
        );
        return redirect()->route('free_slots.index');
    }

    // public function rescheduleApproval(Consultation_slot $consultation_slot)
    // {
    //     if(auth()->guard('sanctum')->user()->hasRole('student')){
    //         if(auth()->guard('sanctum')->id() !== $consultation_slot->student_id){
    //             abort(403, 'Unauthorized Action!');
    //         }
    //         $consultation_slot->status = 'Student Reschedule Approved';
    //     } else {
    //         if(auth()->guard('sanctum')->id() !== $consultation_slot->lecturer_id){
    //             abort(403, 'Unauthorized Action!');
    //         }
    //         $consultation_slot->status = 'Lecturer Reschedule Approved';
    //     }

    //     $consultation_slot->save();

    //     return response()->json(
    //         [
    //             'message' => 'Reschedule Approved',
    //             'code' => 200
    //         ]
    //     );
    // }

    public function lecturerReject(Consultation_slot $consultation_slot)
    {
        if (auth()->guard('sanctum')->id() !== $consultation_slot->lecturer_id) {
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
        $consultation_slot->lecturer_read = true;
        $consultation_slot->save();
        return response()->json(
            [
                'message' => 'Slot Rejected',
                'code' => 200
            ]
        );
        return redirect()->route('free_slots.index');
    }

    public function studentReject(Consultation_slot $consultation_slot)
    {
        if (auth()->guard('sanctum')->id() !== $consultation_slot->student_id && ($consultation_slot->status !== 'Lecturer Rescheduled')) {
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
        $consultation_slot->student_read = true;
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

    public function allPending()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->whereIn('status', ['Pending', 'Student Rescheduled'])->orderBy('updated_at', 'desc')->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->whereIn('status', ['Pending', 'Lecturer Rescheduled'])->orderBy('updated_at', 'desc')->get();
        }

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function allPast()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->whereIn('status', ['Cancelled', 'Rejected', 'Expired'])->orderBy('updated_at', 'desc')->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()
                ->with('student')
                ->whereIn('status', ['Cancelled', 'Rejected', 'Expired'])
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function allApproved()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->whereIn('status', ['Approved'])->orderBy('updated_at', 'desc')->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->whereIn('status', ['Approved'])->orderBy('updated_at', 'desc')->get();
        }

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function allRescheduled()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->whereIn('status', ['Student Reschedule Approved', 'Lecturer Reschedule Approved',])->orderBy('updated_at', 'desc')->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->whereIn('status', ['Student Reschedule Approved', 'Lecturer Reschedule Approved'])->orderBy('updated_at', 'desc')->get();
        }

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function allExpired()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->where('status', 'Expired')->orderBy('updated_at', 'desc')->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->where('status', 'Expired')->orderBy('updated_at', 'desc')->get();
        }

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function Requests()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->whereIn('status', ['Lecturer Rescheduled'])->orderBy('updated_at', 'desc')->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->whereIn('status', ['Student Rescheduled'])->orderBy('updated_at', 'desc')->get();
        }

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function complete(Consultation_slot $consultation_slot)
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            if (auth()->guard('sanctum')->id() !== $consultation_slot->student_id) {
                abort(403, 'Unauthorized Action!');
            }
        } else {
            if (auth()->guard('sanctum')->id() !== $consultation_slot->lecturer_id) {
                abort(403, 'Unauthorized Action!');
            }
        }
        $consultation_slot->status = 'Completed';
        $consultation_slot->save();
        return response()->json(
            [
                'message' => 'Slot Marked as Completed',
                'code' => 200
            ]
        );
        return redirect()->route('free_slots.index');
    }

    public function allCompleted()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->whereIn('status', ['Completed', 'Completed & Reviewed'])->orderBy('updated_at', 'desc')->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->whereIn('status', ['Completed', 'Completed & Reviewed'])->orderBy('updated_at', 'desc')->get();
        }

        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function lecturerCancel(Consultation_slot $consultation_slot)
    {
        if (auth()->guard('sanctum')->id() !== $consultation_slot->lecturer_id) {
            return response()->json(
                [
                    'message' => 'Unauthorized Action!',
                    'code' => 403
                ]
            );
            abort(403, 'Unauthorized Action!');
        }
        $consultation_slot->lecturer_read = true;
        $consultation_slot->student_read = false;
        $consultation_slot->status = 'Cancelled';
        AutomatedCancellation::dispatch($consultation_slot, $consultation_slot->student->email, $consultation_slot->lecturer->name)->onConnection('sync');
        $consultation_slot->save();
        return response()->json(
            [
                'message' => 'Slot Cancelled',
                'code' => 200
            ]
        );
        return redirect()->route('free_slots.index');
    }

    public function studentCancel(Consultation_slot $consultation_slot)
    {
        if (auth()->guard('sanctum')->id() !== $consultation_slot->student_id) {
            return response()->json(
                [
                    'message' => 'Unauthorized Action!',
                    'code' => 403
                ]
            );
            abort(403, 'Unauthorized Action!');
        }
        $consultation_slot->student_read = true;
        $consultation_slot->lecturer_read = false;
        $consultation_slot->status = 'Cancelled';
        AutomatedCancellation::dispatch($consultation_slot, $consultation_slot->lecturer->email, $consultation_slot->student->name)->onConnection('sync');
        $consultation_slot->save();
        return response()->json(
            [
                'message' => 'Slot Cancelled',
                'code' => 200
            ]
        );
        return redirect()->route('free_slots.index');
    }

    public function cancelledSlots()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('lecturer')->where('status', 'Cancelled')->orderBy('updated_at', 'desc')->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $consultation_slots = $user->consultation_slots()->with('student')->where('status', 'Cancelled')->orderBy('updated_at', 'desc')->get();
        }



        return response()->json(
            [
                'consultation_slots' => $consultation_slots,
                'code' => 200
            ]
        );
    }

    public function Notification()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $rescheduled_slots = Consultation_slot::where('student_id', auth()->guard('sanctum')->id())->where('status', 'Lecturer Rescheduled')->where('student_read', '!=', true)->orderBy('updated_at', 'desc')->count();
            $cancelled_slots = Consultation_slot::where('student_id', auth()->guard('sanctum')->id())->where('status', 'Cancelled')->where('student_read', '!=', true)->orderBy('updated_at', 'desc')->count();
            $rejected_slots = Consultation_slot::where('student_id', auth()->guard('sanctum')->id())->where('status', 'Rejected')->where('student_read', '!=', true)->orderBy('updated_at', 'desc')->count();

            return response()->json(
                [
                    'rescheduled_slots' => $rescheduled_slots,
                    'cancelled_slots' => $cancelled_slots,
                    'rejected_slots' => $rejected_slots,
                    'code' => 200
                ]
            );
        } else {
            $rescheduled_slots = Consultation_slot::where('lecturer_id', auth()->guard('sanctum')->id())->where('status', 'Student Rescheduled')->where('lecturer_read', '!=', true)->orderBy('updated_at', 'desc')->count();
            $cancelled_slots = Consultation_slot::where('lecturer_id', auth()->guard('sanctum')->id())->where('status', 'Cancelled')->where('lecturer_read', '!=', true)->orderBy('updated_at', 'desc')->count();
            $rejected_slots = Consultation_slot::where('lecturer_id', auth()->guard('sanctum')->id())->where('status', 'Rejected')->where('lecturer_read', '!=', true)->orderBy('updated_at', 'desc')->count();
            $pending_slots = Consultation_slot::where('lecturer_id', auth()->guard('sanctum')->id())->where('status', 'Pending')->where('lecturer_read', '!=', true)->orderBy('updated_at', 'desc')->count();

            return response()->json(
                [
                    'rescheduled_slots' => $rescheduled_slots,
                    'cancelled_slots' => $cancelled_slots,
                    'rejected_slots' => $rejected_slots,
                    'pending_slots' => $pending_slots,
                    'code' => 200
                ]
            );
        }
    }

    public function updateCancelled_ReadStatus()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $cancelled_slots = Consultation_slot::where('student_id', $user->id)->where('status', 'Cancelled')->where('student_read', '!=', true)->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $cancelled_slots = Consultation_slot::where('lecturer_id',  $user->id)->where('status', 'Cancelled')->where('lecturer_read', '!=', true)->get();
        }

        if ($cancelled_slots->count() > 0) {
            foreach ($cancelled_slots as $slot) {
                if (auth()->guard('sanctum')->user()->hasRole('student'))
                    $slot->student_read = true;
                else
                    $slot->lecturer_read = true;

                $slot->save();
            }
            return response()->json(
                [
                    'message' => 'Read Status Updated',
                    'code' => 200
                ]
            );
        }
        return response()->json(
            [
                'message' => 'No Read Status Updated',
                'code' => 200
            ]
        );
    }

    public function updateRejected_ReadStatus()
    {
        if (auth()->guard('sanctum')->user()->hasRole('student')) {
            $user = Student::find(auth()->guard('sanctum')->user()->id);
            $rejected_slots = Consultation_slot::where('student_id', $user->id)->where('status', 'Rejected')->where('student_read', '!=', true)->get();
        } else {
            $user = Lecturer::find(auth()->guard('sanctum')->user()->id);
            $rejected_slots = Consultation_slot::where('lecturer_id',  $user->id)->where('status', 'Rejected')->where('lecturer_read', '!=', true)->get();
        }

        if ($rejected_slots->count() > 0) {
            foreach ($rejected_slots as $slot) {
                if (auth()->guard('sanctum')->user()->hasRole('student'))
                    $slot->student_read = true;
                else
                    $slot->lecturer_read = true;

                $slot->save();
            }
            return response()->json(
                [
                    'message' => 'Read Status Updated',
                    'code' => 200
                ]
            );
        }
        return response()->json(
            [
                'message' => 'No Read Status Updated',
                'code' => 200
            ]
        );
    }
}
