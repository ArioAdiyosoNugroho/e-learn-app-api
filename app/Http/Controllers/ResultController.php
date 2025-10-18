<?php

namespace App\Http\Controllers;

use App\Models\answer;
use App\Models\question;
use App\Models\result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $results = Result::with(['quiz', 'user']) 
        ->where('user_id', Auth::id())
        ->get();

    return response()->json([
        'message' => 'Riwayat hasil quiz',
        'data' => $results
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id'
        ]);

        $userId = Auth::id();
        $quizId = $request->quiz_id;

        $questions = question::where('quiz_id', $quizId)->get();
        $totalQuestions = $questions->count();

        $answers = Answer::where('user_id', $userId)
            ->whereIn('question_id', $questions->pluck('id'))
            ->get();

        $correctAnswers = $answers->where('is_correct', true)->count();
        $wrongAnswers   = $totalQuestions - $correctAnswers;

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        $result = Result::updateOrCreate(
            [
                'user_id' => $userId,
                'quiz_id' => $quizId,
            ],
            [
                'score' => $score,
                'completed_at' => now()
            ]
        );

        return response()->json([
            'message' => 'Hasil quiz berhasil dihitung',
            'data' => [
                'id' => $result->id,
                'user_id' => $userId,
                'quiz_id' => $quizId,
                'score' => $score,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'created_at' => $result->created_at,
                'updated_at' => $result->updated_at,
            ]
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(result $result)
    {
        $results = Result::where('user_id', Auth::id())
            ->with('quiz')
            ->findOrFail($result->id);

        return response()->json($results);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(result $result)
    {
        //
    }
}
