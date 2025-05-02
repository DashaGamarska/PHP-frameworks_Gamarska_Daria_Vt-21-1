<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $items = Grade::all();
        return view('grades.index', compact('items'));
    }

    public function create()
    {
        return view('grades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'score' => 'required|numeric',
            'enrollment_id' => 'required|exists:enrollments,id'
        ]);

        Grade::create($validated);
        return redirect()->route('grades.index')->with('success', 'Grade created successfully.');
    }

    public function show($id)
    {
        $item = Grade::findOrFail($id);
        return view('grades.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Grade::findOrFail($id);
        return view('grades.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'score' => 'required|numeric',
            'enrollment_id' => 'required|exists:enrollments,id'
        ]);

        $item = Grade::findOrFail($id);
        $item->update($validated);

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy($id)
    {
        $item = Grade::findOrFail($id);
        $item->delete();

        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }
}
