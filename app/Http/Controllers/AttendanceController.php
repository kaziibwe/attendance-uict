<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    //


    public function createAttendance(Request $request)
    {
        try {
            $formFields = $request->validate([
                'user_id' => 'required|exists:users,id',

                // 'signout' => 'string',
            ]);


            $user_id=$request->input('user_id');
            $status = 'On site';
            $singin= date('Y-m-d H:i:s');

            $data = [
                'user_id'=>$user_id,
                'status'=>$status,
                'singin'=>$singin,
            ];

            $attendance = Attendance::create($data);

            if ($attendance) {
                return response()->json(["attendance" => $attendance, 'status' => true], 200);
            } else {
                return response()->json(['status' => false], 500);
            }
        } catch (ValidationException $e) {
            // Return JSON response with validation errors
            return response()->json([
                'errors' => $e->errors(), // Detailed validation errors
            ], 422);
        } catch (\Exception $e) {
            // Catch any other exceptions and return a generic error response
            return response()->json([
                'error' => $e->getMessage(), // Detailed error message
            ], 500);
        }
    }



    public function updateAttendance(Request $request, $id)
    {
        try {
            $Attendance = Attendance::find($id);
            if (!$Attendance) {
                return response()->json(['message' => 'Attendance Not Found'], 401);
            }
            $formFields = $request->validate([
                'user_id' => 'required|exists:users,id',

            ]);

            $user_id=$request->input('user_id');
            $status = 'Off site';
            $signout= date('Y-m-d H:i:s');

            $data = [
                'user_id'=>$user_id,
                'status'=>$status,
                'signout'=>$signout,
            ];


            $Attendance = Attendance::where('id', $id)->update($data);
            if ($Attendance) {
                return response()->json(["attendance" => $Attendance, 'status' => true], 200);
            } else {
                return response()->json(['status' => false], 500);
            }
        } catch (ValidationException $e) {
            // Return JSON response with validation errors
            return response()->json([
                'errors' => $e->errors(), // Detailed validation errors
            ], 422);
        } catch (\Exception $e) {
            // Catch any other exceptions and return a generic error response
            return response()->json([
                'error' => $e->getMessage(), // Detailed error message
            ], 500);
        }
    }



    public function getAllAppointments()
    {
        $appointments =   Attendance::all();
        return response()->json(['appointments' => $appointments],200);
    }




}
