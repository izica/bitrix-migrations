<?php

class CreateVacanciesIblock extends MigrationAbstract
{
    public function up(){
        die();
        $sIblockCode = 'vacancies';

        $this->iblock->create([
            'NAME' => 'Вакансии работодателей',
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
    }

    public function down(){
        $this->iblock->delete('vacancies');
    }
}
