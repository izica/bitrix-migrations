<?php
class Bxm
{
    public static function getCommand($argv){
        return $argv[1];
    }

    public static function checkCommand($argv, $commands){
        if(!isset($commands[$argv[1]])){
            echo "Command not found \nList of available commands:\n";
            foreach ($commands as $command => $description) {
                echo  "\033[31m" . $command . "\033[0m -- " . $description . "\n";
            }
            die();
        }
    }

    public static function migrate(){
        Migration::checkTable();

        $migrations = Migration::loadMigrations();
        Migration::start($migrations);
    }

    public static function rollback(){
        Migration::checkTable();

        $migrations = Rollback::loadMigrations();
        Rollback::last($migrations);
    }

    public static function reset(){
        Migration::checkTable();
        $migrations = Rollback::loadMigrations();
        Rollback::reset($migrations);
    }

    public static function migration($argv){
        Migration::create($argv);
    }
}
