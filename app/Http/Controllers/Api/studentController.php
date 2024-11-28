<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    // Obtener todos los estudiantes
    public function index()
    {
        $students = Student::all();

        if ($students->isEmpty()) {
            return response()->json([
                'message' => 'No students found',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'students' => $students,
            'status' => 200
        ], 200);
    }

   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required',
            'language' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $student = Student::create($request->all());

        return response()->json([
            'message' => 'Student created successfully',
            'student' => $student,
            'status' => 201
        ], 201);
    }

   
    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'student' => $student,
            'status' => 200
        ], 200);
    }

   
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:students,email,' . $id,
            'phone' => 'sometimes|required',
            'language' => 'sometimes|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $student->update($request->all());

        return response()->json([
            'message' => 'Student updated successfully',
            'student' => $student,
            'status' => 200
        ], 200);
    }

   
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
                'status' => 404
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully',
            'status' => 200
        ], 200);
    }
}
