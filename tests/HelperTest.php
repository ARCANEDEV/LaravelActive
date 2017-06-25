<?php namespace Arcanedev\LaravelActive\Tests;

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
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Arcanedev\LaravelActive\Contracts\Active::class,
            \Arcanedev\LaravelActive\Active::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, active());
        }
    }

    /** @test */
    public function it_can_check_if_current_request_is_active()
    {
        $this->call('GET', 'foo');

        $this->assertTrue(active()->isActive(['foo']));
        $this->assertTrue(active()->isPath(['foo']));
        $this->assertFalse(active()->isRoute(['foo']));
    }

    /** @test */
    public function it_can_check_if_current_route_is_active()
    {
        $this->route('GET', 'home');

        $this->assertTrue(active()->isActive(['home']));
        $this->assertTrue(active()->isRoute(['home']));
        $this->assertFalse(active()->isPath(['home']));
    }

    /** @test */
    public function it_can_check_if_current_path_is_active_with_ignored_ones()
    {
        $paths        = ['foo/*', 'not:foo/qux'];
        $expectations = [
            'foo'     => false,
            'foo/qux' => false,
            'foo/bar' => true,
        ];

        foreach ($expectations as $uri => $expected) {
            $this->call('GET', $uri);

            $this->assertSame($expected, active()->isActive($paths));
            $this->assertSame($expected, is_active($paths));
            $this->assertSame($expected, active()->isPath($paths));

            $this->assertFalse(active()->isRoute($paths));
        }
    }

    /** @test */
    public function it_can_check_if_current_route_is_active_with_ignored_ones()
    {
        $routes       = ['pages.*', 'not:pages.show'];
        $expectations = [
            'pages.index'  => true,
            'pages.create' => true,
            'pages.show'   => false,
        ];

        foreach ($expectations as $route => $expected) {
            $this->route('GET', $route);

            $this->assertSame($expected, active()->isActive($routes));
            $this->assertSame($expected, is_active($routes));
            $this->assertSame($expected, active()->isRoute($routes));

            $this->assertFalse(active()->isPath($routes));
        }
    }

    /** @test */
    public function it_can_get_active_class_when_it_matches_with_path()
    {
        $this->assertNull(active()->active(['blog']));
        $this->assertNull(active()->path(['blog']));
        $this->assertNull(active(['blog']));

        $this->call('GET', 'blog');

        $this->assertSame('active', active()->active(['blog']));
        $this->assertSame('is-active', active()->active(['blog'], 'is-active'));

        $this->assertSame('active', active(['blog']));
        $this->assertSame('is-active', active(['blog'], 'is-active'));

        $this->assertSame('active', active()->path(['blog']));
        $this->assertSame('is-active', active()->path(['blog'], 'is-active'));
    }

    /** @test */
    public function it_can_get_active_class_when_it_matches_with_route()
    {
        $this->assertNull(active()->active(['home']));
        $this->assertNull(active()->route(['home']));
        $this->assertNull(active(['home']));

        $this->route('GET', 'home');

        $this->assertSame('active', active()->active(['home']));
        $this->assertSame('is-active', active()->active(['home'], 'is-active'));

        $this->assertSame('active', active(['home']));
        $this->assertSame('is-active', active(['home'], 'is-active'));

        $this->assertSame('active', active()->route(['home']));
        $this->assertSame('is-active', active()->route(['home'], 'is-active'));
    }

    /** @test */
    public function it_must_return_false_when_the_given_route_or_path_not_active()
    {
        $this->assertFalse(active()->isActive(['404']));
        $this->assertFalse(is_active(['404']));
        $this->assertFalse(active()->isRoute(['404']));
        $this->assertFalse(active()->isPath(['404']));
    }
}
