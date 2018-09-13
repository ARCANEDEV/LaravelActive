<?php namespace Arcanedev\LaravelActive\Tests;

use Arcanedev\LaravelActive\LaravelActiveServiceProvider;
use Arcanedev\Support\PackageServiceProvider;

/**
 * Class     LaravelActiveServiceProviderTest
 *
 * @package  Arcanedev\LaravelActive\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LaravelActiveServiceProviderTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\LaravelActive\LaravelActiveServiceProvider */
    protected $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(\Arcanedev\LaravelActive\LaravelActiveServiceProvider::class);
    }

    protected function tearDown()
    {
        unset($this->provider);

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
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\PackageServiceProvider::class,
            \Arcanedev\LaravelActive\LaravelActiveServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides()
    {
        $expected = [
            \Arcanedev\LaravelActive\Contracts\Active::class,
        ];

        static::assertSame($expected, $this->provider->provides());
    }
}
