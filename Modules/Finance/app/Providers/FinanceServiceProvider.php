<?php

namespace Modules\Finance\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Finance\Repositories\Contracts\InvoiceRepositoryInterface;
use Modules\Finance\Repositories\InvoiceRepository;
use Modules\Finance\Repositories\Contracts\PaymentRepositoryInterface;
use Modules\Finance\Repositories\PaymentRepository;

class FinanceServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Finance';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'finance';

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
     * This is where we tell Laravel: "whenever something asks for
     * InvoiceRepositoryInterface, give it an InvoiceRepository."
     * Same pattern now applies to PaymentRepositoryInterface.
     */
    public function register(): void
    {
        parent::register();

        $this->app->bind(
            InvoiceRepositoryInterface::class,
            InvoiceRepository::class
        );

        $this->app->bind(
            PaymentRepositoryInterface::class,
            PaymentRepository::class
        );
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