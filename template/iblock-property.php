<?php

use Izica\Migration;
use CModule;

class __NAME__ extends Migration {
    public function up() {
        CModule::IncludeModule('iblock');

        $arFields = Array(
            "NAME" => "Доп. описание",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ADDITIONAL_DESCRIPTION",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => $this->getIblockIdByCode('news')
        );

        $obProperty = new CIBlockProperty;
        $nPropertyId = $obProperty->Add($arFields);
        $this->set('ADDITIONAL_DESCRIPTION', $nPropertyId);

        $this->log('Property ADDITIONAL_DESCRIPTION created');
    }

    public function down() {
        CModule::IncludeModule('iblock');

        $nPropertyId = $this->get('ADDITIONAL_DESCRIPTION');
        CIBlockProperty::Delete($nPropertyId);

        $this->log('Property ADDITIONAL_DESCRIPTION deleted');
    }
}
