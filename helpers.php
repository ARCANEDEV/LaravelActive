<?php

declare(strict_types=1);

use Arcanedev\LaravelActive\Contracts\Active;

if ( ! function_exists('active')) {
    /**
     * Get the active class if the current route/path matches with the haystack.
     *
     * @param  string|array  $routes
     * @param  string|null   $class
     * @param  string|null   $fallback
     *
     * @return \Arcanedev\LaravelActive\Contracts\Active|string|null
     */
    function active($routes = [], $class = null, $fallback = null)
    {
        /** @var  \Arcanedev\LaravelActive\Contracts\Active  $active */
        $active = app(Active::class);

        if (empty($routes)) {
            return $active;
        }

        return $active->active($routes, $class, $fallback);
    }
}

if ( ! function_exists('is_active')) {
    /**
     * Check if any of the given routes are active.
     *
     * @param  array|string  $routes
     *
     * @return bool
     */
    function is_active($routes): bool
    {
        return active()->is($routes);
    }
}
