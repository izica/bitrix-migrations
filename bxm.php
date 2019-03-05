<?php
namespace Izica;

require_once 'core/class/loader.php';
require_once 'core/command/loader.php';

$_SERVER['DOCUMENT_ROOT'] = realpath($_SERVER['DOCUMENT_ROOT']);

MigrationsManager::init();
$obCommand = MigrationsManager::getCommand($argv);
$obCommand->execute($argv);
