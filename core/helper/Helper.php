<?php

abstract class Helper {
    private $arIblocks = [];
    private $arFields = [];
    private $arRequired = [];

    public function checkRequired($sErrorType, $arRequired, $arFields) {
        $bError = false;
        foreach ($arRequired as $sRequiredKey){
            if(!isset($arFields[$sRequiredKey])){
                MigrationLog::add($sErrorType, "Field {$sRequiredKey} is required");
                $bError = true;
            }
        }
        if($bError){
            MigrationLog::show(true);
        }
    }

    public function getIblockId($sIblockCode){
        if(isset($this->arIblocks[$sIblockCode])){
            return $this->arIblocks[$sIblockCode];
        }

        $res = CIBlock::GetList(Array(), ['SITE_ID' => SITE_ID, 'CODE' => $sIblockCode], true);
        if($ar_res = $res->Fetch()) {
            $this->arIblocks[$sIblockCode] = $ar_res['ID'];
        } else {
            MigrationLog::add('IBLOCK', "IBlock {$sIblockCode} not found");
            MigrationLog::show(true);
        }

        return $this->arIblocks[$sIblockCode];
    }

    public function getFields(){
        return $this->arFields;
    }

    public function getRequiredFields(){
        return $this->arRequired;
    }
}
