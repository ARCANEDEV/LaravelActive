<?php namespace Arcanedev\LaravelActive\Facades;

use Arcanedev\LaravelActive\Contracts\Active as ActiveContract;
use Illuminate\Support\Facades\Facade;

/**
 * Class     Active
 *
 * @package  Arcanedev\LaravelActive\Facades
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Active extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return ActiveContract::class; }
}
