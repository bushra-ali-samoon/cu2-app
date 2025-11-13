<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseTopic;
use Illuminate\Support\Facades\DB;

class CourseTopicController extends Controller
{
    public function index($course_id)
    {
        $course = Course::with('topics')->findOrFail($course_id);
        return view('topics.index', compact('course'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::table('course_topics')->insert([
            'course_id' => $id,
            'title' => $request->title,
            'description' => $request->description,
            'audio_path' => null,
            'transcript_pdf' => null,
            'worksheet_pdf' => null,
            'test_pdf' => null,
            'visible_for' => 'all',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $topic = CourseTopic::findOrFail($id);
        $topic->delete();

        return response()->json(['message' => 'Topic deleted successfully']);
    }
}
