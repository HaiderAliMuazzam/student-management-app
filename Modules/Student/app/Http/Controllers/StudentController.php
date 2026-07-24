<?php

namespace Modules\Student\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Student\Models\Student;
use Modules\Student\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    protected StudentRepositoryInterface $students;

    public function __construct(StudentRepositoryInterface $students)
    {
        $this->students = $students;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'grade', 'subject']);
        $students = $this->students->all($filters);
        $grades = Student::select('grade')->distinct()->pluck('grade');
        $subjects = Student::select('subject')->distinct()->pluck('subject');

        return view('student::index', [
            'students' => $students,
            'grades' => $grades,
            'subjects' => $subjects,
            'filters' => $filters,
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('manage-students')) {
            abort(403, 'You are not allowed to add students.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
        ]);

        $this->students->create($validated);

        return redirect('/students');
    }

    public function edit(Student $student)
    {
        if (Gate::denies('manage-students')) {
            abort(403, 'You are not allowed to edit students.');
        }

        return view('student::edit', ['student' => $student]);
    }

    public function update(Request $request, Student $student)
    {
        if (Gate::denies('manage-students')) {
            abort(403, 'You are not allowed to edit students.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
        ]);

        $this->students->update($student, $validated);

        return redirect('/students');
    }

    public function destroy(Student $student)
    {
        if (Gate::denies('delete-student')) {
            abort(403, 'Only admins can delete students.');
        }

        $this->students->delete($student);

        return redirect('/students');
    }

    public function trashed()
    {
        if (Gate::denies('manage-students')) {
            abort(403, 'You are not allowed to view deleted students.');
        }

        $students = $this->students->trashed();

        return view('student::trashed', ['students' => $students]);
    }

    public function restore($id)
    {
        if (Gate::denies('manage-students')) {
            abort(403, 'You are not allowed to restore students.');
        }

        $this->students->restore($id);

        return redirect('/students/trashed');
    }
}