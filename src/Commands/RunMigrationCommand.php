<?php

namespace AppsInteligentes\LaravelMultiDatabaseCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunMigrationCommand extends Command
{
    private array $supportedMigrationSubCommands = [
        'fresh',
        'install',
        'refresh',
        'reset',
        'rollback',
        'status',
    ];

    public function __construct()
    {
        $this->signature = 'multi-db:migrate
            {connection? : The name of DB connection. If defined, will run command just in this DB connection}
            {--C|command= : The migrante command to be executed. The options are ' . implode(', ', $this->supportedMigrationSubCommands) . '}
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
        $forceExecution = $this->option('force') ? ' --force' : '';
        $migrationSUbCommand = '';

        if (!empty($migrationSubCommand)) {
            if (!in_array($migrationSubCommand, $this->supportedMigrationSubCommands)) {
                $this->error("Migrate command: {$migrationSubCommand} not supported.");
                $this->error('Just the following migrate commands are allowed: ' . implode(', ', $this->supportedMigrationSubCommands));

                return 1;
            }

            $migrationSUbCommand = ":{$migrationSubCommand}";
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
            $this->executeMigrate($selectedDbConnection, $migrationSUbCommand, $forceExecution);
        }

        return 0;
    }

    private function executeMigrate(string $name, string $migrateSubCommand, string $forceExecution): void
    {
        $this->info("Migrating: {$name}");
        Artisan::call("migrate{$migrateSubCommand} --database={$name} --path=database/migrations/{$name} {$forceExecution}");
        $this->line(Artisan::output());
    }
}
