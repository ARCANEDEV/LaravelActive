<?php declare(strict_types=1);

namespace Arcanedev\LaravelActive\Tests;

use Illuminate\Contracts\Routing\Registrar;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class     TestCase
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TestCase extends BaseTestCase
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /** {@inheritDoc} */
    protected function getPackageProviders($app): array
    {
        return [
            \Arcanedev\LaravelActive\LaravelActiveServiceProvider::class,
        ];
    }

    /** {@inheritDoc} */
    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $this->setUpRoutes($app['router']);
    }

    /**
     * Setup the routes.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    private function setUpRoutes(Registrar $router): void
    {
        $router->get('/', function () { return 'Homepage'; })
               ->name('home');

        $router->get('/pages', function () { return 'Page: index'; })
               ->name('pages.index');

        $router->get('/pages/create', function () { return 'Page: create'; })
               ->name('pages.create');

        $router->get('/pages/show', function () { return 'Page: show'; })
               ->name('pages.show');
    }
}
