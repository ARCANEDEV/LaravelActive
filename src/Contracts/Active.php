<?php

declare(strict_types=1);

namespace Arcanedev\LaravelActive\Contracts;

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
     * Get the active class if the current path/route is active.
     *
     * @param  string|array  $routes
     * @param  string|null   $class
     * @param  string|null   $fallback
     *
     * @return string|null
     */
    public function active($routes, $class = null, $fallback = null);

    /**
     * Get the active class if the current route is in haystack routes.
     *
     * @param  string|array  $routes
     * @param  string|null   $class
     * @param  string|null   $fallback
     *
     * @return string|null
     */
    public function route($routes, $class = null, $fallback = null);

    /**
     * Get the active class if the current path is in haystack paths.
     *
     * @param  string|array  $routes
     * @param  string|null   $class
     * @param  string|null   $fallback
     *
     * @return string|null
     */
    public function path($routes, $class = null, $fallback = null);

    /**
     * Check if any given routes/paths are active.
     *
     * @param  string|array  $routes
     *
     * @return bool
     */
    public function isActive($routes);

    /**
     * Check if the current route is one of the given routes.
     *
     * @param  string|array  $routes
     *
     * @return bool
     */
    public function isRoute($routes);

    /**
     * Check if the current path is active.
     *
     * @param  string|array  $routes
     *
     * @return bool
     */
    public function isPath($routes);
}
