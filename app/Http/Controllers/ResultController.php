<?php

namespace App\Http\Controllers;

use App\Models\answer;
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
        $result = result::with('user_id',Auth::id())
        ->with('quiz')
        ->get();

        return response()->json($result);
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
            'quiz_id' =>'required|exists:quizzes,id',
        ]);

        $quizId = $request->quiz_id;

        //ngitung
        $answers = answer::where('user_id', Auth::id())
        ->whereHas('question', function($q) use ($quizId){
            $q->where('quiz_id', $quizId);
        })->get();

        $totalQuestions  = $answers->count();
        $correctAnswers  = $answers->where('is_correct', true)->count();
        $score           = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // Simpan / update result
        $result = Result::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'quiz_id' => $quizId,
            ],
            [
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'score'           => $score,
            ]
        );

        return response()->json([
            'message' => 'Hasil quiz berhasil dihitung',
            'data'    => $result
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
