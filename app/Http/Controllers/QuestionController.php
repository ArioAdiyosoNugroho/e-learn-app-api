<?php

namespace App\Http\Controllers;

use App\Models\materi;
use App\Models\question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $question = question::with('quiz', 'options', 'correctOption')->get();
        return response()->json($question);
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
        $validate = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question'    => 'required|string',
            'type'    => 'required|in:multiple_choice,true_false,essay',
            'correct_option_id' => 'nullable|exists:question_options,id',
        ]);

        $question = question::create($validate);

        return response()->json([
            'message' => 'Question created successfully',
            'data'    => $question
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(question $question)
    {
        //
    }
}
