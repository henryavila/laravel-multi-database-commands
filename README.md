# This package provides an abstraction to efficiently run migrate command on multiple database app


## Installation

You can install the package via composer:

```bash
composer require apps-inteligentes/laravel-multi-database-commands
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="AppsInteligentes\LaravelMultiDatabaseCommands\LaravelMultiDatabaseCommandsServiceProvider" --tag="laravel_multi_database_commands-config"
```

This is the contents of the published config file:

```php
return [

    /*
     * Add here the list of all database connection.
     * You can find the connection names in config file: database.connections
     */
    'databases' => [

    ]
];
```

## Usage

All new migration, created by this package will be organized this way:
each database present in `multi_database_commands.databases` will have their own migration folder.

Ex: All migrations for DB `tenant` will be stored in `database/migration/tenant`. 
All migrate command executed by this package will isolate all DB.

### Crate Migration Files
To create the migration add_active_column_on_users_table on tenant db connection, run the command:
```bash
php artisan multi-db:make-migration add_active_column_on_users_table tenant
```
Just like `php artisan make:migration` command, you can use the options `--create theTableToBeCreated` and `--table theTableToBeMigrated`


### Running Migrations
To execute a migrate command in all DB. The list of all databases, must be defined in config file `multi_database_commands`
```bash
php artisan multi-db:migrate
php artisan multi-db:migrate -C status
```
Just like `php artisan migrate` command, you can use all laravel variations `fresh`, `install`, `refresh`, `reset`, `rollback` and status`


To execute the command in on DB, just inform the db connection name
```bash
#Execute the migrate:status just on log db
php artisan multi-db:migrate log -C status
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Henry Ávila](https://github.com/henryavila)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
