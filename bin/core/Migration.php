<?php
CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');

use Bitrix\Highloadblock\HighloadBlockTable;

class Migration
{
    //check migrations table
    public static function checkTable(){
        $result = HighloadBlockTable::add(array(
            'NAME' => 'Migrations',
            'TABLE_NAME' => 'migrations',
        ));

        if($result->isSuccess()){
            $highLoadBlockId = $result->getId();
            $userTypeEntity    = new CUserTypeEntity();

            $fields = array();
            $fields[] = array(
                'ENTITY_ID'         => 'HLBLOCK_'.$highLoadBlockId,
                'FIELD_NAME'        => 'UF_CLASSNAME',
                'USER_TYPE_ID'      => 'string',
                'XML_ID'            => 'UF_CLASSNAME',
                'MULTIPLE'          => 'N',
                'MANDATORY'         => 'Y',
                'SHOW_FILTER'       => 'N',
                'IS_SEARCHABLE'     => 'N'
            );

            $fields[] = array(
                'ENTITY_ID'         => 'HLBLOCK_'.$highLoadBlockId,
                'FIELD_NAME'        => 'UF_FILENAME',
                'USER_TYPE_ID'      => 'string',
                'XML_ID'            => 'UF_FILENAME',
                'MULTIPLE'          => 'N',
                'MANDATORY'         => 'Y',
                'SHOW_FILTER'       => 'N',
                'IS_SEARCHABLE'     => 'N'
            );

            $fields[] = array(
                'ENTITY_ID'         => 'HLBLOCK_'.$highLoadBlockId,
                'FIELD_NAME'        => 'UF_DATE',
                'USER_TYPE_ID'      => 'string',
                'XML_ID'            => 'UF_DATE',
                'MULTIPLE'          => 'N',
                'MANDATORY'         => 'Y',
                'SHOW_FILTER'       => 'N',
                'IS_SEARCHABLE'     => 'N'
            );

            $fields[] = array(
                'ENTITY_ID'         => 'HLBLOCK_'.$highLoadBlockId,
                'FIELD_NAME'        => 'UF_TIMESTAMP',
                'USER_TYPE_ID'      => 'string',
                'XML_ID'            => 'UF_TIMESTAMP',
                'MULTIPLE'          => 'N',
                'MANDATORY'         => 'Y',
                'SHOW_FILTER'       => 'N',
                'IS_SEARCHABLE'     => 'N'
            );

            foreach ($fields as $field) {
                $userTypeEntity->Add($field);
            }
        }
    }

    public static function create($argv){
        $name = $argv[2];
        if(!isset($name) || trim($name) == 'name'){
            echo 'migration name not found';
            die();
        }

        $name = preg_replace("/[^ \w]+/", " ", $name);
        $name = str_replace("_", " ", $name);
        $fileName = $_SERVER['MIGRATIONS'] . '/migration/' . time() . '-' . str_replace(" ", "_", $name) . '.php';
        $className = str_replace(" ", "", ucwords(strtolower($name)));

        //try to find MigrationAbstract
        if(isset($argv[3])){
            $temlatePath = $_SERVER['MIGRATIONS'] . '/templates/' . $argv[3] . '.template';
            if(file_exists($temlatePath)){
                echo "Template \033[31m{$argv[3]} \033[0mwas found\n";
                $content = file_get_contents($temlatePath);
            }else{
                echo "Template \033[31m{$argv[3]} \033[0mnot found\n";
                $content = file_get_contents($_SERVER['MIGRATIONS'] . '/templates/migration.template');
            }
        }else{
            $content = file_get_contents($_SERVER['MIGRATIONS'] . '/templates/migration.template');
        }

        $content = str_replace("%name%", $className, $content);
        file_put_contents($fileName, $content);

        echo "Migration \033[31m{$className} \033[0mcreated";
    }


    public static function loadMigrations(){
        $migrations = scandir($_SERVER['MIGRATIONS'] . '/migration/');
        unset($migrations[0], $migrations[1]);

        $timestamp = 0;

        global $DB;
        $results = $DB->Query("SELECT * FROM `migrations`");

        while ($row = $results->Fetch())
        {
            $timestamp = (int)$row['UF_TIMESTAMP'];
        }

        $result = [];
        foreach ($migrations as $text) {
            $temp = explode('-', explode('.', $text)[0]);
            $item = [
                'classname' => str_replace(" ", "", ucwords(strtolower(str_replace("_", " ", $temp[1])))),
                'timestamp' => (int)$temp[0],
                'date'      => date('Y-m-d H:i:s'),
                'file'      => $_SERVER['MIGRATIONS'] . '/migration/' . $text,
                'filename'  => $text
            ];
            if($item['timestamp'] > $timestamp)
                $result[] = $item;
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

    public static function remember($migration){
        $hl_block_id = self::getHlBlockId();
        $hlblock = HighloadBlockTable::getById($hl_block_id)->fetch();
        $entity = HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $result = $entity_data_class::add([
            'UF_CLASSNAME' => $migration['classname'],
            'UF_FILENAME'  => $migration['filename'],
            'UF_TIMESTAMP' => $migration['timestamp'],
            'UF_DATE'      => $migration['date']
        ]);

        echo "Migration \033[31m{$migration['classname']} \033[0mdone\n";
    }

    public static function start($migrations){
        foreach ($migrations as $migration) {
            require_once($migration['file']);
            $class = new $migration['classname']();
            $class->up();
            self::remember($migration);
        }
    }
}
