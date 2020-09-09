<?php

declare(strict_types=1);

namespace Arcanedev\LaravelActive\Tests;

/**
 * Class     ActiveTest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ActiveTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\LaravelActive\Contracts\Active */
    protected $active;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->active = $this->app->make(\Arcanedev\LaravelActive\Contracts\Active::class);
    }

    protected function tearDown(): void
    {
        unset($this->active);

        parent::tearDown();
    }

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
            static::assertInstanceOf($expected, $this->active);
        }
    }

    /** @test */
    public function it_can_check_if_current_request_is_active(): void
    {
        $this->get('foo');

        static::assertTrue($this->active->is(['foo']));
        static::assertTrue($this->active->isPath(['foo']));
        static::assertFalse($this->active->isRoute(['foo']));
    }

    /** @test */
    public function it_can_check_if_current_request_is_active_with_string_value(): void
    {
        $this->get('foo');

        static::assertTrue($this->active->is('foo'));
        static::assertTrue($this->active->isPath('foo'));
        static::assertFalse($this->active->isRoute('foo'));
    }

    /** @test */
    public function it_can_check_if_current_route_is_active(): void
    {
        $this->get(route('home'));

        static::assertTrue($this->active->is(['home']));
        static::assertTrue($this->active->isRoute(['home']));
        static::assertFalse($this->active->isPath(['home']));
    }

    /** @test */
    public function it_can_check_if_current_path_is_active_with_ignored_ones(): void
    {
        $expectations = [
            'foo'     => false,
            'foo/qux' => false,
            'foo/bar' => true,
        ];

        foreach ($expectations as $uri => $expected) {
            $this->call('GET', $uri);

            static::assertSame($expected, $this->active->is(['foo/*', 'not:foo/qux']));
            static::assertFalse($this->active->isRoute(['foo/*']));
        }
    }

    /** @test */
    public function it_can_check_if_current_route_is_active_with_ignored_ones(): void
    {
        $expectations = [
            'pages.index'  => true,
            'pages.create' => true,
            'pages.show'   => false,
        ];

        foreach ($expectations as $route => $expected) {
            $this->get(route($route));

            static::assertSame($expected, $this->active->is(['pages.*', 'not:pages.show']));
        }
    }

    /** @test */
    public function it_can_get_active_class_when_it_matches_with_path(): void
    {
        static::assertNull($this->active->active(['blog']));
        static::assertNull($this->active->path(['blog']));

        $this->get('blog');

        static::assertSame('active', $this->active->active(['blog']));
        static::assertSame('is-active', $this->active->active(['blog'], 'is-active'));

        static::assertSame('active', $this->active->path(['blog']));
        static::assertSame('is-active', $this->active->path(['blog'], 'is-active'));
    }

    /** @test */
    public function it_can_get_active_class_when_it_matches_with_route(): void
    {
        static::assertNull($this->active->active(['home']));
        static::assertNull($this->active->route(['home']));

        $this->get(route('home'));

        static::assertSame('active', $this->active->active(['home']));
        static::assertSame('is-active', $this->active->active(['home'], 'is-active'));

        static::assertSame('active', $this->active->route(['home']));
        static::assertSame('is-active', $this->active->route(['home'], 'is-active'));
    }

    /** @test */
    public function it_must_return_false_when_the_given_route_or_path_not_active(): void
    {
        static::assertFalse($this->active->is(['404']));
        static::assertFalse($this->active->isRoute(['404']));
        static::assertFalse($this->active->isPath(['404']));
    }

    /** @test */
    public function it_can_fallback_with_custom_inactive_class(): void
    {
        static::assertSame('inactive', $this->active->active('blog', 'active', 'inactive'));
        static::assertSame('inactive', $this->active->route('blog', 'active', 'inactive'));
        static::assertSame('inactive', $this->active->path('blog', 'active', 'inactive'));
    }

    /** @test */
    public function it_can_fallback_with_custom_inactive_class_with_setter(): void
    {
        static::assertNull($this->active->active('blog'));
        static::assertNull($this->active->route('blog'));
        static::assertNull($this->active->path('blog'));

        $this->active->setFallbackClass('inactive');

        static::assertSame('inactive', $this->active->active('blog'));
        static::assertSame('inactive', $this->active->route('blog'));
        static::assertSame('inactive', $this->active->path('blog'));
    }

    /** @test */
    public function it_can_set_request_instance(): void
    {
        $request = (new \Illuminate\Http\Request)
            ->createFromBase(\Symfony\Component\HttpFoundation\Request::create('current-request', 'GET'));

        $this->active->setRequest($request);

        static::assertTrue($this->active->is(['current-request']));
    }
}
