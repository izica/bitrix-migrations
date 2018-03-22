<?php

class CreateNewsIblock extends MigrationTemplate
{
    public function up(){
        $this->iblock_type->create([
            'NAME' => 'Информация',
            'CODE' => 'information'
        ]);

        $this->iblock->create([
            'NAME' => 'Новости',
            'CODE' => 'news',
            'IBLOCK_TYPE_ID' => 'information',
            'CODE_TRANSLIT' => true
        ]);
    }

    public function down(){
        $this->iblock->delete('news');
        $this->iblock_type->delete('information');
    }
}
