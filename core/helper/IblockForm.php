<?php

class IblockForm
{
    private $iblock_id = Array();
    private $service;
    private $prefix = 'form_element_';

    public function __construct() {
        $this->service = new CIBlockProperty;
    }

    public function element(){
        $this->prefix = 'form_element_';
        return $this;
    }

    public function section(){
        $this->prefix = 'form_section_';
        return $this;
    }

    public function set($sIblockCode, $data){
        $iblock_id = $this->find($sIblockCode);
        $sName = $this->prefix . $iblock_id;
        CUserOptions::DeleteOptionsByName('form', $sName);

        CUserOptions::SetOption(
            'form',
            $sName,
            ['tabs' => $this->getValue($sIblockCode, $data)],
            true,
            0
        );
    }

    public function getValue($sIblockCode, $tabs){
        $result = [];
        $tabCounter = 0;
        foreach ($tabs as $tabName => $tabItems) {
            $tabCounter++;
            $result[$tabName] = [
                '--cedit' . $tabCounter . '--#--' . $tabName . '--'
            ];
            foreach ($tabItems as $sItemName => $sItemCode) {
                $sItemCode = $this->parseItemCode($sIblockCode, $sItemCode);
                $result[$tabName][] = '--' . $sItemCode . '--#--' . $sItemName . '--';
            }
            $result[$tabName] = implode(',', $result[$tabName]);
        }
        $result = implode(';', $result);

        return substr($result, 2) . ';--';
    }

    public function parseItemCode($sIblockCode, $sPropertyName){
        $arPropertyCode = explode('_', $sPropertyName);
        if(count($arPropertyCode) < 2 || $arPropertyCode[0] != 'PROPERTY'){
            return $sPropertyName;
        }
        unset($arPropertyCode[0]);
        $sPropertyCode = implode('_', $arPropertyCode);

        $arFilter = [
            'CODE' => $sPropertyCode,
            'IBLOCK_CODE' => $sIblockCode
        ];

        $obProperties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), $arFilter);
        if ($arProp = $obProperties->GetNext()){
            return 'PROPERTY_' . $arProp['ID'];
        }else{
            echo 'IBlockProperty ' . $sPropertyName . ' not found\n';
            die();
        }
    }

    public function find($code){
        $res = CIBlock::GetList(Array(), ['SITE_ID' => SITE_ID, 'CODE' => $code], true);
        if($ar_res = $res->Fetch()) {
            return $ar_res['ID'];
        } else {
            echo 'IBlock ' . $code . " not found\n";
            die();
        }
    }
}
