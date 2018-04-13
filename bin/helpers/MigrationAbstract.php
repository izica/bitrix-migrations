<?php
class MigrationAbstract
{
    public $iblock_type;
    public $iblock;
    public $iblock_form;
    public $iblock_element_property;
    public $iblock_section_property;
    public $url_rewrite;

    public function __construct() {
        $this->iblock_type = new IblockType();
        $this->iblock = new Iblock();
        $this->iblock_form = new IblockForm();
        $this->iblock_element_property = new IblockElementProperty();
        $this->iblock_section_property = new IblockSectionProperty();
        $this->url_rewrite = new UrlRewrite();
    }
}
