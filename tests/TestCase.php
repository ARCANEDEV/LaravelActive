<?php namespace Arcanedev\LaravelActive\Tests;

use Orchestra\Testbench\BrowserKit\TestCase as BaseTestCase;

/**
 * Class     TestCase
 *
 * @package  Arcanedev\LaravelActive\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TestCase extends BaseTestCase
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function getPackageProviders($app)
    {
        return [
            \Arcanedev\LaravelActive\LaravelActiveServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            \Arcanedev\LaravelActive\Facades\Active::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $this->setUpRoutes($app['router']);
    }

    /**
     * Setup the routes.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    private function setUpRoutes($router)
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
