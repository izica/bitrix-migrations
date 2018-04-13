<?php

class IblockSectionProperty
{
    private $service;

    private $property_types = [
        'STRING'   => 'string'
    ];

    public function __construct() {
        $this->service = new CUserTypeEntity;
    }

    public function create($sIblockCode, $arData){
        $nIblockId = $this->getIblockId($sIblockCode);

        $arFields = [
            "ENTITY_ID" => "IBLOCK_" . $nIblockId . "_SECTION",
            "FIELD_NAME" => $arData['CODE'],
            "USER_TYPE_ID" => isset($this->property_types[$arData['TYPE']]) ? $this->property_types[$arData['TYPE']] : 'string',
            "EDIT_FORM_LABEL" => [
                "ru" => $arData['NAME'],
                "en" => $arData['NAME']
            ]
        ];

        $this->service->Add($arFields);
        return $this;
    }

    public function delete($sIblockCode, $sPropertyCode){
        $nIblockId = $this->getIblockId($sIblockCode);
        $sEntityId = "IBLOCK_" . $nIblockId . "_SECTION";
        
        $this->service->DropEntity($sEntityId);
    }

    public function getIblockId($code){
        if(isset($this->iblock_id[$code])){
            return $this->iblock_id[$code];
        }

        $res = CIBlock::GetList(Array(), ['SITE_ID' => SITE_ID, 'CODE' => $code], true);
        if($ar_res = $res->Fetch()) {
            $this->iblock_id[$code] = $ar_res['ID'];
        } else {
            echo 'IBlock ' . $code . ' not found\n';
            die();
        }

        return $this->iblock_id[$code];
    }
}
