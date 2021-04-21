<?php

namespace AppsInteligentes\LaravelMultiDatabaseCommands;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AppsInteligentes\LaravelMultiDatabaseCommands\LaravelMultiDatabaseCommands
 */
class LaravelMultiDatabaseCommandsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel_multi_database_commands';
    }
}
