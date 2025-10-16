<?php

namespace App\Http\Controllers;

use App\Models\quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(quiz::all());

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
            'title' => 'required',
            'guru_id' => 'required',
            'materi_id' => 'required',
        ]);

        $quiz = quiz::create([
            'title' => $request->title,
            'guru_id' => $request->guru_id,
            'materi_id' => $request->materi_id,
        ]);
        $quiz->load('materi', 'guru');

        return response()->json([
            'message' => 'bisa king😎',
            'data'    => $quiz
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, quiz $quiz)
    {
        $request->validate([
            'title' => 'required',
            'guru_id' => 'required',
            'materi_id' => 'required',
        ]);

        $quiz->update([
            'title' => $request->title,
            'guru_id' => $request->guru_id,
            'materi_id' => $request->materi_id,
        ]);

        $quiz->load('materi', 'guru');
        return response()->json([
            'message' => 'bisa king😎',
            'data'    => $quiz
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(quiz $quiz)
    {
        $quiz->delete();

        return response()->json([
            'message' => 'quiz deleted successfully'
        ]);
    }
}
