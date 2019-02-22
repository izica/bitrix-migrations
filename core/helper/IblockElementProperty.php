<?php

namespace Izica;

class IBlockElementProperty extends Helper {
    private $arFields = [
        'ACTIVE'        => 'Y',
        'SORT'          => 500,
        'PROPERTY_TYPE' => 'S',
        'MULTIPLE'      => 'N',
        'IS_REQUIRED'   => 'N'
    ];

    private $arRequired = [
        'NAME',
        'CODE',
        'ACTIVE',
        'PROPERTY_TYPE',
        'SORT',
        'IBLOCK_ID',
        'MULTIPLE',
        'IS_REQUIRED'
    ];

    function __construct($arFields) {
        $this->setFields($arFields);
        return $this;
    }

    public function setFields($arFields) {
        foreach ($arFields as $key => $value){
            $this->arFields[$key] = $value;
        }
        return $this;
    }

    public function setField($key, $value) {
        $this->arFields[$key] = $value;
        return $this;
    }

    public function create() {
        $this->requiredExtension();
        $this->checkRequired('IBLOCK_ELEMENT_PROPERTY', $this->arRequired, $this->arFields);
        $obInstance = new \CIBlockProperty;
        $dbRes = $obInstance->Add($this->arFields);
        if (!$dbRes) {
            MigrationLog::add('IBLOCK_ELEMENT_PROPERTY, ' . $this->arFields['CODE'], \Cutil::translit(
                str_replace('<br>', '', $obInstance->LAST_ERROR),
                "ru",
                [
                    'replace_space' => ' ',
                    'change_case'   => false,
                    'replace_other' => false
                ]
            ));
            MigrationLog::show(true);
        } else {
            MigrationLog::add('OK', "IBlockElementProperty " . $this->arFields['CODE'] . " was created");
        }
        return $this;
    }

    public function requiredExtension() {
        if ($this->arFields['PROPERTY_TYPE'] == 'E') {
            $this->arRequired[] = 'LINK_IBLOCK_ID';
        }
        if ($this->arFields['PROPERTY_TYPE'] == 'L') {
            $this->arRequired[] = 'VALUES';
        }
    }

    public function delete($sIblockCode, $sPropertyCode) {
        $arFilter = [
            'IBLOCK_CODE' => $sIblockCode,
            'CODE'        => $sPropertyCode
        ];
        $dbProperties = \CIBlockProperty::GetList(['sort' => 'asc', 'name' => 'asc'], $arFilter);
        if ($arProperty = $dbProperties->GetNext()) {
            \CIBlockProperty::Delete($arProperty['ID']);
            MigrationLog::add('OK', "IBlockElementProperty " . $sIblockCode . " was deleted");
        } else {
            MigrationLog::add('IBLOCK_ELEMENT_PROPERTY', "IBlockElementProperty " . $sIblockCode . '->' . $sIblockCode . " not found");
        }
    }

    public function setName($value) {
        $this->arFields['NAME'] = $value;
        return $this;
    }

    public function setActive($value) {
        $this->arFields['ACTIVE'] = $value;
        return $this;
    }

    public function setIBlockCode($value) {
        $this->arFields['IBLOCK_ID'] = $this->getIblockId($value);
        return $this;
    }

    public function setCode($value) {
        $this->arFields['CODE'] = $value;
        return $this;
    }

    public function setSort($value) {
        $this->arFields['SORT'] = $value;
        return $this;
    }

    public function setRequired($bool = true) {
        $this->arFields['SORT'] = $bool;
        return $this;
    }

    public function setMultiple($bool = true) {
        $this->arFields['MULTIPLE'] = $bool;
        return $this;
    }

    public function setPropertyType($value) {
        $this->arFields['PROPERTY_TYPE'] = $value;
        return $this;
    }

    public function setUserType($value) {
        $this->arFields['USER_TYPE'] = $value;
        return $this;
    }

    public function setIblockLink($sIblockCode) {
        $this->arFields['LINK_IBLOCK_ID'] = $this->getIblockId($sIblockCode);
        return $this;
    }

    public function setTypeString() {
        $this->arFields['PROPERTY_TYPE'] = 'S';
        return $this;
    }

    public function setTypeLink() {
        $this->arFields['PROPERTY_TYPE'] = 'E';
        return $this;
    }

    public function setTypeList() {
        $this->arFields['PROPERTY_TYPE'] = 'L';
        return $this;
    }

    public function setListValues($array) {
        $this->arFields['VALUES'] = $array;
        return $this;
    }

    public function setTypeFile() {
        $this->arFields['PROPERTY_TYPE'] = 'S';
        return $this;
    }

    public function setTypeHtmlEditor() {
        $this->arFields['PROPERTY_TYPE'] = 'S';
        $this->arFields['USER_TYPE'] = 'HTML';
        return $this;
    }

    public function setTypeCheckbox($value = 'Да') {
        $this->arFields['LIST_TYPE'] = 'C';
        $this->arFields['VALUES'] = [
            [
                'XML_ID' => 'CHECKED',
                'DEF'    => 'N',
                'SORT'   => '500',
                'VALUE'  => $value
            ]
        ];
        return $this;
    }
}
