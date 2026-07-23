<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Repositories\Contracts\EnrollmentRepositoryInterface;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    protected EnrollmentRepositoryInterface $enrollments;

    public function __construct(EnrollmentRepositoryInterface $enrollments)
    {
        $this->enrollments = $enrollments;
    }

    public function index()
    {
        $enrollments = $this->enrollments->all();
        return view('enrollments.index', ['enrollments' => $enrollments]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            //
        ]);

        $this->enrollments->create($validated);
        return redirect('/enrollments');
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            //
        ]);

        $this->enrollments->update($enrollment, $validated);
        return redirect('/enrollments');
    }

    public function destroy(Enrollment $enrollment)
    {
        $this->enrollments->delete($enrollment);
        return redirect('/enrollments');
    }
}