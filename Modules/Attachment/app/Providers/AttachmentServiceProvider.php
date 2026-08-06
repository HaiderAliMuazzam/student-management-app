<?php

namespace Modules\Attachment\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Attachment\Repositories\Contracts\AttachmentRepositoryInterface;
use Modules\Attachment\Repositories\AttachmentRepository;

class AttachmentServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Attachment';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'attachment';

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
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        // Bind the repository interface to its concrete implementation
        $this->app->bind(AttachmentRepositoryInterface::class, AttachmentRepository::class);
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