<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\materi;
use App\Models\User;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(materi::all());
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
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'file_url'    => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'guru_id'     => 'required|exists:users,id',
        ]);

        $materi = materi::create([
            'title'       => $request->title,
            'content'     => $request->content,
            'file_url'    => $request->file_url,
            'category_id' => $request->category_id,
            'guru_id'     => $request->guru_id,
        ]);

        $materi->load('category', 'guru');
        return response()->json([
            'message' => 'Materi created successfully',
            'data'    => $materi
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(materi $materi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(materi $materi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, materi $materi)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'file_url'    => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'guru_id'     => 'required|exists:users,id',
        ]);

        $materi->update([
            'title'       => $request->title,
            'content'     => $request->content,
            'file_url'    => $request->file_url,
            'category_id' => $request->category_id,
            'guru_id'     => $request->guru_id,
        ]);

        $materi->load('category', 'guru');
        return response()->json([
            'message' => 'Materi updated successfully',
            'data'    => $materi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(materi $materi)
    {
        $materi->delete();

        return response()->json([
            'message' => 'Materi deleted successfully'
        ]);
    }
}
