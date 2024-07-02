<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    //

    //
    public function _construct()
    {
        $this->middleware('auth:admin-api', ['except' => ['adminlogin', 'adminregister']]);
    }

    public function registerStaff(Request $request)
    {

        try {


            $formFields = $request->validate([
                'department_id' => 'nullable|exists:departments,id',
                'name' => 'required',
                'title' => 'nullable',
                'department_id' => 'nullable|exists:departments,id',
                'name'=>'required',
                'title'=>'nullable',
                'staff_number'=>'nullable',
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'dob'=>'required',
                'phone'=>'required',
                'current_appointment'=>'nullable',
                'appointment_date'=>'nullable',
                'nin'=>'nullable',
                'tin'=>'nullable',
                'staff_number'=>'nullable',

                'date_appointed'=>'nullable',
                'salary_scale'=>'nullable',
                'salary_amount'=>'nullable',
                'allowances'=>'nullable',
                'gross_pay'=>'nullable',
                'education'=>'nullable',
                'netpay'=>'nullable',
                'duty'=>'nullable',
                'first_appointment'=>'nullable',
                'date_first_appointment'=>'nullable',
                'appointment_status'=>'nullable',
                'password'=>'required',
                // 'image' => 'file|mimes:jpeg,png,jpg,gif,svg', // Adjust the validation rules as needed
            ]);

            if ($request->hasFile('image')) {
                $formFields['image'] = $request->file('image')->store('images', 'public');
            }
            // Hash password
            $formFields['password'] = bcrypt($formFields['password']);

            $admin = User::create($formFields);

            if ($admin) {
                return response()->json(["Admin" => $admin, 'status' => true], 200);
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


    public function updateUser(Request $request, $id)
    {

        try {

            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'Staff Not Found'], 401);
            }

            $formFields = $request->validate([
                'department_id' => 'nullable|exists:departments,id',
                'name' => 'required',
                'title' => 'string',
                'staff_number' => 'string',
                'email' => 'string',
                'dob' => 'string',
                'phone' => 'string',
                'current_appointment' => 'string',
                'appointment_date' => 'string',
                'nin' => 'string',
                'tin' => 'string',
                'staff_number' => 'string',

                'date_appointed' => 'string',
                'salary_scale' => 'string',
                'salary_amount' => 'string',
                'allowances' => 'string',
                'gross_pay' => 'string',
                'education' => 'string',
                'netpay' => 'string',
                'duty' => 'string',
                'first_appointment' => 'string',
                'date_first_appointment' => 'string',
                'appointment_status' => 'string',
            ]);

            if ($request->hasFile('image')) {
                $formFields['image'] = $request->file('image')->store('images', 'public');
            }
            // Hash password
            // $formFields['password'] = bcrypt($formFields['password']);

            $admin = User::where('id', $id)->update($formFields);

            if ($admin) {
                return response()->json(["Admin" => $admin, 'status' => true], 200);
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

    public function deleteUser($id){
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message'=>'User not find'
            ],401);
        }

        $user->delete();
        return response()->json(['message'=>'User deleted successfully'],200);

    }


    public function changePasswordUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Staff Not Found'], 401);
        }

        $data = $request->all();

        if (Hash::check($data['current_pwd'], $user->password)) {
            $user->update(['password' => bcrypt($data['new_pwd'])]);
            return response()->json(["message" => "Password changed successfully", 'status' => true], 200);
        } else {
            return response()->json(['message' => 'Current password is incorrect.'], 400);
        }
    }
    public function logoutUser()
    {
        auth()->guard('user-api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function loginStaff(Request $request)
    {
        $credentials = request(['email', 'password']);
        // return $credentials;
        if (!$token = auth()->guard('user-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized Staff'], 401);
        }
        return $this->respondWithToken($token);
    }


    protected function respondWithToken($token)
    {
        // $user = auth()->guard('admin-api')->user();
        $user = auth()->guard('user-api')->user();
        $userData = $user->only('id', 'email', 'name', 'title', 'dob', 'nin', 'tin', 'staff_number', 'image', 'phone');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('user-api')->factory()->getTTL() * 60,
            'user' => $userData


        ]);
    }









    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => Auth::guard('admin-api')->factory()->getTTL() * 60
    //     ]);
    // }

    public function profileStaff()
    {
        return response()->json(auth()->guard('user-api')->user());
    }




    public function getAllUser()
    {
        $users =   User::all();
        return response()->json(['users' => $users]);
    }

    public function getSingleUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Staff Not Found'], 401);
        }
        return response()->json(['staff' => $user]);
    }



    public function getAllAdmin()
    {
        $Admins =   Admin::all();
        return response()->json(['Admins' => $Admins], 200);
    }
    public function getSingleAdmin($id)
    {
        $Admin = Admin::find($id);
        if (!$Admin) {
            return response()->json(['message' => 'Admin Not Found'], 401);
        }
        return response()->json(['Admin' => $Admin], 200);
    }
}
