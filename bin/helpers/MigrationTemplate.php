<?php
class MigrationTemplate
{
    public $iblock_type;
    public $iblock;
    public $url_rewrite;

    public function __construct() {
        $this->iblock_type = new IblockType();
        $this->iblock = new Iblock();
        $this->url_rewrite = new UrlRewrite();
    }
}
