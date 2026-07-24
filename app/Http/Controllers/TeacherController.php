<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Repositories\Contracts\TeacherRepositoryInterface;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected TeacherRepositoryInterface $teachers;

    public function __construct(TeacherRepositoryInterface $teachers)
    {
        $this->teachers = $teachers;
    }

    public function index()
    {
        $teachers = $this->teachers->all();

        return view('teachers.index', ['teachers' => $teachers]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            //
        ]);

        $this->teachers->create($validated);

        return redirect('/teachers');
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            //
        ]);

        $this->teachers->update($teacher, $validated);

        return redirect('/teachers');
    }

    public function destroy(Teacher $teacher)
    {
        $this->teachers->delete($teacher);

        return redirect('/teachers');
    }
}
