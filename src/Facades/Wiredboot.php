<?php

namespace Dmilho\Wiredboot\Facades;

use Illuminate\Support\Facades\Facade;

class Wiredboot extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'wiredboot';
    }
}
