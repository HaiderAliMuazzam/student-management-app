<?php

namespace Modules\Attendance\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Modules\Attendance\Repositories\AttendanceRepository;
use Modules\Attendance\Repositories\Contracts\AttendanceRepositoryInterface;
use Nwidart\Modules\Support\ModuleServiceProvider;

class AttendanceServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Attendance';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'attendance';

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Register services for the module.
     *
     * Why?
     * Bind the repository interface to its implementation so
     * Laravel can resolve it using dependency injection.
     */
    public function register(): void
    {
        parent::register();

        $this->app->bind(
            AttendanceRepositoryInterface::class,
            AttendanceRepository::class
        );
    }

    /**
     * Define module schedules.
     *
     * @param Schedule $schedule
     */
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();
    // }
}