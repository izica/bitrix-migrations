# Bitrix migrations
Миграции для CMS 1C Bitrix. Миграции также поддерживают стандартное апи CMS Bitrix

Методы появляются по мере востребованности, если нужно добавить метод, создавайте issue

## Установка
```
composer require izica/bitrix-migrations
```
## Настройка
Запустить скрипт init, в папке из которой запущен скрипт, создаст папку migrations и все нужные файлы
Параметры скрипта:
* --root - относительный путь DOCUMENT_ROOT(обязательный параметр)
* --directory - название директории которая создастся для миграций(по умолчанию 'migrations')
* --file - название файла который создастся для миграций(по умолчанию 'bxm')
Структура созданных папок будет выглядеть так
* migrations
  * bxm
  * migration - тут будут лежать миграции
  * template - тут лежат шаблоны
 
#### Пример запуска из папки local
```
php php_interface/vendor/izica/bitrix-migrations/bxm.php init --root=../
```

#### Пример запуска из папки local/php_interface
```
php vendor/izica/bitrix-migrations/bxm.php init --root=../../
```


## Миграции
### Команды
Для просмотра всех доступных команд наберите
```
php bxm
```

```
List of available commands:
migrate -- start migrations
migration -- create migration
create -- create migration(same thing as migration)
rollback -- rollback last migration
reset -- reset migrations
```

### Создание миграции
```
php bxm create create-news-iblock
```
также доступны шаблоны
```
php bxm create create-news-iblock {templateName}
php bxm create create-news-iblock iblock
```
### Доступные шаблоны
* iblock_type
* iblock
* iblock_property
* url_rewrite

### Пример Миграции
```php
<?php
class CreateNewsIblock extends MigrationTemplate
{
    public function up(){
        $this->iblock->create([
            'NAME' => 'Новости',
            'CODE' => 'news',
            'IBLOCK_TYPE_ID' => 'information',
            'CODE_TRANSLIT' => true
        ]);
    }

    public function down(){
        $this->iblock->delete('news');
    }
}
```

### Доступные обертки
- [x] iblock_type
- [x] iblock
- [x] url_rewrite
- [X] iblock_element_property
- [X] iblock_section_property
- [x] iblock_form

## Обертки и параметры
### iblock_type
* create(array)
    * ID or CODE(required) - iblock type code
    * SORT
    * NAME(required)
    * NAME_EN
* delete(CODE)

### iblock
* create(array)
    * NAME(required)
    * CODE(required)
    * IBLOCK_TYPE_CODE(or IBLOCK_TYPE_ID)(required)
    * CODE_TRANSLIT - required, unique, translit
    * LIST_PAGE_URL
    * DETAIL_PAGE_URL
    * ACTIVE
    * SITE_ID
    * SORT       
    * GROUP_ID
* update(code, array)
* delete(code)
* setCodeUnique(code)
* setCodeTransliteration(code)
* setCodeTransliteration(code)

### iblock_element_property
* create(iblock_code, array)
    * NAME(required)
    * CODE(required)
    * ACTIVE(Y | N)
    * SORT      
    * TYPE(STRING | LIST | FILE | RELATION(привязка к элементу))
    * MULTIPLE(Y | N)
    * REQUIRED(Y | N)
    * DESCRIPTION(Y | N)
    * LINK_IBLOCK_CODE - для типа RELATION
    * VALUES - массив для типа LIST
        * VALUE
        * DEF(Y | N)
        * SORT
* update(iblock_code, code, array)
* delete(iblock_code, code)
    * IBLOCK_CODE(required)
    * CODE(required)

### iblock_section_property
* create(iblock_code, array)
    * NAME(required)
    * CODE(required)
    * TYPE(STRING)
* delete(iblock_code, code)
    * IBLOCK_CODE(required)
    * CODE(required)

### iblock_form
* element() - default
* section() - set settings for sections
* set(iblock_code, array)
    * tabs
    	* rows

```
$this->iblock_form->section()->set($sIblockCode, [
    'Раздел' => [
        'Название' => 'NAME',
        'Название(Англ)' => 'UF_MENU_NAME_EN',
    ],
]);
```

### url_rewrite
* create(array)
    * CONDITION (required)
    * SITE_ID
    * PATH
    * RULE
* delete(array)
    * CONDITION (required)
    * SITE_ID
