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
            'LIST_PAGE_URL'   => '/',
            'DETAIL_PAGE_URL' => '/',
            'IBLOCK_TYPE_ID'  => $data['IBLOCK_TYPE_ID'],
            'SITE_ID'         => isset($data['SITE_ID']) ? $data['SITE_ID'] : 's1',
            'SORT'            => isset($data['SORT']) ? $data['SORT'] : 500,
            'GROUP_ID'        => isset($data['GROUP_ID']) ? $data['GROUP_ID'] : ['2' => 'R']
        ];

        $this->service->Add($arFields);

        if($data['CODE_TRANSLIT'] === true){
            $this->elementsCodeTransliterationEnable($code);
        }
    }

    public function elementsCodeTransliterationEnable($code){
        $iblock_id = $this->find($code);
        $arFields = CIBlock::getFields($iblock_id);
        $arFields['CODE']['DEFAULT_VALUE']['TRANSLITERATION'] = 'Y';
        $arFields['CODE']['DEFAULT_VALUE']['UNIQUE'] = 'Y';
        CIBlock::setFields($iblock_id, $arFields);
    }

    public function find($code){
        $res = CIBlock::GetList(Array(), ['SITE_ID' => SITE_ID, 'CODE' => $code], true);
        if($ar_res = $res->Fetch()) {
            return $ar_res['ID'];
        } else {
            echo 'IBlock ' . $code . " not found\n";
            return 0;
        }
    }

    public function delete($code){
        $iblock_id = $this->find($code);
        CIBlock::Delete($iblock_id);
    }
}
