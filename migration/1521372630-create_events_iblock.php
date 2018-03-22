<?php

class CreateEventsIblock extends MigrationTemplate
{
    public function up(){
        $this->iblock->create([
            'NAME' => 'События',
            'CODE' => 'events',
            'IBLOCK_TYPE_ID' => 'information',
            'CODE_TRANSLIT' => true
        ]);
    }

    public function down(){
        $this->iblock->delete('events');
    }
}
