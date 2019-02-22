<?php
require_once 'core/class/loader.php';
require_once 'core/helper/loader.php';
require_once 'core/command/loader.php';

MigrationsManager::init();
$obCommand = MigrationsManager::getCommand($argv);
$obCommand->execute($argv);
