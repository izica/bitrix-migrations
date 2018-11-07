<?php

class CreatePopularIblock extends Migration
{
    public function up(){
        $sIblockCode = 'popular';

        $this->iblock->create([
            'NAME' => 'Популярное',
            'CODE' => $sIblockCode,
            'IBLOCK_TYPE_ID' => 'information'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'     => 'Прикрепленнные элементы',
            'CODE'     => 'ELEMENTS',
            'TYPE'     => 'RELATION',
            'MULTIPLE' => 'Y'
        ]);

        $this->iblock_form->element()->set($sIblockCode, [
            'Популярное' => [
                'Изменен' => 'TIMESTAMP_X',
                'Активность' => 'ACTIVE',
                'Название' => 'NAME',
                'Ссылка' => 'CODE',
                'Прикрепленнные элементы' => 'PROPERTY_ELEMENTS',
            ],
        ]);
    }

    public function down(){
        $this->iblock->delete('popular');
    }
}
