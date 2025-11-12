<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseTopic;
use Illuminate\Http\Request;

class CourseTopicController extends Controller
{
    public function index($course_id)
    {
        $course = Course::with('topics')->findOrFail($course_id);
        return view('topics.index', compact('course'));
    }

    public function store(Request $request, $course_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'audio_path' => 'nullable|file|mimes:mp3,wav',
            'transcript_pdf' => 'nullable|mimes:pdf',
            'worksheet_pdf' => 'nullable|mimes:pdf',
            'test_pdf' => 'nullable|mimes:pdf',
            'visible_for' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'description', 'visible_for']);
        $data['course_id'] = $course_id;

        // Handle file uploads
        foreach (['audio_path', 'transcript_pdf', 'worksheet_pdf', 'test_pdf'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $data[$fileField] = $request->file($fileField)->store('uploads/topics', 'public');
            }
        }

        CourseTopic::create($data);
        return response()->json(['message' => 'Topic created successfully']);
    }

    public function destroy($id)
    {
        $topic = CourseTopic::findOrFail($id);
        $topic->delete();
        return response()->json(['message' => 'Topic deleted successfully']);
    }
}
