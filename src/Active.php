<?php namespace Arcanedev\LaravelActive;

use Arcanedev\LaravelActive\Contracts\Active as ActiveContract;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;
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
     * @var \Illuminate\Contracts\Config\Repository
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

    /**
     * Get the fallback (inactive) class.
     *
     * @param  string|null  $fallback
     *
     * @return string|null
     */
    protected function getFallbackClass($fallback = null)
    {
        return $fallback ?: $this->config->get('active.fallback-class');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if any given routes/paths are active.
     *
     * @param  string|array  $routes
     *
     * @return bool
     */
    public function isActive($routes)
    {
        return $this->isPath($routes)
            || $this->isRoute($routes);
    }

    /**
     * Get the active class if the current path/route is active.
     *
     * @param  string|array  $routes
     * @param  string|null   $class
     * @param  string|null   $fallback
     *
     * @return string|null
     */
    public function active($routes, $class = null, $fallback = null)
    {
        return $this->getCssClass(
            $this->isActive($routes), $class, $fallback
        );
    }

    /**
     * Get the active class if the current route is in haystack routes.
     *
     * @param  string|array  $routes
     * @param  string|null   $class
     * @param  string|null   $fallback
     *
     * @return string|null
     */
    public function route($routes, $class = null, $fallback = null)
    {
        return $this->getCssClass(
            $this->isRoute($routes), $class, $fallback
        );
    }

    /**
     * Get the active class if the current path is in haystack paths.
     *
     * @param  string|array  $routes
     * @param  string|null   $class
     * @param  string|null   $fallback
     *
     * @return string|null
     */
    public function path($routes, $class = null, $fallback = null)
    {
        return $this->getCssClass(
            $this->isPath($routes), $class, $fallback
        );
    }

    /**
     * Check if the current route is one of the given routes.
     *
     * @param  string|array  $routes
     *
     * @return bool
     */
    public function isRoute($routes)
    {
        return $this->is(app('router'), $routes);
    }

    /**
     * Check if the current path is active.
     *
     * @param  string|array  $routes
     *
     * @return bool
     */
    public function isPath($routes)
    {
        return $this->is(app('request'), $routes);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the css class based on the given condition.
     *
     * @param  bool         $condition
     * @param  string|null  $class
     * @param  string|null  $fallback
     *
     * @return string|null
     */
    protected function getCssClass($condition, $class, $fallback)
    {
        return $condition
            ? $this->getActiveClass($class)
            : $this->getFallbackClass($fallback);
    }

    /**
     * Check if one the given routes is active.
     *
     * @param  mixed         $object
     * @param  string|array  $routes
     *
     * @return bool
     */
    protected function is($object, $routes)
    {
        list($routes, $ignored) = $this->parseRoutes(Arr::wrap($routes));

        return $this->isIgnored($ignored)
            ? false
            : call_user_func_array([$object, 'is'], $routes);
    }

    /**
     * Check if the given routes/paths are ignored.
     *
     * @param  array  $ignored
     *
     * @return bool
     */
    protected function isIgnored(array $ignored)
    {
        return count($ignored)
            && ($this->isPath($ignored) || $this->isRoute($ignored));
    }

    /**
     * Separate ignored routes from the whitelist routes.
     *
     * @param  array  $allRoutes
     *
     * @return array
     */
    protected function parseRoutes(array $allRoutes)
    {
        return Collection::make($allRoutes)
            ->partition(function ($route) {
                return ! Str::startsWith($route, ['not:']);
            })
            ->transform(function (Collection $routes, $index) {
                return $index === 0
                    ? $routes
                    : $routes->transform(function ($route) { return substr($route, 4); });
            })
            ->toArray();
    }
}
