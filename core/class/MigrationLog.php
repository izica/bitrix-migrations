<?php

class MigrationLog {
    private static $arItems = [];

    public static function count() {
        return count(self::$arItems);
    }

    public static function add($sCode, $sMessage) {
        self::$arItems[] = '[' . $sCode . '] ' . $sMessage;
        return self::class;
    }

    public static function show($bDie = false) {
        echo "\nLog:\n";
        foreach (self::$arItems as $arItem) {
            echo $arItem . "\n";
        }
        if ($bDie) {
            die();
        }
    }
}