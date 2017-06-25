<?php namespace Arcanedev\LaravelActive;

use Arcanedev\LaravelActive\Contracts\Active as ActiveContract;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class     Active
 *
 * @package  Arcanedev\LaravelActive
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Active implements ActiveContract
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Illuminate Config instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Active constructor.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the active CSS class.
     *
     * @param  string|null  $class
     *
     * @return string
     */
    protected function getActiveClass($class = null)
    {
        return $class ?: $this->config->get('active.class', 'active');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if any given routes/paths are active.
     *
     * @param  array  $routes
     *
     * @return bool
     */
    public function isActive(array $routes)
    {
        return $this->isPath($routes) || $this->isRoute($routes);
    }

    /**
     * Get the active class if the current path/route is active.
     *
     * @param  array        $routes
     * @param  string|null  $class
     *
     * @return string|null
     */
    public function active(array $routes, $class = null)
    {
        return $this->isActive($routes) ? $this->getActiveClass($class) : null;
    }

    /**
     * Check if the current route is one of the given routes.
     *
     * @param  array  $routes
     *
     * @return bool
     */
    public function isRoute(array $routes)
    {
        return $this->is(app('router'), $routes);
    }

    /**
     * Check if the current path is active.
     *
     * @param  array  $routes
     *
     * @return bool
     */
    public function isPath(array $routes)
    {
        return $this->is(app('request'), $routes);
    }

    /**
     * Get the active class if the current route is in haystack routes.
     *
     * @param  array        $routes
     * @param  string|null  $class
     *
     * @return string|null
     */
    public function route(array $routes, $class = null)
    {
        return $this->isRoute($routes) ? $this->getActiveClass($class) : null;
    }

    /**
     * Get the active class if the current path is in haystack paths.
     *
     * @param  array        $routes
     * @param  string|null  $class
     *
     * @return string|null
     */
    public function path(array $routes, $class = null)
    {
        return $this->isPath($routes) ? $this->getActiveClass($class) : null;
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if one the given routes is active.
     *
     * @param  mixed  $object
     * @param  array  $routes
     *
     * @return bool
     */
    protected function is($object, array $routes)
    {
        list($routes, $ignored) = $this->parseRoutes($routes);

        return ! $this->isIgnored($ignored)
            ? call_user_func_array([$object, 'is'], $routes)
            : false;
    }

    /**
     * Check if the given routes/paths are ignored.
     *
     * @param  array  $ignored
     *
     * @return bool
     */
    private function isIgnored(array $ignored)
    {
        return count($ignored) && ($this->isPath($ignored) || $this->isRoute($ignored));
    }

    /**
     * Separate ignored routes from the whitelist routes.
     *
     * @param  array  $allRoutes
     *
     * @return array
     */
    private function parseRoutes(array $allRoutes)
    {
        return Collection::make($allRoutes)
            ->partition(function ($route) {
                return ! Str::startsWith($route, ['not:']);
            })
            ->transform(function (Collection $routes, $index) {
                return $index === 0 ? $routes : $routes->transform(function ($route) {
                    return substr($route, 4);
                });
            })
            ->toArray();
    }
}
