<?php
class MigrationTemplate
{
    public $iblock_type;
    public $iblock;

    public function __construct() {
        $this->iblock_type = new IblockType();
        $this->iblock = new Iblock();
    }
}
