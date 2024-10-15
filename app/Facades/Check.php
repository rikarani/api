<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Check extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'check';
    }
}
