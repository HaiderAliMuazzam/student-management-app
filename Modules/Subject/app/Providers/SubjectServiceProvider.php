<?php
// File: Modules/Subject/app/Providers/SubjectServiceProvider.php

namespace Modules\Subject\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Subject\Repositories\Contracts\SubjectRepositoryInterface;
use Modules\Subject\Repositories\SubjectRepository;

class SubjectServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Subject';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'subject';

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
     * Tells Laravel: "whenever something asks for SubjectRepositoryInterface,
     * give it a SubjectRepository." Same pattern as Finance module.
     */
    public function register(): void
    {
        parent::register();

        $this->app->bind(
            SubjectRepositoryInterface::class,
            SubjectRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Explicitly register module translations under the 'subject' namespace,
        // since parent auto-registration wasn't resolving 'subject::' keys (same fix as Student).
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