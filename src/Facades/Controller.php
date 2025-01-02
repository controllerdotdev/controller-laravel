<?php

namespace Controller\Facades;

use Illuminate\Support\Facades\Facade;

class Controller extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'controller';
    }
}
