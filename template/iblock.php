<?php

use Izica\Migration;
use CModule;

class __NAME__ extends Migration {
    public function up() {
        CModule::IncludeModule('iblock');

        $obIblock = new CIBlock;
        $arFields = [
            "ACTIVE"           => 'Y',
            "NAME"             => 'Новости',
            "CODE"             => 'news',
            "IBLOCK_TYPE_ID"   => 'info',
            "SITE_ID"          => ["s1"],
            "GROUP_ID"         => ["2" => "D", "3" => "R"]
        ];

        $nId = $obIblock->Add($arFields);

        $this->log('CIBlock news created');
    }

    public function down() {
        CModule::IncludeModule('iblock');

        CIBlock::Delete($this->getIblockIdByCode('news'));

        $this->log('CIBlock news deleted');
    }
}
