<?php

namespace Modules\Announcement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Announcement\Http\Requests\AnnouncementRequest;
use Modules\Announcement\Repositories\Contracts\AnnouncementRepositoryInterface;

class AnnouncementController extends Controller
{
    /**
     * Repository instance.
     *
     * Why?
     * The controller should not communicate directly with the database.
     * Instead, it delegates all data access to the repository.
     */
    protected AnnouncementRepositoryInterface $announcementRepository;

    /**
     * Constructor.
     *
     * Why use Dependency Injection?
     * -----------------------------
     * Laravel's Service Container automatically provides an instance of
     * AnnouncementRepository because we bound the interface to its
     * implementation in AnnouncementServiceProvider.
     */
    public function __construct(AnnouncementRepositoryInterface $announcementRepository)
    {
        $this->announcementRepository = $announcementRepository;
    }

    /**
     * Display all announcements.
     */
    public function index(): View
    {
        $announcements = $this->announcementRepository->all();

        return view('announcement::index', compact('announcements'));
    }

    /**
     * Store a newly created announcement.
     *
     * Why AnnouncementRequest instead of inline validate()?
     * -------------------------------------------------------
     * Validation is now handled automatically before this method runs.
     */
    public function store(AnnouncementRequest $request): RedirectResponse
    {
        $this->announcementRepository->create($request->validated());

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    /**
     * Show the edit form for one announcement.
     */
    public function edit(int $announcement): View
    {
        return view('announcement::edit', [
            'announcement' => $this->announcementRepository->find($announcement),
        ]);
    }

    /**
     * Update an existing announcement.
     *
     * Why reuse AnnouncementRequest?
     * -------------------------------
     * Same validation rules apply for create and update — no duplication.
     */
    public function update(AnnouncementRequest $request, int $announcement): RedirectResponse
    {
        $this->announcementRepository->update($announcement, $request->validated());

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Delete an announcement.
     */
    public function destroy(int $announcement): RedirectResponse
    {
        $this->announcementRepository->delete($announcement);

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}