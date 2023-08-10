<?php

namespace HenryAvila\LaravelMultiDatabaseCommands;

use Illuminate\Support\Facades\Facade;

/**
 * @see \HenryAvila\LaravelMultiDatabaseCommands\LaravelMultiDatabaseCommands
 */
class LaravelMultiDatabaseCommandsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel_multi_database_commands';
    }
}
