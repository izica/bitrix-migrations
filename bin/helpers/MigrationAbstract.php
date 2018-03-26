<?php
class MigrationAbstract
{
    public $iblock_type;
    public $iblock;
    public $iblock_property;
    public $url_rewrite;

    public function __construct() {
        $this->iblock_type = new IblockType();
        $this->iblock = new Iblock();
        $this->iblock_property = new IblockProperty();
        $this->url_rewrite = new UrlRewrite();
    }
}
