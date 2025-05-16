<?php

namespace App\Http\Controllers;

use App\Models\CourseMaterial;
use Illuminate\Http\Request;

class CourseMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = CourseMaterial::all();
        return view('course-materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course-materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'estimated_sessions' => 'required|integer|min:1',
            'minimum_score' => 'required|integer|min:0|max:100',
        ]);

        CourseMaterial::create($request->all());

        return redirect()->route('course-materials.index')->with('success', 'Material created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseMaterial $courseMaterial)
    {
        return view('course-materials.edit', compact('courseMaterial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseMaterial $courseMaterial)
    {
        $request->validate([
            'level' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'estimated_sessions' => 'required|integer|min:1',
            'minimum_score' => 'required|integer|min:0|max:100',
        ]);

        $courseMaterial->update($request->all());

        return redirect()->route('course-materials.index')->with('success', 'Material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseMaterial $courseMaterial)
    {
        $courseMaterial->delete();

        return redirect()->route('course-materials.index')->with('success', 'Material deleted successfully.');
    }
}
