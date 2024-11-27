<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['level', 'courses'])->get();
        return response()->json(['students' => $students, 'status' => 200], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'level_id' => 'required|exists:levels,id',
            'courses' => 'array',
            'courses.*' => 'exists:courses,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error data validation',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $student = Student::create($request->only(['name', 'email', 'phone', 'level_id']));

        if ($request->has('courses')) {
            $student->courses()->attach($request->courses);
        }

        return response()->json(['student' => $student->load(['level', 'courses']), 'status' => 201], 201);
    }

    public function show($id)
    {
        $student = Student::with(['level', 'courses'])->find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
                'status' => 404,
            ], 404);
        }

        return response()->json(['student' => $student, 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
                'status' => 404,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:students,email,' . $id,
            'phone' => 'sometimes|required|digits:10',
            'level_id' => 'sometimes|required|exists:levels,id',
            'courses' => 'sometimes|array',
            'courses.*' => 'exists:courses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error data validation',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $student->update($request->only(['name', 'email', 'phone', 'level_id']));

        if ($request->has('courses')) {
            $student->courses()->sync($request->courses);
        }

        return response()->json([
            'message' => 'Student updated successfully',
            'updated_student' => $student->load(['level', 'courses']),
            'status' => 200,
        ], 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
                'status' => 404,
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully',
            'status' => 200,
        ], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
                'status' => 404,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:students,email,' . $id,
            'phone' => 'sometimes|digits:10',
            'level_id' => 'sometimes|exists:levels,id',
            'courses' => 'sometimes|array',
            'courses.*' => 'exists:courses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error data validation',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        if ($request->has('name')) {
            $student->name = $request->name;
        }
        if ($request->has('email')) {
            $student->email = $request->email;
        }
        if ($request->has('phone')) {
            $student->phone = $request->phone;
        }
        if ($request->has('level_id')) {
            $student->level_id = $request->level_id;
        }

        $student->save();

        if ($request->has('courses')) {
            $student->courses()->sync($request->courses);
        }

        return response()->json([
            'message' => 'Student updated successfully',
            'updated_student' => $student->load(['level', 'courses']),
            'status' => 200,
        ], 200);
    }
}
