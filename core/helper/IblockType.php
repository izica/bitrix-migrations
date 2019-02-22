<?php
namespace Izica;

use CIBlockType;

class IBlockType extends Helper {
    private $arFields = [
        'SORT' => 500
    ];
    private $arRequired = [
        'ID',
        'LANG'
    ];

    function __construct($arFields) {
        $this->setFields($arFields);
        return $this;
    }

    public function create() {
        $this->checkRequired('IBLOCK_TYPE', $this->arRequired, $this->arFields);
        $obInstance = new CIBlockType;
        $dbRes = $obInstance->Add($this->arFields);
        if (!$dbRes) {
            MigrationLog::add('IBLOCK_TYPE, ' . $this->arFields['ID'], $obInstance->LAST_ERROR);
            MigrationLog::show(true);
        } else {
            MigrationLog::add('OK', "IBlockType " . $this->arFields['ID'] . " created");
        }
    }

    public function delete($id) {
        MigrationLog::add('OK', "IBlockType " . $id . " deleted");
        CIBlockType::Delete($id);
    }

    public function setId($value) {
        $this->arFields['ID'] = $value;
        return $this;
    }

    public function setName($value) {
        $this->arFields['LANG'] = [
            'en' => [
                'NAME' => $value,
            ],
            'ru' => [
                'NAME' => $value,
            ]
        ];
        return $this;
    }
}
