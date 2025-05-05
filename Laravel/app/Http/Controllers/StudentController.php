<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('birthdate')) {
            $query->where('birthdate', $request->birthdate);
        }

        $items = $query->paginate($request->input('itemsPerPage', 10));

        return view('students.index', compact('items'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'birthdate' => 'required|date'
        ]);

        Student::create($validated);
        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show($id)
    {
        $item = Student::findOrFail($id);
        return view('students.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Student::findOrFail($id);
        return view('students.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'birthdate' => 'required|date'
        ]);

        $item = Student::findOrFail($id);
        $item->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $item = Student::findOrFail($id);
        $item->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
