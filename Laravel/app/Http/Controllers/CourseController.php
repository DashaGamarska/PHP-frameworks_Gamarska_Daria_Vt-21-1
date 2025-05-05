<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $items = $query->paginate($request->input('itemsPerPage', 10));

        return view('courses.index', compact('items'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required', 'description' => 'required', 'teacher_id' => 'required|exists:teachers,id'
        ]);

        Course::create($validated);
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show($id)
    {
        $item = Course::findOrFail($id);
        return view('courses.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Course::findOrFail($id);
        return view('courses.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required', 'description' => 'required', 'teacher_id' => 'required|exists:teachers,id'
        ]);

        $item = Course::findOrFail($id);
        $item->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $item = Course::findOrFail($id);
        $item->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
