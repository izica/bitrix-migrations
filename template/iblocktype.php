<?php

use Izica\Migration;
use CModule;

class __NAME__ extends Migration {
    public function up() {
        CModule::IncludeModule('iblock');

        $arFields = [
            'ID'       => 'catalog',
            'SECTIONS' => 'Y',
            'SORT'     => 100,
            'LANG'     => [
                'en' => [
                    'NAME'         => 'Каталог',
                    'SECTION_NAME' => 'Категория',
                    'ELEMENT_NAME' => 'Продукт'
                ]
            ]
        ];

        $obBlocktype = new CIBlockType;
        $obBlocktype->Add($arFields);

        $this->log('CIBlockType catalog created');
    }

    public function down() {
        CModule::IncludeModule('iblock');

        CIBlockType::Delete('catalog');

        $this->log('CIBlockType catalog deleted');
    }
}
