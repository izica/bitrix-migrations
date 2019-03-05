<?php

namespace Izica;

use CIBlock;

/**
 * Class Migration
 * @package Izica
 */
class Migration {
    /**
     * @var array
     */
    public $arBuffer = [];

    /**
     * @param $message
     * @param string $code
     */
    public function log($message, $code = 'MIGRATION_LOG') {
        MigrationLog::add($code, $message);
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $this->arBuffer[$key] = json_encode($value);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key) {
        if (!isset($this->arBuffer[$key])) {
            MigrationLog::add('BUFFER_DATA_NOT_FOUND', 'Migration buffer data not found by key:' . $key);
            return false;
        }
        return json_decode($this->arBuffer[$key], true);
    }

    /**
     * @return false|string
     */
    public function getBuffer() {
        return json_encode($this->arBuffer);
    }

    /**
     * @param $arBuffer
     */
    public function setBuffer($arBuffer) {
        $this->arBuffer = json_decode($arBuffer, true);
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getIblockIdByCode($code) {
        $arFilter = [
            "CHECK_PERMISSIONS" => "N",
            'CODE' => $code
        ];

        $dbResult = CIBlock::GetList([], $arFilter, true);
        if ($arResult = $dbResult->Fetch()) {
            return $arResult['ID'];
        } else {
            MigrationLog::add('IBLOCK_CODE_NOT_FOUND', $code);
            MigrationLog::show(true);
        }
    }
}
