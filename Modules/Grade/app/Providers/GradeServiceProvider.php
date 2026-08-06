<?php
// File: Modules/Grade/app/Providers/GradeServiceProvider.php

namespace Modules\Grade\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Grade\Repositories\Contracts\GradeRepositoryInterface;
use Modules\Grade\Repositories\GradeRepository;

class GradeServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Grade';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'grade';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

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
     * Register any application services.
     * Tells Laravel: "whenever something asks for GradeRepositoryInterface,
     * give it a GradeRepository." Same pattern as Subject module.
     */
    public function register(): void
    {
        parent::register();

        $this->app->bind(
            GradeRepositoryInterface::class,
            GradeRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Explicitly register module translations under the 'grade' namespace,
        // since parent auto-registration wasn't resolving 'grade::' keys (same fix as Student/Subject).
        $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
    }

    /**
     * Define module schedules.
     * 
     * @param $schedule
     */
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();
    // }
}