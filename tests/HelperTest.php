<?php

declare(strict_types=1);

namespace Arcanedev\LaravelActive\Tests;

/**
 * Class     HelperTest
 *
 * @package  Arcanedev\LaravelActive\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HelperTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated(): void
    {
        $expectations = [
            \Arcanedev\LaravelActive\Contracts\Active::class,
            \Arcanedev\LaravelActive\Active::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, active());
        }
    }

    /** @test */
    public function it_can_check_if_current_request_is_active(): void
    {
        $this->get('foo');

        static::assertTrue(active()->is(['foo']));
        static::assertTrue(active()->isPath(['foo']));
        static::assertFalse(active()->isRoute(['foo']));
    }

    /** @test */
    public function it_can_check_if_current_request_is_active_with_string_value(): void
    {
        $this->get('foo');

        static::assertTrue(active()->is('foo'));
        static::assertTrue(active()->isPath('foo'));
        static::assertFalse(active()->isRoute('foo'));
    }

    /** @test */
    public function it_can_check_if_current_route_is_active(): void
    {
        $this->get(route('home'));

        static::assertTrue(active()->is(['home']));
        static::assertTrue(active()->isRoute(['home']));
        static::assertFalse(active()->isPath(['home']));
    }

    /** @test */
    public function it_can_check_if_current_path_is_active_with_ignored_ones(): void
    {
        $paths        = ['foo/*', 'not:foo/qux'];
        $expectations = [
            'foo'     => false,
            'foo/qux' => false,
            'foo/bar' => true,
        ];

        foreach ($expectations as $uri => $expected) {
            $this->get($uri);

            static::assertSame($expected, active()->is($paths));
            static::assertSame($expected, is_active($paths));
            static::assertSame($expected, active()->isPath($paths));

            static::assertFalse(active()->isRoute($paths));
        }
    }

    /** @test */
    public function it_can_check_if_current_route_is_active_with_ignored_ones(): void
    {
        $routes       = ['pages.*', 'not:pages.show'];
        $expectations = [
            'pages.index'  => true,
            'pages.create' => true,
            'pages.show'   => false,
        ];

        foreach ($expectations as $route => $expected) {
            $this->get(route($route));

            static::assertSame($expected, active()->is($routes));
            static::assertSame($expected, is_active($routes));
            static::assertSame($expected, active()->isRoute($routes));

            static::assertFalse(active()->isPath($routes));
        }
    }

    /** @test */
    public function it_can_get_active_class_when_it_matches_with_path(): void
    {
        static::assertNull(active()->active(['blog']));
        static::assertNull(active()->path(['blog']));
        static::assertNull(active(['blog']));

        $this->call('GET', 'blog');

        static::assertSame('active', active()->active(['blog']));
        static::assertSame('is-active', active()->active(['blog'], 'is-active'));

        static::assertSame('active', active(['blog']));
        static::assertSame('is-active', active(['blog'], 'is-active'));

        static::assertSame('active', active()->path(['blog']));
        static::assertSame('is-active', active()->path(['blog'], 'is-active'));
    }

    /** @test */
    public function it_can_get_active_class_when_it_matches_with_route(): void
    {
        static::assertNull(active()->active(['home']));
        static::assertNull(active()->route(['home']));
        static::assertNull(active(['home']));

        $this->get(route('home'));

        static::assertSame('active', active()->active(['home']));
        static::assertSame('is-active', active()->active(['home'], 'is-active'));

        static::assertSame('active', active(['home']));
        static::assertSame('is-active', active(['home'], 'is-active'));

        static::assertSame('active', active()->route(['home']));
        static::assertSame('is-active', active()->route(['home'], 'is-active'));
    }

    /** @test */
    public function it_must_return_false_when_the_given_route_or_path_not_active(): void
    {
        static::assertFalse(active()->is(['404']));
        static::assertFalse(is_active(['404']));
        static::assertFalse(active()->isRoute(['404']));
        static::assertFalse(active()->isPath(['404']));
    }

    /** @test */
    public function it_can_fallback_with_custom_inactive_class(): void
    {
        static::assertSame('inactive', active('blog', 'active', 'inactive'));
        static::assertSame('inactive', active()->route('blog', 'active', 'inactive'));
        static::assertSame('inactive', active()->path('blog', 'active', 'inactive'));
    }

    /** @test */
    public function it_can_fallback_with_custom_inactive_class_via_setter(): void
    {
        static::assertNull(active('blog'));
        static::assertNull(active()->route('blog'));
        static::assertNull(active()->path('blog'));

        $active = active()->setFallbackClass('inactive');

        static::assertSame('inactive', $active->active('blog'));
        static::assertSame('inactive', $active->route('blog'));
        static::assertSame('inactive', $active->path('blog'));
    }
}
