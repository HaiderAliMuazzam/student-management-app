<?php

namespace Modules\Announcement\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Modules\Announcement\Repositories\AnnouncementRepository;
use Modules\Announcement\Repositories\Contracts\AnnouncementRepositoryInterface;
use Nwidart\Modules\Support\ModuleServiceProvider;

class AnnouncementServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     *
     * Why?
     * The package uses this name internally to identify the module.
     */
    protected string $name = 'Announcement';

    /**
     * The lowercase version of the module name.
     *
     * Why?
     * Used by the module package when generating paths,
     * configuration, and other module-related resources.
     */
    protected string $nameLower = 'announcement';

    /**
     * Other service providers that belong to this module.
     *
     * Why?
     * Splitting responsibilities into multiple providers keeps the
     * project organized. For example:
     * - EventServiceProvider registers events and listeners.
     * - RouteServiceProvider registers the module's routes.
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Register services in Laravel's Service Container.
     *
     * Why?
     * This method is executed when the application boots.
     * Here we bind interfaces to their concrete implementations.
     *
     * Now, whenever Laravel sees:
     *
     *     AnnouncementRepositoryInterface
     *
     * it will automatically create and inject:
     *
     *     AnnouncementRepository
     *
     * This follows the Dependency Inversion Principle (SOLID)
     * and makes the code easier to maintain and test.
     * Our class extends ModuleServiceProvider, which already
     * has its own register() method.
     */
    public function register(): void
    {
        parent::register();

        $this->app->bind(
            AnnouncementRepositoryInterface::class,
            AnnouncementRepository::class
        );
    }

    /**
     * Define module schedules.
     *
     * Why?
     * If this module ever needs scheduled tasks
     * (e.g., archive old announcements), they can be
     * defined here.
     */
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();
    // }
}