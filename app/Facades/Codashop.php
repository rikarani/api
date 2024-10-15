<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Codashop extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'codashop';
    }
}
