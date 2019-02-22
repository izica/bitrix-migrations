<?php

namespace Izica;

abstract class Helper {
    private $arFields = [];
    private $arRequired = [];

    public function setFields($arFields) {
        foreach ($arFields as $key => $value){
            $this->arFields[$key] = $value;
        }
        return $this;
    }

    public function setField($key, $value) {
        $this->arFields[$key] = $value;
        return $this;
    }

    public function checkRequired($sErrorType, $arRequired, $arFields) {
        $bError = false;
        foreach ($arRequired as $sRequiredKey) {
            if (!isset($arFields[$sRequiredKey])) {
                MigrationLog::add($sErrorType, "Field {$sRequiredKey} is required");
                $bError = true;
            }
        }
        if ($bError) {
            MigrationLog::show(true);
        }
    }

    public function getIblockId($sIblockCode) {
        $dbResult = \CIBlock::GetList([], ['SITE_ID' => SITE_ID, 'CODE' => $sIblockCode], true);
        if ($arResult = $dbResult->Fetch()) {
            return $arResult['ID'];
        } else {
            MigrationLog::add('IBLOCK_CODE_NOT_FOUND', $sIblockCode);
            MigrationLog::show(true);
        }
    }

    public function getFields() {
        return $this->arFields;
    }

    public function getRequiredFields() {
        return $this->arRequired;
    }
}
