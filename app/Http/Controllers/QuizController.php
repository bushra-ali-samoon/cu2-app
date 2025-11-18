<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\CourseTopic;
use Illuminate\Http\Request;
 

class QuizController extends Controller
{
    // ---------------- SHOW ALL QUIZZES ----------------
    public function index($topic_id)
{
    $topic = CourseTopic::with('quizzes')->findOrFail($topic_id);
    return view('quizzes.index', compact('topic'));
}

    
    // ---------------- STORE QUIZ ----------------
    public function store(Request $request, $topic_id)
    {
        $request->validate([
            'name' => 'required',
            'duration_minutes' => 'required|numeric',
            'total_marks' => 'required|numeric',
        ]);

        Quiz::create([
            'topic_id' => $topic_id,
            'name' => $request->name,
            'duration_minutes' => $request->duration_minutes,
            'total_marks' => $request->total_marks,
        ]);

        return response()->json(['message' => 'Quiz added successfully']);
    }

    // ---------------- UPDATE QUIZ ----------------
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'name' => 'required',
            'duration_minutes' => 'required|numeric',
            'total_marks' => 'required|numeric',
        ]);

        $quiz->update([
            'name' => $request->name,
            'duration_minutes' => $request->duration_minutes,
            'total_marks' => $request->total_marks,
        ]);

        return response()->json(['message' => 'Quiz updated successfully']);
    }

    // ---------------- DELETE QUIZ ----------------
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return response()->json(['message' => 'Quiz deleted']);
    }
}
