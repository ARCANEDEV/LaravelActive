<?php namespace Arcanedev\LaravelActive\Tests;

/**
 * Class     ActiveTest
 *
 * @package  Arcanedev\LaravelActive\Tests
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

    protected function setUp()
    {
        parent::setUp();

        $this->active = $this->app->make(\Arcanedev\LaravelActive\Contracts\Active::class);
    }

    protected function tearDown()
    {
        unset($this->active);

        parent::tearDown();
    }

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
            static::assertInstanceOf($expected, $this->active);
        }
    }

    /** @test */
    public function it_can_check_if_current_request_is_active()
    {
        $this->get('foo');

        static::assertTrue($this->active->isActive(['foo']));
        static::assertTrue($this->active->isPath(['foo']));
        static::assertFalse($this->active->isRoute(['foo']));
    }

    /** @test */
    public function it_can_check_if_current_route_is_active()
    {
        $this->get(route('home'));

        static::assertTrue($this->active->isActive(['home']));
        static::assertTrue($this->active->isRoute(['home']));
        static::assertFalse($this->active->isPath(['home']));
    }

    /** @test */
    public function it_can_check_if_current_path_is_active_with_ignored_ones()
    {
        $expectations = [
            'foo'     => false,
            'foo/qux' => false,
            'foo/bar' => true,
        ];

        foreach ($expectations as $uri => $expected) {
            $this->call('GET', $uri);

            static::assertSame($expected, $this->active->isActive(['foo/*', 'not:foo/qux']));
            static::assertFalse($this->active->isRoute(['foo/*']));
        }
    }

    /** @test */
    public function it_can_check_if_current_route_is_active_with_ignored_ones()
    {
        $expectations = [
            'pages.index'  => true,
            'pages.create' => true,
            'pages.show'   => false,
        ];

        foreach ($expectations as $route => $expected) {
            $this->get(route($route));

            static::assertSame($expected, $this->active->isActive(['pages.*', 'not:pages.show']));
        }
    }

    /** @test */
    public function it_can_get_active_class_when_it_matches_with_path()
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
    public function it_can_get_active_class_when_it_matches_with_route()
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
    public function it_must_return_false_when_the_given_route_or_path_not_active()
    {
        static::assertFalse($this->active->isActive(['404']));
        static::assertFalse($this->active->isRoute(['404']));
        static::assertFalse($this->active->isPath(['404']));
    }
}
