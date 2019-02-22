<?php

namespace Izica;

class MigrationLog {
    private static $arItems = [];

    public static function count() {
        return count(self::$arItems);
    }

    public static function add($sCode, $sMessage) {
        self::$arItems[] = '[' . $sCode . '] ' . self::translit($sMessage);
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

    private static function translit($s) {
        $letters = ['а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''];
        $lettersUpper = [];

        foreach ($letters as $rus => $eng){
            $lettersUpper[strtoupper($rus)] = strtoupper($eng);
        }

        $s = (string)$s;
        $s = strip_tags($s);
        $s = str_replace(["\n", "\r"], " ", $s);
        $s = preg_replace("/\s+/", ' ', $s);
        $s = trim($s);
        $s = strtr($s, $letters);
        $s = strtr($s, $lettersUpper);
        $s = ucfirst($s);
        return $s;
    }
}
