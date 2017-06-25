<?php namespace Arcanedev\LaravelActive\Tests;

use Arcanedev\LaravelActive\Active;

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
            $this->assertInstanceOf($expected, $this->active);
        }
    }

    /** @test */
    public function it_can_check_if_current_request_is_active()
    {
        $this->call('GET', 'foo');

        $this->assertTrue($this->active->isActive(['foo']));
        $this->assertTrue($this->active->isPath(['foo']));
        $this->assertFalse($this->active->isRoute(['foo']));
    }

    /** @test */
    public function it_can_check_if_current_route_is_active()
    {
        $this->route('GET', 'home');

        $this->assertTrue($this->active->isActive(['home']));
        $this->assertTrue($this->active->isRoute(['home']));
        $this->assertFalse($this->active->isPath(['home']));
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

            $this->assertSame($expected, $this->active->isActive(['foo/*', 'not:foo/qux']));
            $this->assertFalse($this->active->isRoute(['foo/*']));
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
            $this->route('GET', $route);

            $this->assertSame($expected, $this->active->isActive(['pages.*', 'not:pages.show']));
        }
    }

    /** @test */
    public function it_can_get_active_class_when_it_matches_with_path()
    {
        $this->assertNull($this->active->active(['blog']));
        $this->assertNull($this->active->path(['blog']));

        $this->call('GET', 'blog');

        $this->assertSame('active', $this->active->active(['blog']));
        $this->assertSame('is-active', $this->active->active(['blog'], 'is-active'));

        $this->assertSame('active', $this->active->path(['blog']));
        $this->assertSame('is-active', $this->active->path(['blog'], 'is-active'));
    }

    /** @test */
    public function it_can_get_active_class_when_it_matches_with_route()
    {
        $this->assertNull($this->active->active(['home']));
        $this->assertNull($this->active->route(['home']));

        $this->route('GET', 'home');

        $this->assertSame('active', $this->active->active(['home']));
        $this->assertSame('is-active', $this->active->active(['home'], 'is-active'));

        $this->assertSame('active', $this->active->route(['home']));
        $this->assertSame('is-active', $this->active->route(['home'], 'is-active'));
    }

    /** @test */
    public function it_must_return_false_when_the_given_route_or_path_not_active()
    {
        $this->assertFalse($this->active->isActive(['404']));
        $this->assertFalse($this->active->isRoute(['404']));
        $this->assertFalse($this->active->isPath(['404']));
    }
}
