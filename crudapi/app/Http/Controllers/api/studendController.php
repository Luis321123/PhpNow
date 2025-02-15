<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\support\Facades\Validator;

class studendController extends Controller{ 
     public function index()
    {
       $students = Student::all();

       if ($students->isEmpty()) {
        $data = [
            'message'=> 'No data found',
            'status'=> 200 
            ];
            return response()->json($data,200);
        
       }
       
       return response()->json($students,200);
    }

    public function createstudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'required | numeric',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => 422,
            ], 422);
        }
        $students = Student::createst([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone
        ]);
        return response()->json($students,201);

        if (!$students) {
            $data = [
                'message'=> 'Student not created',
                'status'=> 500
            ];
            return response()->json($data,500);
        }
        $data = [
            'student' => $students,
            'message'=> 'Student created', 
            'status'=> 201
        ];
        return response()->json($data,201);
    }

    public function getstudent($id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message'=> 'Student not found',
                'status'=> 404
            ];
            return response()->json($data,404);
        }

        return response()->json($student,200);
    }

        
    public function deletestudent($id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message'=> 'Student not found',
                'status'=> 404 
            ];
            return response()->json($data,404);
        }
        $student->delete();
        $data = [
            'message'=> 'Student deleted',
            'status'=> 200
        ];
        return response()->json($data,200);
    }
    public function updatestudent(request $request,$id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message'=> 'Student not found',
                'status'=> 404 
            ];
            return response()->json($data,404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'required | numeric',
            ]);
        if ($validator->fails()) {
            $data=[
                'message'=> 'Validation failed',
                'status'=> 422
                ];
                return response()->json($data,422);
            }
            $student->name = $request->name;
            $student->email = $request->email;
            $student->password = $request->password;
            $student->phone = $request->phone;
            $student->save();

            $data = [
                'message'=> 'Student updated',
                'student'=> $student,
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        public function patchStudent(Request $request, $id)
        {
            $student = Student::find($id);
            if (!$student) {
                $data = [
                    'message'=> 'Student not found',
                    'status'=> 404 
                ];
                return response()->json($data,404);
            }
        $validator = Validator::make($request->all(), [
            'name' =>  'max:255',
            'email' => 'email',
            'password' => 'digits:6',
            'phone' => 'in:numeric',
            ]);
            
            if ($validator->fails()) {
                $data=[
                    'message'=> 'Validation failed',
                    'status'=> 400
                    ];
                    return response()->json($data,400);
                }
                if ($request->has('name')) {
                    $student->name = $request->name;
                }
                if ($request->has('email')) {
                    $student->email = $request->email;
                }
                if ($request->has('password')) {
                    $student->password = $request->password;
                }
                if ($request->has('phone')) {
                    $student->phone = $request->phone;
                }
                $student->save();
           
            $data = [
                'message'=> 'Student updated',
                'student'=> $student,
                'status'=> 200
            ];
            return response()->json($data,200);

        }
}