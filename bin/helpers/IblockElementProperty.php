<?php

class IblockElementProperty
{
    private $iblock_id = Array();
    private $service;

    private $property_types = [
        'STRING'   => 'S',
        'LIST'     => 'L',
        'FILE'     => 'F',
        'RELATION' => 'E'
    ];

    public function __construct() {
        $this->service = new CIBlockProperty;
    }

    public function create($sIblockCode, $data){
        $arFields = [
            'ACTIVE'           => isset($data['ACTIVE']) ? $data['ACTIVE'] : 'Y',
            'NAME'             => $data['NAME'],
            'CODE'             => $data['CODE'],
            'SORT'             => isset($data['SORT']) ? $data['SORT'] : 500,
            'PROPERTY_TYPE'    => isset($this->property_types[$data['TYPE']]) ? $this->property_types[$data['TYPE']] : 'S',
            'IBLOCK_ID'        => $this->getIblockId($sIblockCode),
            'MULTIPLE'         => isset($data['MULTIPLE']) ? $data['MULTIPLE'] : 'N',
            'IS_REQUIRED'      => isset($data['REQUIRED']) ? $data['REQUIRED'] : 'N',
            'WITH_DESCRIPTION' => isset($data['DESCRIPTION']) ? $data['DESCRIPTION'] : 'N',
        ];

        //визуальный редактор
        if($data['TYPE'] === 'EDITOR'){
            $arFields['PROPERTY_TYPE'] = 'S';
            $arFields['USER_TYPE'] = 'HTML';
        }

        //description field in upload field for file
        if($data['TYPE'] == 'FILE' && $data['DESCRIPTION'] == 'Y'){
            CUserOptions::SetOption(
                'main',
                'fileinput',
                [
                    'mode' => 'mode-file',
                    'presets' => '',
                    'pinDescription' => 'Y',
                ],
                true,
                0
            );
        }

        //for type RELATION
        if(isset($data['LINK_IBLOCK_CODE'])){
            $arFields['LINK_IBLOCK_ID'] = $this->getIblockId($data['LINK_IBLOCK_CODE']);
        }

        // for type LIST
        if(isset($data['VALUES'])){
            $arFields['VALUES'] = $data['VALUES'];
        }

        $this->service->Add($arFields);
        return $this;
    }

    public function update($sIblockCode, $sPropertyCode, $arFields){
        $this->service->Update(
            $this->getId($sIblockCode, $sPropertyCode),
            $arFields
        );
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

    public function getId($sIblockCode, $sPropertyCode){
        $arFilter = [
            'CODE' => $sPropertyCode,
            'IBLOCK_CODE' => $sIblockCode
        ];

        $obProperties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), $arFilter);
        if ($arProp = $obProperties->GetNext()){
            return $arProp['ID'];
        }else{
            echo 'IBlockProperty ' . $sPropertyCode . ' not found\n';
            die();
        }
    }


    public function delete($sIblockCode, $sPropertyCode){
        $arFilter = [
            'IBLOCK_CODE' => $sIblockCode,
            'CODE' => $sPropertyCode
        ];
        $properties = CIBlockProperty::GetList(Array('sort'=>'asc', 'name'=>'asc'), $arFilter);
        while ($prop_fields = $properties->GetNext())
        {
            CIBlockProperty::Delete($prop_fields['ID']);
        }
    }
}
