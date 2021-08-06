<?php declare(strict_types=1);

namespace Arcanedev\LaravelActive\Tests;

/**
 * Class     LaravelActiveServiceProviderTest
 *
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

    /** {@inheritDoc} */
    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(\Arcanedev\LaravelActive\LaravelActiveServiceProvider::class);
    }

    /** {@inheritDoc} */
    protected function tearDown(): void
    {
        unset($this->provider);

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
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\Providers\ServiceProvider::class,
            \Arcanedev\Support\Providers\PackageServiceProvider::class,
            \Arcanedev\LaravelActive\LaravelActiveServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides(): void
    {
        $expected = [
            \Arcanedev\LaravelActive\Contracts\Active::class,
        ];

        static::assertSame($expected, $this->provider->provides());
    }
}
