<?php

namespace AppsInteligentes\LaravelMultiDatabaseCommands\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use AppsInteligentes\LaravelMultiDatabaseCommands\LaravelMultiDatabaseCommandsServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Spatie\\LaravelMultiDatabaseCommands\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelMultiDatabaseCommandsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        include_once __DIR__.'/../database/migrations/create_laravel_multi_database_commands_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
