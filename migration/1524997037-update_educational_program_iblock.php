<?php

class UpdateEducationalProgramIblock extends MigrationAbstract
{
    public function up(){
        $sIblockCode = 'educational-programs';

        $this->iblock->update($sIblockCode, [
            'NAME' => 'Образовательные программы',
            'DETAIL_PAGE_URL' => '/educational-programs/#CODE#'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'             => 'Руководитель программы и ассистенты',
            'CODE'             => 'EMPLOYEES',
            'TYPE'             => 'RELATION',
            'LINK_IBLOCK_CODE' => 'employees',
            'MULTIPLE'         => 'Y',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'             => 'Документ об образовании',
            'CODE'             => 'EDUCATION_DOCUMENT',
            'TYPE'             => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'             => 'Стоимость',
            'CODE'             => 'COST',
            'TYPE'             => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'             => 'Язык',
            'CODE'             => 'LANGUAGE',
            'TYPE'             => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'             => 'Документы',
            'CODE'             => 'FILES',
            'TYPE'             => 'FILE',
            'MULTIPLE'         => 'Y',
            'DESCRIPTION'      => 'Y'
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'             => 'Документ об образовании',
            'CODE'             => 'EDUCATION_DOCUMENT_EN',
            'TYPE'             => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'             => 'Стоимость',
            'CODE'             => 'COST_EN',
            'TYPE'             => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'             => 'Язык',
            'CODE'             => 'LANGUAGE_EN',
            'TYPE'             => 'STRING',
        ]);

        $this->iblock_element_property->create($sIblockCode, [
            'NAME'             => 'Документы',
            'CODE'             => 'FILES_EN',
            'TYPE'             => 'FILE',
            'MULTIPLE'         => 'Y',
            'DESCRIPTION'      => 'Y'
        ]);

        $this->iblock_form->element()->set($sIblockCode, [
            'Образовательная программа' => [
                'Изменен'                             => 'TIMESTAMP_X',
                'Активность'                          => 'ACTIVE',
                'Название'                            => 'NAME',
                'Символьный код'                      => 'CODE',
                'Картинка для анонса'                 => 'PREVIEW_PICTURE',
                'Детальная картинка'                  => 'DETAIL_PICTURE',
                'Руководитель программы и ассистенты' => 'PROPERTY_EMPLOYEES',
            ],
            'Русская Версия' => [
                'Срок обучения'           => 'PROPERTY_STUDY_DURATION',
                'Тип направления'         => 'PROPERTY_DIVISION_TYPE',
                'Форма обучения'          => 'PROPERTY_STUDY_MODE',
                'Форма обучения'          => 'PROPERTY_STUDY_MODE',
                'Документ об образовании' => 'PROPERTY_EDUCATION_DOCUMENT',
                'Стоимость'               => 'PROPERTY_COST',
                'Языка'                   => 'PROPERTY_LANGUAGE',
                'Документы'               => 'PROPERTY_FILES',
                'Описание анонса'         => 'PREVIEW_TEXT',
                'Детальное описание'      => 'DETAIL_TEXT'
            ],
            'Английская версия' => [
                'Название'                => 'PROPERTY_NAME_EN',
                'Срок обучения'           => 'PROPERTY_STUDY_DURATION_EN',
                'Тип направления'         => 'PROPERTY_DIVISION_TYPE_EN',
                'Форма обучения'          => 'PROPERTY_STUDY_MODE_EN',
                'Форма обучения'          => 'PROPERTY_STUDY_MODE_EN',
                'Документ об образовании' => 'PROPERTY_EDUCATION_DOCUMENT_EN',
                'Стоимость'               => 'PROPERTY_COST_EN',
                'Языка'                   => 'PROPERTY_LANGUAGE_EN',
                'Документы'               => 'PROPERTY_FILES_EN',
                'Описание анонса'         => 'PROPERTY_PREVIEW_TEXT_EN',
                'Детальное описание'      => 'PROPERTY_DETAIL_TEXT_EN'
            ],
            'Факультет' => [
                'Факультет' => 'SECTIONS'
            ]
        ]);

        $this->iblock_form->section()->set($sIblockCode, [
            'Тип обучения - Факультет' => [
                'Активность'     => 'ACTIVE',
                'Название'       => 'NAME',
                'Название(Англ)' => 'UF_NAME_EN',
                'Тип обучения'   => 'IBLOCK_SECTION_ID'
            ],
        ]);

        $this->url_rewrite->create([
            "CONDITION" => "#^/educational-programs/([0-9a-zA-Z_-]+)(\\?(.*))?#",
            "PATH" => "/educational-programs/detail.php",
            "RULE" => "CODE=$1"
        ]);
    }

    public function down(){
        $sIblockCode = 'educational-programs';

        $this->iblock_element_property->delete($sIblockCode, 'EMPLOYEES');
        $this->iblock_element_property->delete($sIblockCode, 'EDUCATION_DOCUMENT');
        $this->iblock_element_property->delete($sIblockCode, 'COST');
        $this->iblock_element_property->delete($sIblockCode, 'LANGUAGE');
        $this->iblock_element_property->delete($sIblockCode, 'FILES');
        $this->iblock_element_property->delete($sIblockCode, 'EDUCATION_DOCUMENT_EN');
        $this->iblock_element_property->delete($sIblockCode, 'COST_EN');
        $this->iblock_element_property->delete($sIblockCode, 'LANGUAGE_EN');
        $this->iblock_element_property->delete($sIblockCode, 'FILES_EN');

        $this->url_rewrite->delete([
            "CONDITION" => "#^/educational-programs/([0-9a-zA-Z_-]+)(\\?(.*))?#",
        ]);
    }
}
