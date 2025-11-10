<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Course;
class CourseController extends Controller
{
    public function index()
    {
        $course = Course::all();
        return view('courses.index', compact('course'));
    }
  public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'description' => 'required|string|max:500',
    ]);

    $course = Course::create($request->only(['title', 'slug', 'description']));

    return response()->json([
        'status' => 'success',
        'message' => 'Course added successfully!',
        'data' => $course
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
]);

$course->update([
    'title' => $request->title,
    'slug' => Str::slug($request->title),
    'description' => $request->description,
]);
}
public function destroy($id)
{
    Courses::findOrFail($id)->delete();
    return response()->json([
        'status' => 'success',
        'message' => 'Course deleted successfully!'
    ]);
}
}


