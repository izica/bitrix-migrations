<?php
use Bitrix\Highloadblock\HighloadBlockTable;

class CommandRollback extends Command {
    public $sName = 'rollback';
    public $sDescription = 'Rollback last migration. Example: php bxm rollback';
    public $arMigration = false;

    public function execute($argv) {
        $this->loadMigrations();
        $this->rollback();
        $this->delete();
        MigrationLog::show(true);
    }


    public function loadMigrations() {
        global $DB;
        $results = $DB->Query('SELECT * FROM `migrations` ORDER BY UF_TIMESTAMP DESC');

        if ($row = $results->Fetch()) {
            $this->arMigration = [
                'id'        => $row['ID'],
                'classname' => $row['UF_CLASSNAME'],
                'filename'  => $row['UF_FILENAME']
            ];
        }else{
            MigrationLog::add('ROLLBACK', 'Migrations not found');
            MigrationLog::show(true);
        }
    }

    public function getHlBlockId() {
        global $DB;
        $results = $DB->Query("SELECT * FROM `b_hlblock_entity`");

        while ($row = $results->Fetch()) {
            if ($row['TABLE_NAME'] === 'migrations') {
                return $row['ID'];
            }
        }
    }

    public function delete() {
        $hl_block_id = $this->getHlBlockId();
        $hlblock = HighloadBlockTable::getById($hl_block_id)->fetch();
        $entity = HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        $entity_data_class::delete($this->arMigration['id']);

        MigrationLog::add('OK', "Migration {$this->arMigration['classname']} rollbacked\n");
    }

    public function rollback() {
        require_once 'migration/' . $this->arMigration['filename'];
        $class = new $this->arMigration['classname']();
        $class->down();
    }
}
