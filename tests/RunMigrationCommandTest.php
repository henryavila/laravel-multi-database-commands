<?php

namespace Tests;

use HenryAvila\LaravelMultiDatabaseCommands\LaravelMultiDatabaseCommands;

class RunMigrationCommandTest extends TestCase
{
    /** @test */
    public function generate_command_for_single_db()
    {
        $dbConnection = 'log';
        $command = LaravelMultiDatabaseCommands::generateRunMigrationCommand($dbConnection, false);
        $this->assertEquals("migrate --database={$dbConnection} --path=database/migrations/{$dbConnection}", $command);
    }

    /** @test */
    public function generate_migrate_with_sub_commands()
    {
        $dbConnection = 'anyDbConnectionName';

        foreach (LaravelMultiDatabaseCommands::$supportedMigrationRunSubCommands as $cmd) {
            $command = LaravelMultiDatabaseCommands::generateRunMigrationCommand($dbConnection, false, $cmd);
            $this->assertEquals(
                "migrate:{$cmd} --database={$dbConnection} --path=database/migrations/{$dbConnection}",
                $command,
                "The generated migrate command for {$cmd} in invalid"
            );
        }
    }

    /** @test */
    public function dont_accept_invalid_migrate_subcommand()
    {
        $dbConnection = 'testing';
        $migrationSubCommand = 'invalidCommand';

        $this->artisan("multi-db:migrate {$dbConnection} -C {$migrationSubCommand}")
            ->expectsOutput("Migrate command: {$migrationSubCommand} not supported.")
            ->expectsOutput('Just the following migrate commands are allowed: ' . implode(', ', LaravelMultiDatabaseCommands::$supportedMigrationRunSubCommands))
            ->assertExitCode(1);
    }

    /** @test */
    public function must_specify_a_db_or_have_multiple_dbs()
    {
        $this->artisan('multi-db:migrate')
            ->expectsOutput('No database specified and no database defined in multi_database_commands config file')
            ->assertExitCode(1);
    }
}
