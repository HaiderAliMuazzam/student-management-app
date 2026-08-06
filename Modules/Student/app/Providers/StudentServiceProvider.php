<?php

namespace Modules\Student\Providers;

use Modules\Student\Repositories\Contracts\StudentRepositoryInterface;
use Modules\Student\Repositories\StudentRepository;
use Nwidart\Modules\Support\ModuleServiceProvider;

/**
 * Class StudentServiceProvider
 *
 * Bootstraps module resources, sub-providers, and registers container dependency 
 * bindings for the Student domain (maps StudentRepositoryInterface to StudentRepository).
 */
class StudentServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Student';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'student';

    /**
     * Sub-providers to automatically register for this module.
     *
     * @var array<int, string>
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Register application services, container bindings, and sub-providers.
     *
     * @return void
     */
    public function register(): void
    {
        parent::register();

        // Bind StudentRepositoryInterface contract to concrete StudentRepository implementation
        $this->app->bind(
            StudentRepositoryInterface::class,
            StudentRepository::class
        );
    }

    /**
     * Bootstrap module translation and view resources.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // Register module translations under the 'student' namespace
        $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
    }
}