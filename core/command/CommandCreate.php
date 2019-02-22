<?php

class CommandCreate extends Command {
    private $nTime = 0;
    public $sName = 'create';
    public $sDescription = 'Create migration. Example: php bxm create InformationIblockCreate';

    public function execute($argv) {
        $this->nTime = time();
        $sClassName = $this->getClassName($argv);
        $sFileName = 'migration/' . $this->nTime . '-' . $sClassName . '.php';

        $sTemplate = $this->getTemplate($argv);

        $sContent = str_replace("%name%", $sClassName, $sTemplate);
        file_put_contents($sFileName, $sContent);

        MigrationLog::add('OK', "Migration {$sClassName} created");
        MigrationLog::show(true);
    }

    public function getTemplate($argv) {
        $sDefaultFileName = 'template/default.template';
        $sTemplateName = 'default';
        if (isset($argv[3])) {
            $sFileName = 'template/' . $argv[3] . '.template';
            if (file_exists($sFileName)) {
                return file_get_contents($sFileName);
            } else {
                MigrationLog::add('TEMPLATE', 'Cant find template ' . $argv[3]);
                MigrationLog::show(true);
            }
        }
        if (!file_exists($sDefaultFileName)) {
            MigrationLog::add('TEMPLATE', 'Cant find default template');
            MigrationLog::show(true);
        }
        return file_get_contents($sDefaultFileName);
    }

    public function getClassName($argv) {
        if (!isset($argv[2])) {
            MigrationLog::add('MIGRATION', 'Name not found');
            MigrationLog::show(true);
        }
        $sName = preg_replace('/[^\w]/', ' ', $argv[2]);
        $sName = ucwords($sName) . $this->nTime;
        return str_replace(' ', '', $sName);
    }
}
