<?php
use Bitrix\Highloadblock\HighloadBlockTable;

class CommandMigrate extends Command {
    public $sName = 'migrate';
    public $sDescription = 'Start migrations. Example: php bxm migrate';

    public $arMigrations = [];

    public function execute($argv) {
        $this->loadMigrations();
        $this->start();
        MigrationLog::add('OK', 'All migrations done');
        MigrationLog::show();
    }

    public function loadMigrations() {
        $arMigrationsTmp = scandir('migration');
        unset($arMigrationsTmp[0], $arMigrationsTmp[1]);

        $arMigrations = [];
        foreach ($arMigrationsTmp as $sFilename){
            $arMigrations[$sFilename] = $sFilename;
        }

        global $DB;
        $dbResults = $DB->Query("SELECT * FROM `migrations`");

        while ($arRow = $dbResults->Fetch()) {
            unset($arMigrations[$arRow['UF_FILENAME']]);
        }

        foreach ($arMigrations as $sFileName) {
            $arFileTemp = explode('-', explode('.', $sFileName)[0]);
            $this->arMigrations[] = [
                'classname' => $arFileTemp[1],
                'timestamp' => (int)$arFileTemp[0],
                'date'      => date('Y-m-d H:i:s'),
                'filename'  => $sFileName
            ];
        }
    }

    public static function getHlBlockId() {
        global $DB;
        $results = $DB->Query("SELECT * FROM `b_hlblock_entity`");

        while ($row = $results->Fetch()) {
            if ($row['TABLE_NAME'] === 'migrations') {
                return $row['ID'];
            }
        }
    }

    public function remember($arMigration) {
        $hl_block_id = $this->getHlBlockId();
        $hlblock = HighloadBlockTable::getById($hl_block_id)->fetch();
        $entity = HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $entity_data_class::add([
            'UF_CLASSNAME' => $arMigration['classname'],
            'UF_FILENAME'  => $arMigration['filename'],
            'UF_TIMESTAMP' => $arMigration['timestamp'],
            'UF_DATE'      => $arMigration['date']
        ]);

        MigrationLog::add('OK', "Migration {$arMigration['classname']} done");
    }

    public function start() {
        foreach ($this->arMigrations as $arMigration) {
            require_once 'migration/' . $arMigration['filename'];
            $class = new $arMigration['classname']();
            $class->up();
            $this->remember($arMigration);
        }
    }
}
