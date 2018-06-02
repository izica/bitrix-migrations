<?php

class CreateIdeasIblock extends MigrationAbstract
{
    public function up(){
        $sIblockCode = 'ideas';

        $this->iblock->create([
            'NAME' => 'IDEAS',
            'CODE' => $sIblockCode,
            'IBLOCK_TYPE_ID' => 'information',
            'DETAIL_PAGE_URL' => '/ideas/#CODE#'
        ]);

        $this->iblock->setCodeTransliteration($sIblockCode);
        $this->iblock->setCodeRequired($sIblockCode);
        $this->iblock->setCodeUnique($sIblockCode);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Фотографии',
            'CODE' => 'IMAGES',
            'TYPE' => 'FILE',
            'MULTIPLE' => 'Y'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Количество лайков',
            'CODE' => 'LIKES',
            'TYPE' => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Контакты автора',
            'CODE' => 'AUTHOR_CONTACTS',
            'TYPE' => 'STRING',
            'MULTIPLE' => 'Y'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Автор',
            'CODE' => 'AUTHOR',
            'TYPE' => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Факультет и группа',
            'CODE' => 'FACULTY',
            'TYPE' => 'STRING'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Документы',
            'CODE' => 'FILES',
            'TYPE' => 'FILE',
            'MULTIPLE' => 'Y'
        ]);

        //English

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Название',
            'CODE' => 'NAME_EN',
            'TYPE' => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Автор',
            'CODE' => 'AUTHOR_EN',
            'TYPE' => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Факультет и группа',
            'CODE' => 'FACULTY_EN',
            'TYPE' => 'STRING'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME' => 'Документы',
            'CODE' => 'FILES_EN',
            'TYPE' => 'FILE',
            'MULTIPLE' => 'Y'
        ]);


        $this->iblock_form->element()->set($sIblockCode, [
            'Сотрудник' => [
                'Изменен'               => 'TIMESTAMP_X',
                'Активность'            => 'ACTIVE',
                'Название'              => 'NAME',
                'Символьный код'        => 'CODE',
                'Анонс изображение'     => 'PREVIEW_PICTURE',
                'Детальное изображение' => 'DETAIL_PICTURE',
                'Изображения'           => 'PROPERTY_IMAGES',
            ],
            'Русская Версия' => [
                'Имя автора'         => 'PROPERTY_AUTHOR',
                'Контакты автора'    => 'PROPERTY_AUTHOR_CONTACTS',
                'Факультет и группа' => 'PROPERTY_FACULTY',
                'Документы'          => 'PROPERTY_FILES',
                'Описание'           => 'PREVIEW_TEXT',
            ],
            'Английская версия' => [
                'Название'           => 'PROPERTY_NAME_EN',
                'Имя автора'         => 'PROPERTY_AUTHOR_EN',
                'Факультет и группа' => 'PROPERTY_FACULTY_EN',
                'Документы'          => 'PROPERTY_FILES_EN',
                'Описание'           => 'DETAIL_TEXT',
            ],
            'Категория' => [
                'Категория' => 'SECTIONS'
            ]
        ]);

        $this->iblock_section_property->create($sIblockCode, [
            'NAME'             => 'Название(Англ)',
            'CODE'             => 'UF_NAME_EN',
            'TYPE'             => 'STRING',
        ]);

        $this->iblock_form->section()->set($sIblockCode, [
            'Факультет/кафедра' => [
                'Активность'     => 'ACTIVE',
                'Название'       => 'NAME',
                'Название(Англ)' => 'UF_NAME_EN',
                'Символьный код' => 'CODE',
                'Иконка'         => 'PICTURE'
            ],
        ]);

        $this->url_rewrite->create([
            "CONDITION" => "#^/ideas/([0-9a-zA-Z_-]+)(\\?(.*))?#",
            "PATH" => "/ideas/detail.php",
            "RULE" => "CODE=$1"
        ]);
    }

    public function down(){
        $this->iblock->delete('ideas');

        $this->url_rewrite->delete([
            "CONDITION" => "#^/ideas/([0-9a-zA-Z_-]+)(\\?(.*))?#",
        ]);
    }
}
