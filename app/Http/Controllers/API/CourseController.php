<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('level')->get();
        return response()->json($courses, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level_id' => 'required|exists:levels,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error data validation', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        $course = Course::create($request->all());
        return response()->json($course, 201);
    }

    public function show($id)
    {
        $course = Course::with('level')->find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found', 'status' => 404], 404);
        }
        return response()->json(['course' => $course, 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found', 'status' => 404], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level_id' => 'required|exists:levels,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error data validation', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        $course->update($request->all());
        return response()->json(['message' => 'Course updated successfully', 'updated_course' => $course, 'status' => 200], 200);
    }

    public function destroy($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found', 'status' => 404], 404);
        }
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully', 'status' => 200], 200);
    }
}
