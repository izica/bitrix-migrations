<?php
use Izica\Migration;

class InformationIBlockType1541960097 extends Migration {
    public function up() {
        $this->IBlockType
            ->setId('information')
            ->setName('Информация')
            ->create();
    }

    public function down() {
        $this->IBlockType->delete('information');
    }
}
