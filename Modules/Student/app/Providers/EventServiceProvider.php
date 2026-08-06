<?php

namespace Modules\Student\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Student\Events\StudentCreated;

/**
 * Class EventServiceProvider
 *
 * Registers domain event mapping and asynchronous listeners for the Student module.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event-to-listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        StudentCreated::class => [
            // Example queued listener for email notifications:
            // \Modules\Student\Listeners\SendStudentWelcomeNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}