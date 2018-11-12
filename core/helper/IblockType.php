<?php

class IBlockType extends Helper {
    private $arFields = [
        'SORT' => 500
    ];
    private $arRequired = [
        'ID',
        'LANG'
    ];

    public function setFields($fields) {
        $this->arFields = $fields;
        return $this;
    }

    public function setField($key, $value) {
        $this->arFields[$key] = $value;
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
            MigrationLog::add('OK', "IBlockType " . $this->arFields['ID'] . " was created");
        }
    }

    public function delete($id) {
        MigrationLog::add('OK', "IBlockType " . $id . " was deleted");
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
