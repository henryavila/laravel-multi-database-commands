<?php

namespace AppsInteligentes\LaravelMultiDatabaseCommands;

use AppsInteligentes\LaravelMultiDatabaseCommands\Commands\CreateMigrationCommand;
use AppsInteligentes\LaravelMultiDatabaseCommands\Commands\RunMigrationCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMultiDatabaseCommandsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel_multi_database_commands')
            ->hasConfigFile('multi_database_commands')
            ->hasCommands(
                RunMigrationCommand::class,
                CreateMigrationCommand::class
            );
    }
}
