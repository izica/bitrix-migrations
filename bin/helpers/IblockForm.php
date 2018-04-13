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

    public function set($iblock_code, $data){
        $iblock_id = $this->find($iblock_code);
        $sName = $this->prefix . $iblock_id;
        CUserOptions::DeleteOptionsByName('form', $sName);

        CUserOptions::SetOption(
            'form',
            $sName,
            ['tabs' => $this->getValue($data)],
            true,
            0
        );
    }

    public function getValue($tabs){
        $result = [];
        $tabCounter = 0;
        foreach ($tabs as $tabName => $tabItems) {
            $tabCounter++;
            $result[$tabName] = [
                '--cedit' . $tabCounter . '--#--' . $tabName . '--'
            ];
            foreach ($tabItems as $itemName => $itemCode) {
                $result[$tabName][] = '--' . $itemCode . '--#--' . $itemName . '--';
            }
            $result[$tabName] = implode(',', $result[$tabName]);
        }
        $result = implode(';', $result);

        return substr($result, 2) . ';--';
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
