<?php

namespace AppsInteligentes\LaravelMultiDatabaseCommands\Commands;

use AppsInteligentes\LaravelMultiDatabaseCommands\LaravelMultiDatabaseCommands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunMigrationCommand extends Command
{

    public function __construct()
    {
        $this->signature = 'multi-db:migrate
            {connection? : The name of DB connection. If defined, will run command just in this DB connection}
            {--C|command= : The migrante command to be executed. The options are ' . implode(', ', LaravelMultiDatabaseCommands::$supportedMigrationRunSubCommands) . '}
            {--F|force : Force Migrate}';

        parent::__construct();
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrate command a single database connection defined by "connection" param,
    or in multiple db connections defined in multi_database_commands config file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): ?int
    {
        $migrationSubCommand = $this->option('command');
        $selectedDbConnection = $this->argument('connection');

        if (!empty($migrationSubCommand) && !in_array($migrationSubCommand, LaravelMultiDatabaseCommands::$supportedMigrationRunSubCommands)) {
            $this->error("Migrate command: {$migrationSubCommand} not supported.");
            $this->error('Just the following migrate commands are allowed: ' . implode(', ', LaravelMultiDatabaseCommands::$supportedMigrationRunSubCommands));

            return 1;
        }


        // If a DB is selected. Let`s run the command just with it
        if ($selectedDbConnection) {
            $databases = [$selectedDbConnection];
        } else {
            $databases = config('multi_database_commands.databases');
            if (empty($databases)) {
                $this->error('No database specified and no database defined in multi_database_commands config file');

                return 1;
            }
        }

        foreach ($databases as $selectedDbConnection) {
            $this->executeMigrate($selectedDbConnection, $migrationSubCommand, (boolean)$this->option('force'));
        }

        return 0;
    }

    private function executeMigrate(string $dbConnection, string $migrateSubCommand = null, bool $force = false): void
    {
        $this->info("Migrating: {$dbConnection}");
        $command = LaravelMultiDatabaseCommands::generateRunMigrationCommand($dbConnection, $force, $migrateSubCommand);
        $this->info("Executing the command: php artisan {$command}");
        Artisan::call($command);
        $this->line(Artisan::output());
    }
}
