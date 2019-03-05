<?php

use Izica\Migration;
use CModule;

class __NAME__ extends Migration {
    public function up() {
        CModule::IncludeModule('iblock');

        $obIblock = new CIBlock;
        $arFields = [
            "ACTIVE"         => 'Y',
            "NAME"           => 'Каталог',
            "CODE"           => 'catalog',
            "IBLOCK_TYPE_ID" => 'info',
            "SITE_ID"        => ["s1"],
            "GROUP_ID"       => ["2" => "D", "3" => "R"]
        ];

        $nIblockId = $obIblock->Add($arFields);

        CCatalog::Add([
            'IBLOCK_ID' => $nIblockId,            // код (ID) инфоблока торговых предложений
        ]);

        $this->log('CIBlock catalog created');
    }

    public function down() {
        CModule::IncludeModule('iblock');

        CIBlock::Delete($this->getIblockIdByCode('catalog'));

        $this->log('CIBlock catalog deleted');
    }
}
