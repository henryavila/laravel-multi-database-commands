<?php

namespace AppsInteligentes\LaravelMultiDatabaseCommands;

use Illuminate\Support\Facades\File;

class LaravelMultiDatabaseCommands
{
    public static $supportedMigrationRunSubCommands = [
        'fresh',
        'install',
        'refresh',
        'reset',
        'rollback',
        'status',
    ];

    public static function generateRunMigrationCommand(string $dbConnection, bool $force, string $command = null): string
    {
        $forceExecution = $force ? ' --force' : '';
        $command = $command ? ":{$command}" : '';

        return "migrate{$command} --database={$dbConnection} --path=database/migrations/{$dbConnection}{$forceExecution}";
    }

    public static function generateCreateMigrationCommand(
        string $migrationName,
        string $dbConnection,
        string | null $create = null,
        string | null $table = null
    ): string {
        $createCommandOption = $create ? " --create {$create}" : '';
        $tableCommandOption = $table ? " --table {$table}" : '';

        return "make:migration {$migrationName} --path database/migrations/{$dbConnection}{$createCommandOption}{$tableCommandOption}";
    }

    public static function getVersion()
    {
        return once(function () {
            $manifest = json_decode(File::get(base_path() . DIRECTORY_SEPARATOR . 'composer.json'), true);

            return $manifest['version'];
        });
    }
}
