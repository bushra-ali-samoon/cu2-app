<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Course;
 
class CourseController extends Controller
{
    // List all courses
    public function index()
    {
        $courses = Course::all(); // get all courses
        return view('courses.index', compact('courses'));
    }

    // Store new course
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses,slug',
            'description' => 'nullable|string',
        ]);

        $course = Course::create($request->only('title','slug','description'));

        return response()->json(['message'=>'Course added successfully','course'=>$course]);
    }

    // Update existing course
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses,slug,'.$course->id,
            'description' => 'nullable|string',
        ]);

        $course->update($request->only('title','slug','description'));

        return response()->json(['message'=>'Course updated successfully','course'=>$course]);
    }

    // Delete course
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['message'=>'Course deleted successfully']);
    }
}

