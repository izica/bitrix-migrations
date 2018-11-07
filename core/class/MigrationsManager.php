<?php

use Bitrix\Highloadblock\HighloadBlockTable;

class MigrationsManager {
    public static $arCommands = [];

    public static function init() {
        $obInitCommand = new CommandInit();
        $obMigrateCommand = new CommandMigrate();
        $obRollbackCommand = new CommandRollback();
        $obCreateCommand = new CommandCreate();

        self::$arCommands = [
            $obInitCommand->getName()     => $obInitCommand,
            $obMigrateCommand->getName()  => $obMigrateCommand,
            $obRollbackCommand->getName() => $obRollbackCommand,
            $obCreateCommand->getName()   => $obCreateCommand,
        ];

    }

    public static function getCommand($argv) {
        $bList = false;
        if (isset($argv[1])) {
            if (!isset(self::$arCommands[$argv[1]])) {
                echo "Command not found\n";
                $bList = true;
            }
        } else {
            $bList = true;
        }

        if ($bList) {
            echo "List of available commands:\n";
            foreach (self::$arCommands as $command) {
                echo $command->getName() . " -- " . $command->getDescription() . "\n";
            }
            die();
        }

        if ($argv['1'] !== 'init') {
            self::checkDocumentRoot($argv);
            self::requireBitrix();
            self::createOrCheckMigrationsTable();
        }

        return self::$arCommands[$argv[1]];
    }

    public static function requireBitrix() {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
        CModule::IncludeModule('iblock');
        CModule::IncludeModule('highloadblock');
    }

    public static function checkDocumentRoot($argv) {
        if (!isset($_SERVER['DOCUMENT_ROOT']) || !is_dir($_SERVER['DOCUMENT_ROOT']) || !$_SERVER['DOCUMENT_ROOT']) {
            MigrationLog::add('DOCUMENT_ROOT', "Current \$_SERVER[DOCUMENT_ROOT] = " . ($_SERVER[DOCUMENT_ROOT] ? $_SERVER[DOCUMENT_ROOT] : 'NULL'));
            MigrationLog::add('DOCUMENT_ROOT', "Bad \$_SERVER[DOCUMENT_ROOT]");
            MigrationLog::add('DOCUMENT_ROOT', "You should use 'php #PATH_TO_MODULE# init' before use migrations");
            MigrationLog::show(true);
        }
    }

    public static function createOrCheckMigrationsTable() {
        $result = HighloadBlockTable::add([
            'NAME'       => 'Migrations',
            'TABLE_NAME' => 'migrations',
        ]);

        if ($result->isSuccess()) {
            $highLoadBlockId = $result->getId();
            $userTypeEntity = new CUserTypeEntity();

            $fields = [];
            $fields[] = [
                'ENTITY_ID'     => 'HLBLOCK_' . $highLoadBlockId,
                'FIELD_NAME'    => 'UF_CLASSNAME',
                'USER_TYPE_ID'  => 'string',
                'XML_ID'        => 'UF_CLASSNAME',
                'MULTIPLE'      => 'N',
                'MANDATORY'     => 'Y',
                'SHOW_FILTER'   => 'N',
                'IS_SEARCHABLE' => 'N'
            ];

            $fields[] = [
                'ENTITY_ID'     => 'HLBLOCK_' . $highLoadBlockId,
                'FIELD_NAME'    => 'UF_FILENAME',
                'USER_TYPE_ID'  => 'string',
                'XML_ID'        => 'UF_FILENAME',
                'MULTIPLE'      => 'N',
                'MANDATORY'     => 'Y',
                'SHOW_FILTER'   => 'N',
                'IS_SEARCHABLE' => 'N'
            ];

            $fields[] = [
                'ENTITY_ID'     => 'HLBLOCK_' . $highLoadBlockId,
                'FIELD_NAME'    => 'UF_DATE',
                'USER_TYPE_ID'  => 'string',
                'XML_ID'        => 'UF_DATE',
                'MULTIPLE'      => 'N',
                'MANDATORY'     => 'Y',
                'SHOW_FILTER'   => 'N',
                'IS_SEARCHABLE' => 'N'
            ];

            $fields[] = [
                'ENTITY_ID'     => 'HLBLOCK_' . $highLoadBlockId,
                'FIELD_NAME'    => 'UF_TIMESTAMP',
                'USER_TYPE_ID'  => 'string',
                'XML_ID'        => 'UF_TIMESTAMP',
                'MULTIPLE'      => 'N',
                'MANDATORY'     => 'Y',
                'SHOW_FILTER'   => 'N',
                'IS_SEARCHABLE' => 'N'
            ];

            foreach ($fields as $field) {
                $userTypeEntity->Add($field);
            }
        }
    }
}
