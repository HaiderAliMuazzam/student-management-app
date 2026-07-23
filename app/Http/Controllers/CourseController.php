<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Repositories\Contracts\CourseRepositoryInterface;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected CourseRepositoryInterface $courses;

    public function __construct(CourseRepositoryInterface $courses)
    {
        $this->courses = $courses;
    }

    public function index()
    {
        $courses = $this->courses->all();
        return view('courses.index', ['courses' => $courses]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            //
        ]);

        $this->courses->create($validated);
        return redirect('/courses');
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            //
        ]);

        $this->courses->update($course, $validated);
        return redirect('/courses');
    }

    public function destroy(Course $course)
    {
        $this->courses->delete($course);
        return redirect('/courses');
    }
}