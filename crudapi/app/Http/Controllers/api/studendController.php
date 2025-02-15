<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\support\Facades\Validator;

class studendController extends Controller
{
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

    public function create(Request $request)
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
        $students = Student::create([
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

    public function get($id)
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

        
    public function delete($id)
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


}
