<?php namespace Goodspb\Laravel5Ucpaas\Facades;

use Illuminate\Support\Facades\Facade;

class Ucpaas extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ucpaas';
    }
}
