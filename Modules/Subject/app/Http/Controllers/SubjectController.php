<?php

namespace Modules\Subject\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Subject\Http\Requests\SubjectRequest;
use Modules\Subject\Repositories\Contracts\SubjectRepositoryInterface;

class SubjectController extends Controller
{
    protected SubjectRepositoryInterface $subjects;

    public function __construct(SubjectRepositoryInterface $subjects)
    {
        $this->subjects = $subjects;
    }

    // List all subjects, plus the create form on the same page
    public function index()
    {
        $subjects = $this->subjects->all();

        return view('subject::index', [
            'subjects' => $subjects,
        ]);
    }

    // Create — validation now handled by SubjectRequest instead of inline rules
    public function store(SubjectRequest $request)
    {
        $this->subjects->create($request->validated());

        return redirect('/subjects');
    }

    // Show edit form for one subject
    public function edit(int $subject)
    {
        return view('subject::edit', [
            'subject' => $this->subjects->find($subject),
        ]);
    }

    // Update — SubjectRequest reused; its unique rule ignores this $subject's own id
    public function update(SubjectRequest $request, int $subject)
    {
        $this->subjects->update($subject, $request->validated());

        return redirect('/subjects');
    }

    // Delete
    public function destroy(int $subject)
    {
        $this->subjects->delete($subject);

        return redirect('/subjects');
    }
}