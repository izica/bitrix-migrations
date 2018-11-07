<?php

class IblocksFilesAddDescriptionFields extends Migration
{
    public function up(){
        $this->iblock_element_property->update('employees', 'FILES', [
            'DESCRIPTION'      => 'Y'
        ]);
        $this->iblock_element_property->update('employees', 'FILES_EN', [
            'DESCRIPTION'      => 'Y'
        ]);

        $this->iblock_element_property->update('graduates', 'FILES', [
            'DESCRIPTION'      => 'Y'
        ]);
        $this->iblock_element_property->update('graduates', 'FILES_EN', [
            'DESCRIPTION'      => 'Y'
        ]);

        $this->iblock_element_property->update('ideas', 'FILES', [
            'DESCRIPTION'      => 'Y'
        ]);
        $this->iblock_element_property->update('ideas', 'FILES_EN', [
            'DESCRIPTION'      => 'Y'
        ]);

        
        $this->iblock_element_property->update('ideas', 'FILES', [
            'DESCRIPTION'      => 'Y'
        ]);
        $this->iblock_element_property->update('ideas', 'FILES_EN', [
            'DESCRIPTION'      => 'Y'
        ]);
    }

    public function down(){
    }
}
