<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return response()->json(['languages' => $languages, 'status' => 200], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:languages',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error data validation', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        $language = Language::create(['name' => $request->name]);

        return response()->json(['language' => $language, 'status' => 201], 201);
    }

    public function show($id)
    {
        $language = Language::find($id);
        if (!$language) {
            return response()->json(['message' => 'Language not found', 'status' => 404], 404);
        }
        return response()->json(['language' => $language, 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {
        $language = Language::find($id);
        if (!$language) {
            return response()->json(['message' => 'Language not found', 'status' => 404], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:languages,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error data validation', 'errors' => $validator->errors(), 'status' => 400], 400);
        }

        $language->name = $request->name;
        $language->save();

        return response()->json(['message' => 'Language updated successfully', 'updated_language' => $language, 'status' => 200], 200);
    }

    public function destroy($id)
    {
        $language = Language::find($id);
        if (!$language) {
            return response()->json(['message' => 'Language not found', 'status' => 404], 404);
        }
        $language->delete();
        return response()->json(['message' => 'Language deleted successfully', 'status' => 200], 200);
    }
}
