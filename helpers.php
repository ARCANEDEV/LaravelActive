<?php

if ( ! function_exists('is_active')) {
    /**
     * Check if any of the given routes are active.
     *
     * @param  array  $routes
     *
     * @return bool
     */
    function is_active(array $routes)
    {
        return active()->isActive($routes);
    }
}

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
        $active = app(Arcanedev\LaravelActive\Contracts\Active::class);

        return empty($routes)
            ? $active
            : $active->active($routes, $class, $fallback);
    }
}
