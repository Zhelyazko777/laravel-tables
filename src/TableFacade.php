<?php

namespace Zhelyazko777\Tables;

use Illuminate\Support\Facades\Facade;

class TableFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'table';
    }
}
