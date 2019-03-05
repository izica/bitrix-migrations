<?php

namespace Izica;

use CIBlock;

/**
 * Class Migration
 * @package Izica
 */
class Migration
{
    /**
     * @var array
     */
    public $arBuffer = [];

    /**
     * @param $message
     * @param string $code
     */
    public function log($message, $code = 'MIGRATION_LOG')
    {
        MigrationLog::add($code, $message);
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->arBuffer[$key] = json_encode($value);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return json_decode($this->arBuffer[$key], true);
    }

    /**
     * @return false|string
     */
    public function getBuffer()
    {
        return json_encode($this->arBuffer);
    }

    /**
     * @param $arBuffer
     */
    public function setBuffer($arBuffer)
    {
        $this->arBuffer = json_decode($arBuffer, true);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getIblockIdByCode($value)
    {
        $dbResult = CIBlock::GetList([], ['SITE_ID' => SITE_ID, 'CODE' => $value], true);
        if ($arResult = $dbResult->Fetch()) {
            return $arResult['ID'];
        } else {
            MigrationLog::add('IBLOCK_CODE_NOT_FOUND', $value);
            MigrationLog::show(true);
        }
    }
}
