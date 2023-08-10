<?php

namespace Tests;

use HenryAvila\LaravelMultiDatabaseCommands\LaravelMultiDatabaseCommands;

class CreateMigrationCommandTest extends TestCase
{
    /** @test */
    public function generate_correct_make_migration_command()
    {
        // just migration name
        $command = LaravelMultiDatabaseCommands::generateCreateMigrationCommand(
            migrationName: 'add_users_table',
            dbConnection: 'log'
        );
        $this->assertEquals("make:migration add_users_table --path database/migrations/log", $command);

        // with create option
        $command = LaravelMultiDatabaseCommands::generateCreateMigrationCommand(
            migrationName: 'add_users_table',
            dbConnection: 'log',
            create: 'new_users'
        );
        $this->assertEquals("make:migration add_users_table --path database/migrations/log --create new_users", $command);

        // with table option
        $command = LaravelMultiDatabaseCommands::generateCreateMigrationCommand(
            migrationName: 'new_user_options',
            dbConnection: 'log',
            table: 'users'
        );
        $this->assertEquals("make:migration new_user_options --path database/migrations/log --table users", $command);
    }
}
