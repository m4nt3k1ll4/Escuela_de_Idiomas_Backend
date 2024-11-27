<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::with('language')->get();
        return response()->json(['levels' => $levels, 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'language_id' => 'required|exists:languages,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error data validation', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        $level = Level::create($request->all());
        return response()->json(['level' => $level, 'status' => 201], 201);
    }

    public function show($id)
    {
        $level = Level::with('language')->find($id);
        if (!$level) {
            return response()->json(['message' => 'Level not found', 'status' => 404], 404);
        }
        return response()->json(['level' => $level, 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {
        $level = Level::find($id);
        if (!$level) {
            return response()->json(['message' => 'Level not found', 'status' => 404], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'language_id' => 'required|exists:languages,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error data validation', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        $level->update($request->all());
        return response()->json(['message' => 'Level updated successfully', 'updated_level' => $level, 'status' => 200], 200);
    }

    public function destroy($id)
    {
        $level = Level::find($id);
        if (!$level) {
            return response()->json(['message' => 'Level not found', 'status' => 404], 404);
        }
        $level->delete();
        return response()->json(['message' => 'Level deleted successfully', 'status' => 200], 200);
    }
}
