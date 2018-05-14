<?php

class CreateEmployersIblock extends MigrationAbstract
{
    public function up(){
        $sIblockCode = 'employers';

        $this->iblock->create([
            'NAME' => 'Работодатели',
            'CODE' => $sIblockCode,
            'IBLOCK_TYPE_ID' => 'information'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Ответственный',
            'CODE' => 'CONTACT_NAME',
            'TYPE' => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Документы',
            'CODE' => 'FILES',
            'TYPE' => 'FILE',
            'MULTIPLE' => 'Y'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Фотографии',
            'CODE' => 'IMAGES',
            'TYPE' => 'FILE',
            'MULTIPLE' => 'Y'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Название',
            'CODE' => 'NAME_EN',
            'TYPE' => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Ответственный',
            'CODE' => 'CONTACT_NAME_EN',
            'TYPE' => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Документы',
            'CODE' => 'FILES_EN',
            'TYPE' => 'FILE',
            'MULTIPLE' => 'Y'
        ]);

        $this->iblock_form->element()->set($sIblockCode, [
            'Работодатель' => [
                'Изменен'                         => 'TIMESTAMP_X',
                'Активность'                      => 'ACTIVE',
                'Название'                        => 'NAME',
                'Символьный код'                  => 'CODE',
                'Фото анонса'                     => 'PREVIEW_PICTURE',
                'Детальное фото'                  => 'DETAIL_PICTURE',
                'Фотографии'                      => 'PROPERTY_IMAGES',
            ],
            'Русская Версия' => [
                'Ответственный'     => 'PROPERTY_CONTACT_NAME',
                'Документы'         => 'PROPERTY_FILES',
                'Описание'          => 'PREVIEW_TEXT',
            ],
            'Английская версия' => [
                'Название'          => 'PROPERTY_NAME_EN',
                'Ответственный'     => 'PROPERTY_CONTACT_NAME_EN',
                'Документы'         => 'PROPERTY_FILES_EN',
                'Описание'          => 'DETAIL_TEXT',
            ],
        ]);

        $this->iblock_section_property->create($sIblockCode, [
            'NAME' => 'Название(Англ)',
            'CODE' => 'UF_NAME_EN',
            'TYPE' => 'STRING',
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
            "CONDITION" => "#^/employers/([0-9a-zA-Z_-]+)(\\?(.*))?#",
            "PATH" => "/employers/index.php",
            "RULE" => "CODE=$1"
        ]);
    }

    public function down(){
        $this->iblock->delete('employers');
    }
}
