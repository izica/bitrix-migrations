<?php

class CreateOverviewIblock extends MigrationAbstract
{
    public function up(){
        $sIblockCode = 'overview';

        $this->iblock->create([
            'NAME' => 'Генерирующий раздел',
            'CODE' => $sIblockCode,
            'IBLOCK_TYPE_ID' => 'information'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Название',
            'CODE' => 'NAME_EN',
            'TYPE' => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'     => 'Прикрепленнные элементы(ссылки)',
            'CODE'     => 'ELEMENTS',
            'TYPE'     => 'RELATION',
            'MULTIPLE' => 'Y'
        ]);

        $this->iblock_form->element()->set($sIblockCode, [
            'Элемент генерирующего раздела' => [
                'Изменен'                         => 'TIMESTAMP_X',
                'Активность'                      => 'ACTIVE',
                'Название'                        => 'NAME',
                'Ссылка'                          => 'CODE',
                'Прикрепленнные элементы(ссылки)' => 'PROPERTY_ELEMENTS',
                'Картинка'                        => 'PREVIEW_PICTURE',
                'Раздел'                          => 'SECTIONS',
            ],
            'Русская Версия' => [
                'Описание'           => 'PREVIEW_TEXT',
            ],
            'Английская версия' => [
                'Название'           => 'PROPERTY_NAME_EN',
                'Описание'           => 'DETAIL_TEXT',
            ],
        ]);

        $this->iblock_section_property->create($sIblockCode, [
            'NAME'             => 'Название(Англ)',
            'CODE'             => 'UF_NAME_EN',
            'TYPE'             => 'STRING',
        ]);

        $this->iblock_form->section()->set($sIblockCode, [
            'Раздел' => [
                'Активность'     => 'ACTIVE',
                'Название'       => 'NAME',
                'Название(Англ)' => 'UF_NAME_EN',
                'Символьный код' => 'CODE',
            ],
        ]);

        $this->url_rewrite->create([
            "CONDITION" => "#^/overview/([0-9a-zA-Z_-]+)(\\?(.*))?#",
            "PATH" => "/overview/index.php",
            "RULE" => "SECTION_CODE=$1"
        ]);
    }

    public function down(){
        $this->iblock->delete('overview');
    }
}
