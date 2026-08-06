<?php

namespace Modules\Student\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Grade\Models\Grade;
use Modules\Student\Http\Requests\StoreStudentRequest;
use Modules\Student\Models\Student;
use Modules\Subject\Models\Subject;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['grade', 'subject'])->latest()->paginate(10);
        $grades   = Grade::all();
        $subjects = Subject::all();

        return view('student::index', compact('students', 'grades', 'subjects'));
    }

    public function create()
    {
        $grades   = Grade::all();
        $subjects = Subject::all();

        return view('student::create', compact('grades', 'subjects'));
    }

    public function store(StoreStudentRequest $request)
    {
        Student::create($request->validated());

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        $grades   = Grade::all();
        $subjects = Subject::all();

        return view('student::edit', compact('student', 'grades', 'subjects'));
    }

    public function update(StoreStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $this->authorize('delete', $student);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}