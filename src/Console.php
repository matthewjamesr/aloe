<?php

namespace Aloe;

require __DIR__ . "/helpers.php";

use Symfony\Component\Console\Application;

class Console
{
    /**
     * Instance of symfony console app
     */
    private static $app;

    /**
     * Load up aloe without calling the boot method
     */
    public function __construct($app = "ALoe CLI", $version = "v1.0")
    {
        static::boot($app, $version);
    }

    /**
     * Boot the aloe CLI
     * 
     * @param string $app The name of the app to display in terminal
     * @param string $version The app version
     * @param bool $load Load the default Aloe CLI commands?
     */
    public static function boot($app = "Aloe CLI", $version = "v1.0", $load = true)
    {
        static::$app = new Application(asComment($app), $version);
        if ($load) static::load();
    }

    /**
     * Load default console commands
     */
    public static function load()
    {
        static::register(static::commands());
    }

    /**
     * Return list of all default commands
     */
    public static function commands()
    {
        return [
            // Random Commands
            \Aloe\Command\ServeCommand::class,
            \Aloe\Command\ConsoleCommand::class,
            \Aloe\Command\AppDownCommand::class,
            \Aloe\Command\AppUpCommand::class,
            // Aloe Commands
            \Aloe\Command\AloeInstallCommand::class,
            // \Aloe\Command\InstallDebuggerCommand::class,
            // Scaffold Commands
            \Aloe\Command\ScaffoldAuthCommand::class,
            // Env Commands
            \Aloe\Command\EnvGenerateCommand::class,
            // Generate Commands
            \Aloe\Command\GenerateMigrationCommand::class,
            \Aloe\Command\GenerateModelCommand::class,
            \Aloe\Command\GenerateHelperCommand::class,
            \Aloe\Command\GenerateControllerCommand::class,
            \Aloe\Command\GenerateSeedCommand::class,
            \Aloe\Command\GenerateConsoleCommand::class,
            \Aloe\Command\GenerateFactoryCommand::class,
            \Aloe\Command\GenerateTemplateCommand::class,
            // Delete Commands
            \Aloe\Command\DeleteModelCommand::class,
            \Aloe\Command\DeleteSeedCommand::class,
            \Aloe\Command\DeleteFactoryCommand::class,
            \Aloe\Command\DeleteControllerCommand::class,
            \Aloe\Command\DeleteConsoleCommand::class,
            \Aloe\Command\DeleteMigrationCommand::class,
            // Database Commands
            \Aloe\Command\DatabaseInstallCommand::class,
            \Aloe\Command\DatabaseMigrationCommand::class,
            \Aloe\Command\DatabaseResetCommand::class,
            \Aloe\Command\DatabaseRollbackCommand::class,
            \Aloe\Command\DatabaseSeedCommand::class
        ];
    }

    /**
     * Register a custom command
     * 
     * @param array|Aloe\Command $command: Command(s) to run
     * 
     * @return void
     */
    public static function register($command)
    {
        if (is_array($command)) {
            foreach ($command as $item) {
                static::register($item);
            }
        } else {
            static::$app->add(new $command);
        }
    }

    /**
     * Run the console app
     */
    public static function run()
    {
        static::$app->run();
    }
}
