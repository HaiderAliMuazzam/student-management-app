<?php

namespace Modules\Announcement\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Announcement\Models\Announcement;
use Modules\Announcement\Repositories\Contracts\AnnouncementRepositoryInterface;

/**
 * Announcement Repository
 *
 * Why do we have this class?
 * --------------------------
 * This class is responsible for all database operations related to
 * announcements. Instead of writing database queries inside controllers,
 * we keep them here.
 *
 * This follows the Single Responsibility Principle (the "S" in SOLID):
 * - Controller -> handles HTTP requests and responses.
 * - Repository -> handles database interactions.
 *
 * It also implements the interface, allowing Laravel to inject this
 * class whenever the interface is requested.
 */
class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    /**
     * Retrieve all announcements.
     *
     * Why return a Collection?
     * ------------------------
     * Eloquent returns a Collection object, which provides many helpful
     * methods such as filter(), sortBy(), map(), and each().
     *
     * @return Collection<int, Announcement>
     */
    public function all(): Collection
    {
        return Announcement::latest()->get();
    }

    /**
     * Find a single announcement by id.
     *
     * Why findOrFail?
     * ----------------
     * Automatically returns a 404 if the id doesn't exist, instead of
     * silently returning null and causing errors further down.
     */
    public function find(int $id): Announcement
    {
        return Announcement::findOrFail($id);
    }

    /**
     * Create and store a new announcement.
     *
     * Why keep this here?
     * -------------------
     * The controller should not know how data is saved.
     * Its only job is to pass validated data to the repository.
     *
     * @param array $data
     * @return Announcement
     */
    public function create(array $data): Announcement
    {
        return Announcement::create($data);
    }

    /**
     * Update an existing announcement.
     *
     * Why fetch then update, instead of a single query?
     * ---------------------------------------------------
     * Returning the updated model lets the controller/tests inspect
     * the fresh state immediately after the update.
     *
     * @param int $id
     * @param array $data
     * @return Announcement
     */
    public function update(int $id, array $data): Announcement
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update($data);

        return $announcement;
    }

    /**
     * Delete an announcement.
     *
     * Why findOrFail before delete?
     * ------------------------------
     * Ensures a clear 404 if someone tries to delete a non-existent
     * announcement, rather than a silent no-op.
     */
    public function delete(int $id): void
    {
        Announcement::findOrFail($id)->delete();
    }
}