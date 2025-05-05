<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['student', 'course']);

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $items = $query->paginate($request->input('itemsPerPage', 10));

        return view('enrollments.index', compact('items'));
    }

    public function create()
    {
        return view('enrollments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id'
        ]);

        Enrollment::create($validated);
        return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully.');
    }

    public function show($id)
    {
        $item = Enrollment::findOrFail($id);
        return view('enrollments.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Enrollment::findOrFail($id);
        return view('enrollments.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id'
        ]);

        $item = Enrollment::findOrFail($id);
        $item->update($validated);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully.');
    }

    public function destroy($id)
    {
        $item = Enrollment::findOrFail($id);
        $item->delete();

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully.');
    }
}
