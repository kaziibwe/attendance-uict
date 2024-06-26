<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    //


    public function createDepartment(Request $request)
    {

        try {
            $formFields = $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);
            $data = Department::create($formFields);
            if ($data) {
                return response()->json(["data" => $data, 'status' => true], 200);
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







    public function updateDepartment(Request $request,$id)
    {

        try {
            $user = Department::find($id);
            if (!$user) {
                return response()->json(['message' => 'User Not Found'],401);
            }
            $formFields = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'sfaff_id' => 'string',
            ]);
            $data = Department::where('id',$id)->update($formFields);
            if ($data) {
                return response()->json(["data" => $data, 'status' => true], 200);
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



    public function getAllDepartments()
    {
        $departments =   Department::all();
        return response()->json(['departments' => $departments],200);
    }

    public function getSingleDepartment($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['message' => 'department Not Found'],401);
        }
        return response()->json(['department' => $department]);
    }


        // delete chats
        public function deleteDepartment($id)
        {
            try {
                $department = Department::find($id);
                if (!$department) {
                    return response()->json([
                        'message' => 'department Not found'
                    ], 401);
                }
                $department->delete();
                return response()->json([], 200);
            } catch (Exception $e) {
                return response()->json([], 500);
            }
        }















}





