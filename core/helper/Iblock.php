<?php
namespace Izica;

use CIBlock;
use CUtil;

class IBlock extends Helper {
    private $arFields = [
        'ACTIVE' => 'Y',
        'SITE_ID' => 's1',
        'SORT' => 500,
        'GROUP_ID' => ['2' => 'R']
    ];

    private $arRequired = [
        'NAME',
        'CODE',
        'ACTIVE',
        'IBLOCK_TYPE_ID',
        'SITE_ID',
        'SORT',
        'GROUP_ID',
    ];

    function __construct($arFields) {
        $this->setFields($arFields);
        return $this;
    }

    public function create() {
        $this->checkRequired('IBLOCK', $this->arRequired, $this->arFields);
        $obInstance = new CIBlock;
        $dbRes = $obInstance->Add($this->arFields);
        if (!$dbRes) {
            MigrationLog::add('IBLOCK, ' . $this->arFields['CODE'], Cutil::translit(
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
            MigrationLog::add('OK', "IBlockType " . $this->arFields['CODE'] . " created");
        }
        return $this;
    }

    public function delete($iBlockCode) {
        MigrationLog::add('OK', "IBlock " . $iBlockCode . " deleted");
        CIBlock::Delete($this->getIblockId($iBlockCode));
    }

    public function setCode($value) {
        $this->arFields['CODE'] = $value;
        return $this;
    }

    public function setName($value) {
        $this->arFields['NAME'] = $value;
        return $this;
    }

    public function setActive($value) {
        $this->arFields['ACTIVE'] = $value;
        return $this;
    }

    public function setIBlockType($value) {
        $this->arFields['IBLOCK_TYPE_ID'] = $value;
        return $this;
    }

    public function setSiteId($value) {
        $this->arFields['SITE_ID'] = $value;
        return $this;
    }

    public function setCodeUnique($sIblockCode) {
        $nIblockId = $this->getIblockId($sIblockCode);
        $arFields = CIBlock::getFields($nIblockId);
        $arFields['CODE']['DEFAULT_VALUE']['UNIQUE'] = 'Y';
        CIBlock::setFields($nIblockId, $arFields);
        return $this;
    }

    public function setCodeTransliteration($sIblockCode) {
        $nIblockId = $this->getIblockId($sIblockCode);
        $arFields = CIBlock::getFields($nIblockId);
        $arFields['CODE']['DEFAULT_VALUE']['TRANSLITERATION'] = 'Y';
        CIBlock::setFields($nIblockId, $arFields);
        return $this;
    }

    public function setCodeRequired($sIblockCode) {
        $nIblockId = $this->getIblockId($sIblockCode);
        $arFields = CIBlock::getFields($nIblockId);
        $arFields['CODE']['IS_REQUIRED'] = 'Y';
        CIBlock::setFields($nIblockId, $arFields);
        return $this;
    }


}
