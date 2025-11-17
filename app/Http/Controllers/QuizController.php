<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\CourseTopic;
use Illuminate\Http\Request;
class QuizController extends Controller
{
    // Show all quizzes for a topic
    public function index($topic_id)
    {
        $topic = CourseTopic::with('quizzes')->findOrFail($topic_id);
        return view('quizzes.index', compact('topic')); // Your Blade file
    }

    public function store(Request $request, $topic_id)
    {
        $quiz = \App\Models\Quiz::create([
            'topic_id' => $topic_id,
            'name' => $request->name,
            'duration_minutes' => $request->duration_minutes,
            'total_marks' => $request->total_marks
        ]);

        return response()->json($quiz);
    }

    public function update(Request $request, \App\Models\Quiz $quiz)
    {
        $quiz->update($request->only('name', 'duration_minutes', 'total_marks'));
        return response()->json($quiz);
    }

    public function destroy(\App\Models\Quiz $quiz)
    {
        $quiz->delete();
        return response()->json(['success' => true]);
    }
}