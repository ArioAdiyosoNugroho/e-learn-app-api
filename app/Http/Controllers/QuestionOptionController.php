<?php

namespace App\Http\Controllers;

use App\Models\question;
use App\Models\question_option;
use Illuminate\Http\Request;

class QuestionOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $question_id = request()->query('question_id');
        if($question_id) {
            return response()->json(question_option::where('question_id', $question_id)->get());
        }

        return response()->json(question_option::all());
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
        $question = question::findOrFail($request->question_id);

        if($question->type === 'essay'){
            return response()->json([
                'message' => 'Cannot add options to an essay question'
            ], 400);
        }

        if($question->type === 'true_false' && !in_array($request->option_text,['true' , 'false'] )){
            return response()->json([
                "error" => 'Request only accept "True" or "False" as options'
            ],400);
        }

        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'option_label' => 'required|string|max:5',
            'option_text'  => 'required|string',
        ]);
        $option = question_option::create($request->all());

        return response()->json([
            'message' => 'Question option created successfully',
            'data'    => $option
        ],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(question_option $question_option)
    {
        $option = question_option::findOrFail($question_option->id);
        return response()->json($option);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(question_option $question_option)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, question_option $question_option)
    {
        $option = question_option::findOrFail($question_option->id);

        $request->validate([
            'option_label' => 'string|max:5',
            'option_text'  => 'string',
        ]);

        $option->update($request->all());

        return response()->json([
            'message' => 'Question option updated successfully',
            'data'    => $option
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(question_option $question_option)
    {
        $option = question_option::findOrFail($question_option->id);
        $option->delete();

        return response()->json([
            'message' => 'Question option deleted successfully'
        ]);
    }
}
