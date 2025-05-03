<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $items = $query->paginate($request->input('itemsPerPage', 10));

        return view('teachers.index', compact('items'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required', 'email' => 'required|email'
        ]);

        Teacher::create($validated);
        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function show($id)
    {
        $item = Teacher::findOrFail($id);
        return view('teachers.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Teacher::findOrFail($id);
        return view('teachers.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required', 'email' => 'required|email'
        ]);

        $item = Teacher::findOrFail($id);
        $item->update($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy($id)
    {
        $item = Teacher::findOrFail($id);
        $item->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
