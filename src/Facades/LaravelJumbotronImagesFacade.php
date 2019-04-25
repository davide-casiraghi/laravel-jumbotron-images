<?php

namespace DavideCasiraghi\LaravelJumbotronImages\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DavideCasiraghi\LaravelJumbotronImages\Skeleton\SkeletonClass
 */
class LaravelJumbotronImagesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-jumbotron-images';
    }
}
