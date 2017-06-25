<?php namespace Arcanedev\LaravelActive\Contracts;

/**
 * Interface     Active
 *
 * @package  Arcanedev\LaravelActive\Contracts
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Active
{
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
    public function isActive(array $routes);

    /**
     * Get the active class if the current path/route is active.
     *
     * @param  array        $routes
     * @param  string|null  $class
     *
     * @return string|null
     */
    public function active(array $routes, $class = null);

    /**
     * Check if the current route is one of the given routes.
     *
     * @param  array  $routes
     *
     * @return bool
     */
    public function isRoute(array $routes);

    /**
     * Check if the current path is active.
     *
     * @param  array  $routes
     *
     * @return bool
     */
    public function isPath(array $routes);

    /**
     * Get the active class if the current route is in haystack routes.
     *
     * @param  array        $routes
     * @param  string|null  $class
     *
     * @return string|null
     */
    public function route(array $routes, $class = null);

    /**
     * Get the active class if the current path is in haystack paths.
     *
     * @param  array        $routes
     * @param  string|null  $class
     *
     * @return string|null
     */
    public function path(array $routes, $class = null);
}
