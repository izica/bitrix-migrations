<?php

/**
 * Class Migration
 */
class Migration {
    /**
     * @var IBlockType
     */
    public $IBlockType;
    /**
     * @var IBlock
     */
    public $IBlock;
    /**
     * @var IBlockElementProperty
     */
    public $IBlockElementProperty;
    /**
     * @var IBlockSectionProperty
     */
    public $IBlockSectionProperty;

    /**
     * Migration constructor.
     */
    public function __construct() {
        $this->IBlockType = new IBlockType();
        $this->IBlock = new IBlock();
        $this->IBlockElementProperty = new IBlockElementProperty();
        $this->IBlockSectionProperty = new IBlockSectionProperty();
    }
}
