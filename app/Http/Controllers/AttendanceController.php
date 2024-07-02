<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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


            $user_id = $request->input('user_id');
            $status = 'On site';
            $singin = date('Y-m-d H:i:s');

            $data = [
                'user_id' => $user_id,
                'status' => $status,
                'singin' => $singin,
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

            $user_id = $request->input('user_id');
            $status = 'Off site';
            $signout = date('Y-m-d H:i:s');

            $data = [
                'user_id' => $user_id,
                'status' => $status,
                'signout' => $signout,
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


    public function getAllAttendances()
    {
        $attendances =   Attendance::all();
        return response()->json(['attendances' => $attendances], 200);
    }

    // public function getAllUser()
    // {
    //     $staffs =   User::all();
    //     return response()->json(['staffs' => $staffs],200);
    // }

    public function getAllAppointments()
    {
        $appointments =   Appointment::all();
        return response()->json(['appointments' => $appointments], 200);
    }




    public function getSingleAttendance($id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['message' => 'attendance Not Found'], 401);
        }
        return response()->json(['attendance' => $attendance]);
    }



    public function getAttendancesbyStuff($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'user Not Found'], 401);
        }
        $attendances = Attendance::where('user_id', $id)->get();
        //$Attendances = $user->Attendances()->get();
        return response()->json([
            'user' => $user,
            'attendances' => $attendances
        ]);
    }



    // public function getTodayAttendances()
    // {
    //     $date = now()->format('Y-m-d');
    //     $attendances = Attendance::whereDate('singin', $date)->get();

    //     return response()->json([
    //         'attendances' => $attendances,
    //         'message' => 'Attendance records for today',
    //     ]);
    // }


    public function checkTodayAttendance($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not find'
            ], 401);
        }

        $today = date('Y-m-d');

        // Filter attendance records by today's date
        $attendances = $user->attendances()
                            ->whereDate('singin', $today)
                            ->get();

        return response()->json($attendances);

    }


    



}
