<?php declare(strict_types=1);

namespace Arcanedev\LaravelActive;

use Arcanedev\LaravelActive\Contracts\Active as ActiveContract;
use Illuminate\Support\{Arr, Collection, Str};
use Illuminate\Http\Request;

/**
 * Class     Active
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Active implements ActiveContract
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    protected string $activeClass;

    protected ?string $fallbackClass;

    protected ?Request $request;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Active constructor.
     */
    public function __construct(array $options)
    {
        $this->setActiveClass(Arr::get($options, 'class', 'active'));
        $this->setFallbackClass(Arr::get($options, 'fallback-class'));
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the `active` CSS class.
     */
    public function getActiveClass(): string
    {
        return $this->activeClass;
    }

    /**
     * Set the `active` CSS class.
     */
    public function setActiveClass(string $class): static
    {
        $this->activeClass = $class;

        return $this;
    }

    /**
     * Get the fallback (inactive) class.
     */
    public function getFallbackClass(): ?string
    {
        return $this->fallbackClass;
    }

    /**
     * Set the fallback (inactive) class.
     */
    public function setFallbackClass(?string $class): static
    {
        $this->fallbackClass = $class;

        return $this;
    }

    /**
     * Get the request.
     */
    public function getRequest(): Request
    {
        return $this->request ?? app('request');
    }

    /**
     * Set the request.
     */
    public function setRequest(Request $request): static
    {
        $this->request = $request;

        return $this;
    }

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
    public function active($routes, $class = null, $fallback = null)
    {
        return $this->getCssClass(
            $this->is($routes),
            $class,
            $fallback
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
            $this->isRoute($routes),
            $class,
            $fallback
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
            $this->isPath($routes),
            $class,
            $fallback
        );
    }

    /**
     * Check if any given routes/paths are active.
     *
     * @param  string|array  $routes
     *
     * @return bool
     */
    public function is($routes): bool
    {
        return $this->isPath($routes)
            || $this->isRoute($routes);
    }

    /**
     * Check if the current route is one of the given routes.
     *
     * @param  string|array  $routes
     *
     * @return bool
     */
    public function isRoute($routes): bool
    {
        list($patterns, $ignored) = $this->parseRoutes(Arr::wrap($routes));

        if ($this->isIgnored($ignored)) {
            return false;
        }

        return $this->getRequest()->routeIs($patterns);
    }

    /**
     * Check if the current path is active.
     *
     * @param  string|array  $routes
     *
     * @return bool
     */
    public function isPath($routes): bool
    {
        list($routes, $ignored) = $this->parseRoutes(Arr::wrap($routes));

        if ($this->isIgnored($ignored)) {
            return false;
        }

        return with($this->getRequest(), function (Request $request) use ($routes) {
            return $request->is($routes)
                || $request->fullUrlIs($routes);
        });
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the css class based on the given active state.
     */
    protected function getCssClass(bool $isActive, ?string $class = null, ?string $fallback = null): ?string
    {
        return $isActive
            ? ($class ?: $this->getActiveClass())
            : ($fallback ?: $this->getFallbackClass());
    }

    /**
     * Check if the given routes/paths are ignored.
     */
    protected function isIgnored(array $ignored): bool
    {
        return count($ignored)
            && ($this->isPath($ignored) || $this->isRoute($ignored));
    }

    /**
     * Separate ignored routes from the whitelist routes.
     */
    protected function parseRoutes(array $allRoutes): array
    {
        return Collection::make($allRoutes)
            ->partition(function ($route) {
                return ! Str::startsWith($route, ['not:']);
            })
            ->transform(function (Collection $routes, $index) {
                if ($index === 0) {
                    return $routes;
                }

                return $routes->transform(function ($route) {
                    return substr($route, 4);
                });
            })
            ->toArray()
        ;
    }
}
