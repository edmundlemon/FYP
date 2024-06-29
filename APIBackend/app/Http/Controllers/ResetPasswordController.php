<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\Admin;
use Ichtrojan\Otp\Otp;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    //
    public function generateOtp(Request $request){
        $formFields = $request->validate([
            'id' => 'required'
        ]);

        if (ctype_digit($formFields['id'])){
            $id = $formFields['id'];
            $email = Student::find($id)->email;
        }
        else if (strpos($formFields['id'], 'MU') === 0){
            $id = $formFields['id'];
            $email = Lecturer::find($id)->email;
        }
        else if (strpos($formFields['id'], 'AD') === 0){
            $id = $formFields['id'];
            $email = Admin::find($id)->email;
        }
        else{
            return response()->json(
                [
                    'message' => 'Invalid ID',
                    'code' => 400
                ]
            );
        }

        $otp = (new Otp)->generate($email, 'numeric', 6, 10);
        ResetPasswordEmail::dispatch($email, $otp);
        return response()->json(
            [
                'otp' => $otp,
                'code' => 200
            ]
        );
    }

    public function validateOtp(Request $request){
        $formFields = $request->validate([
            'id' => 'required',
            'otp' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        if (ctype_digit($formFields['id'])){
            $id = $formFields['id'];
            $email = Student::find($id)->email;
        }
        else if (strpos($formFields['id'], 'MU') === 0){
            $id = $formFields['id'];
            $email = Lecturer::find($id)->email;
        }
        else if (strpos($formFields['id'], 'AD') === 0){
            $id = $formFields['id'];
            $email = Admin::find($id)->email;
        }
        else{
            return response()->json(
                [
                    'message' => 'Invalid ID',
                    'code' => 400
                ]
            );
        }

        $otp = $formFields['otp'];
        $status = (new Otp)->validate($email, $otp);
        if ($status->status == 'true'){
            if (ctype_digit($formFields['id'])){
                $student = Student::find($id);
                $student->password = bcrypt($formFields['password']);
                $student->save();
            }
            else if (strpos($formFields['id'], 'MU') === 0){
                $lecturer = Lecturer::find($id);
                $lecturer->password = bcrypt($formFields['password']);
                $lecturer->save();
            }
            else if (strpos($formFields['id'], 'AD') === 0){
                $admin = Admin::find($id);
                $admin->password = bcrypt($formFields['password']);
                $admin->save();
            }
        }
        else{
            return response()->json(
                [
                    'message' => 'Invalid OTP',
                    'code' => 400
                ]
            );
        
        }
        
        return response()->json(
            [
                'status' => $status,
                'code' => 200
            ]
        );
    }
}
