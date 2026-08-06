<?php

namespace Modules\Announcement\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Modules\Announcement\Models\Announcement;

/**
 * Announcement Repository Interface
 *
 * Why do we use an interface?
 * ----------------------------
 * Instead of letting the controller communicate directly with the model,
 * we introduce an interface (contract). The controller only knows that
 * "someone" can perform announcement-related operations.
 *
 * This follows the Dependency Inversion Principle (the "D" in SOLID).
 * High-level classes (Controllers) should depend on abstractions
 * (interfaces), not concrete implementations.
 *
 * Benefits:
 * - Makes the code easier to maintain.
 * - Makes it easy to swap implementations later.
 * - Simplifies unit testing by allowing mock repositories.
 */
interface AnnouncementRepositoryInterface
{
    /**
     * Retrieve all announcements.
     *
     * Why?
     * Instead of writing Announcement::all() inside every controller,
     * we centralize the database logic in one place.
     *
     * @return Collection<int, Announcement>
     */
    public function all(): Collection;

    /**
     * Find a single announcement by id.
     *
     * Why?
     * Needed for the edit form — repository fetches it, controller stays DB-agnostic.
     */
    public function find(int $id): Announcement;

    /**
     * Store a new announcement.
     *
     * Why?
     * The controller passes validated data to the repository,
     * and the repository decides how it should be saved.
     *
     * @param array $data
     * @return Announcement
     */
    public function create(array $data): Announcement;

    /**
     * Update an existing announcement.
     *
     * Why?
     * Same reasoning as create() — repository owns the persistence logic.
     *
     * @param int $id
     * @param array $data
     * @return Announcement
     */
    public function update(int $id, array $data): Announcement;

    /**
     * Delete an announcement.
     *
     * Why?
     * Keeps deletion logic centralized, consistent with all(), create(), update().
     */
    public function delete(int $id): void;
}