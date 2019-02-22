<?php

namespace Izica;

use CIBlock;

/**
 * Class Migration
 * @package Izica
 */
class Migration {
    /**
     * @param array $arFields
     * @return IBlockType
     */
    public function iblockType($arFields = []) {
        return new IBlockType($arFields);
    }

    /**
     * @param array $arFields
     * @return IBlock
     */
    public function iblock($arFields = []) {
        return new IBlock($arFields);
    }

    /**
     * @param array $arFields
     * @return IBlockElementProperty
     */
    public function iblockElementProperty($arFields = []) {
        return new IBlockElementProperty($arFields);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getIblockIdByCode($value) {
        $dbResult = CIBlock::GetList([], ['SITE_ID' => SITE_ID, 'CODE' => $value], true);
        if ($arResult = $dbResult->Fetch()) {
            return $arResult['ID'];
        } else {
            MigrationLog::add('IBLOCK_CODE_NOT_FOUND', $value);
            MigrationLog::show(true);
        }
    }
}
