<?php

class IblockType
{
    private $service;

    public function __construct() {
        $this->service = new CIBlockType;
    }

    public function create($data){
        $arFields = [
            'ID'       => isset($data['CODE']) ? $data['CODE'] : $data['ID'],
            'SECTIONS' => 'Y',
            'IN_RSS'   => 'N',
            'SORT'     => isset($data['SORT']) ? $data['SORT'] : 500,
            'LANG'     => [
                'en' => [
                    'NAME' => isset($data['NAME_EN']) ? $data['NAME_EN'] : $data['NAME'],
                ],
                'ru' => [
                    'NAME' => isset($data['NAME_RU']) ? $data['NAME_RU'] : $data['NAME'],
                ]
            ]
        ];
        $this->service->Add($arFields);
    }

    public function delete($code){
        CIBlockType::Delete($code);
    }
}
