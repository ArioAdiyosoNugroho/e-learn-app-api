<?php

namespace App\Http\Controllers;

use App\Models\answer;
use App\Models\question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answer = answer::where('user_id', Auth::id())
        ->with('question','option')
        ->get();

        return response()->json($answer);
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
            'question_id' => 'required|exists:questions,id',
            'option_id' => 'nullable|exists:question_options,id',
            'answer_text' => 'nullable|string',
        ]);

        $question  = question::with('options')->findOrFail($request->question_id);

        $isCorrect = false;

        if(in_array($question->type, ['multiple_choice','true_false'])){
            $isCorrect = $request->option_id == $question->correct_option_id;
        }

        if($question->type == 'essay'){
            $request->merge(['option_id' => null]);
        }

        $answer = Answer::updateOrCreate(
            [
                'user_id'     => Auth::id(),
                'question_id' => $question->id,
            ],
            [
                'option_id'   => $request->option_id,
                'is_correct'  => $isCorrect,
            ]
        );

        return response()->json([
            'message' => 'Jawaban berhasil disimpan',
            'data'    => $answer
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(answer $answer)
    {
        $answers = Answer::with(['question', 'option'])
            ->where('user_id', Auth::id())
            ->findOrFail($answer->id);

        return response()->json($answers);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'option_id'   => 'nullable|exists:question_options,id',
            'answer_text' => 'nullable|string',
        ]);

        $answer = Answer::where('user_id', Auth::id())->findOrFail($id);
        $question = $answer->question;

        $isCorrect = false;
        if (in_array($question->type, ['multiple_choice','true_false'])) {
            $isCorrect = $request->option_id == $question->correct_option_id;
        }

        if ($question->type == 'essay') {
            $request->merge(['option_id' => null]);
        }

        $answer->update([
            'option_id'  => $request->option_id,
            'is_correct' => $isCorrect,
        ]);

        return response()->json([
            'message' => 'Jawaban berhasil diupdate',
            'data'    => $answer
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(answer $answer)
    {
        //
    }
}
