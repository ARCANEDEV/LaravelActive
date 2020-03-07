<?php

declare(strict_types=1);

namespace Arcanedev\LaravelActive;

use Arcanedev\LaravelActive\Contracts\Active as ActiveContract;
use Arcanedev\Support\Providers\PackageServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class     LaravelActiveServiceProvider
 *
 * @package  Arcanedev\LaravelActive
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LaravelActiveServiceProvider extends PackageServiceProvider implements DeferrableProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'active';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        $this->registerConfig();

        $this->singleton(ActiveContract::class, function ($app) {
            $options = $app['config']->get('active', []);

            return new Active($options);
        });
    }

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfig();
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            ActiveContract::class,
        ];
    }
}
