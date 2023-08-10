<?php

namespace HenryAvila\LaravelMultiDatabaseCommands\Commands;

use HenryAvila\LaravelMultiDatabaseCommands\LaravelMultiDatabaseCommands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateMigrationCommand extends Command
{
    protected $signature = 'multi-db:make-migration
            {name       : The name of the migration}
            {connection : The name of DB connection. If defined, will run command just in this DB connection}
            {--create=  : The table to be created}
            {--table=   : The table to be migrated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file saving it in the  correct migration folder.';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle(): ?int
    {
        $selectedDbConnection = $this->argument('connection');

        $connectionConfig = config("database.connections.$selectedDbConnection");
        if (empty($connectionConfig)) {
            $this->error("The DB Connection '{$selectedDbConnection}' is not configured in database config file.");

            return 1;
        }

        $commandToRun = LaravelMultiDatabaseCommands::generateCreateMigrationCommand(
            $this->argument('name'),
            $selectedDbConnection,
            $this->option('create'),
            $this->option('table')
        );

        $this->info("Executing the command : php artisan {$commandToRun}");
        Artisan::call($commandToRun);
        $this->line(Artisan::output());

        return 0;
    }
}
