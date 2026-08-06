<?php

namespace Modules\Grade\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Grade\Http\Requests\GradeRequest;
use Modules\Grade\Repositories\Contracts\GradeRepositoryInterface;

class GradeController extends Controller
{
    protected GradeRepositoryInterface $grades;

    public function __construct(GradeRepositoryInterface $grades)
    {
        $this->grades = $grades;
    }

    // List all grades
    public function index()
    {
        $grades = $this->grades->all();

        return view('grade::index', [
            'grades' => $grades,
        ]);
    }

    // Create — validation now handled by GradeRequest instead of inline rules
    public function store(GradeRequest $request)
    {
        $this->grades->create($request->validated());

        return redirect('/grades');
    }

    // Show edit form for one grade — $grade is the route-model id (int, since repo uses findOrFail)
    public function edit(int $grade)
    {
        return view('grade::edit', [
            'grade' => $this->grades->find($grade),
        ]);
    }

    // Update — GradeRequest reused here; its unique rule ignores this $grade's own id
    public function update(GradeRequest $request, int $grade)
    {
        $this->grades->update($grade, $request->validated());

        return redirect('/grades');
    }

    // Delete
    public function destroy(int $grade)
    {
        $this->grades->delete($grade);

        return redirect('/grades');
    }
}