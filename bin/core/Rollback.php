<?php
CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');

use Bitrix\Highloadblock\HighloadBlockTable;

class Rollback
{
    public static function loadMigrations(){
        global $DB;
        $results = $DB->Query("SELECT * FROM `migrations`");

        while ($row = $results->Fetch())
        {
            $result[] = [
                'id'        => $row['ID'],
                'classname' => $row['UF_CLASSNAME'],
                'filename'  => $_SERVER['MIGRATIONS'] . '/migration/' . $row['UF_FILENAME']
            ];
        }

        return $result;
    }

    public static function getHlBlockId(){
        global $DB;
        $results = $DB->Query("SELECT * FROM `b_hlblock_entity`");

        while ($row = $results->Fetch())
        {
            if($row['TABLE_NAME'] === 'migrations')
                return $row['ID'];
        }
    }

    public static function delete($migration){
        $hl_block_id = self::getHlBlockId();
        $hlblock = HighloadBlockTable::getById($hl_block_id)->fetch();
        $entity = HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        $entity_data_class::delete($migration['id']);

        echo "Migration \033[31m{$migration['classname']} \033[0mrollbacked\n";
    }

    public static function last($migrations){
        foreach ($migrations as $migration) {
            require_once($migration['filename']);
            $class = new $migration['classname']();
            $class->down();
            self::delete($migration);
            die();
        }
    }

    public static function reset($migrations){
        foreach ($migrations as $migration) {
            require_once($migration['filename']);
            $class = new $migration['classname']();
            $class->down();
            self::delete($migration);
        }
    }
}
