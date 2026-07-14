<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', ['students' => $students]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
        ]);

        Student::create($validated);
        return redirect('/students');
    }

    public function edit(Student $student)
    {
        return view('students.edit', ['student' => $student]);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
        ]);

        $student->update($validated);
        return redirect('/students');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect('/students');
    }
}