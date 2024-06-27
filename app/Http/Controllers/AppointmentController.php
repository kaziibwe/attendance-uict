<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    //


    public function createAppointment(Request $request)
    {
        try {
            $formFields = $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required',
                'descprition' => 'required',
                'starting_date' => 'required',
                'ending_date' => 'required',
            ]);


            $appointment = Appointment::create($formFields);

            if ($appointment) {
                return response()->json(["appointment" => $appointment, 'status' => true], 200);
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



    public function updateAppointment(Request $request,$id)
    {
        try {


            $Appointment = Appointment::find($id);
            if(!$Appointment){
               return response()->json(['message'=>'Appointment Not Found'],401);
            }

            $formFields = $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required',
                'descprition' => 'required',
                'starting_date' => 'required',
                'ending_date' => 'required',
                'extended_date' => 'string',

            ]);

            $appointment = Appointment::where('id',$id)->update($formFields);

            if ($appointment) {
                return response()->json(["appointment" => $appointment, 'status' => true], 200);
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




}
