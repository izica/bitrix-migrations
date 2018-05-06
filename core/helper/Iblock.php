<?php

class Iblock
{
    private $service;

    public function __construct() {
        $this->service = new CIBlock;
    }

    public function create($data){
        $arFields = [
            'ACTIVE'          => isset($data['ACTIVE']) ? $data['ACTIVE'] : 'Y',
            'NAME'            => $data['NAME'],
            'CODE'            => $data['CODE'],
            'LIST_PAGE_URL'   => isset($data['LIST_PAGE_URL']) ? $data['LIST_PAGE_URL'] : '/',
            'DETAIL_PAGE_URL' => isset($data['DETAIL_PAGE_URL']) ? $data['DETAIL_PAGE_URL'] : '/',
            'IBLOCK_TYPE_ID'  => isset($data['IBLOCK_TYPE_CODE']) ? $data['IBLOCK_TYPE_CODE'] : $data['IBLOCK_TYPE_ID'],
            'SITE_ID'         => isset($data['SITE_ID']) ? $data['SITE_ID'] : 's1',
            'SORT'            => isset($data['SORT']) ? $data['SORT'] : 500,
            'GROUP_ID'        => isset($data['GROUP_ID']) ? $data['GROUP_ID'] : ['2' => 'R']
        ];

        $this->service->Add($arFields);

        if($data['CODE_REQUIRED'] === true){
            $this->setCodeTransliteration($data['CODE'])->setCodeUnique($data['CODE']);
        }

        if($data['CODE_TRANSLIT'] === true){
            $this->setCodeTransliteration($data['CODE'])->setCodeRequired($data['CODE'])->setCodeUnique($data['CODE']);
        }
    }

    public function setCodeUnique($sIblockCode){
        $iblock_id = $this->find($sIblockCode);
        $arFields = CIBlock::getFields($iblock_id);
        $arFields['CODE']['DEFAULT_VALUE']['UNIQUE'] = 'Y';
        CIBlock::setFields($iblock_id, $arFields);
        return $this;
    }

    public function setCodeTransliteration($sIblockCode){
        $iblock_id = $this->find($sIblockCode);
        $arFields = CIBlock::getFields($iblock_id);
        $arFields['CODE']['DEFAULT_VALUE']['TRANSLITERATION'] = 'Y';
        CIBlock::setFields($iblock_id, $arFields);
        return $this;
    }

    public function setCodeRequired($sIblockCode){
        $iblock_id = $this->find($sIblockCode);
        $arFields = CIBlock::getFields($iblock_id);
        $arFields['CODE']['IS_REQUIRED'] = 'Y';
        CIBlock::setFields($iblock_id, $arFields);
        return $this;
    }

    public function update($sIblockCode, $arFields){
        $obRes = CIBlock::GetList(Array(), ['SITE_ID' => SITE_ID, 'CODE' => $sIblockCode], true);
        if ($arResult = $obRes->Fetch()) {
            $arIblock = $arResult;
        }else{
            echo 'IBlock::update - ' . $sIblockCode . " not found\n";
            die();
        }

        foreach ($arFields as $sKey => $sValue) {
            if(isset($arIblock[$sKey])){
                $arIblock[$sKey] = $sValue;
            }
        }

        $this->service->Update($arIblock['ID'], $arIblock);
    }

    public function find($sIblockCode){
        $res = CIBlock::GetList(Array(), ['SITE_ID' => SITE_ID, 'CODE' => $sIblockCode], true);
        if($ar_res = $res->Fetch()) {
            return $ar_res['ID'];
        } else {
            echo 'IBlock ' . $sIblockCode . " not found\n";
            die();
        }
    }

    public function delete($sIblockCode){
        $iblock_id = $this->find($sIblockCode);
        CIBlock::Delete($iblock_id);
    }
}
