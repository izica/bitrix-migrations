# Bitrix migrations
Миграции для CMS 1C Bitrix. Миграции также поддерживают стандартное апи CMS Bitrix

Методы появляются по мере востребованности, если нужно добавить метод, создавайте issue

## Установка
* Скопировать в нужный проект, рекомендуемое место установки '/local/migrations';
* В 'config.json' настроить пути;
```
{
    "path": "/local/migrations", //путь от корневой директории
    "relative": "/../.." //путь до корневой директории
}
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
- [X] iblock_property
- [ ] TODO...

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
    * CODE_TRANSLIT - true | false - опция автоматической транслитерации имени элемента в код
    * LIST_PAGE_URL
    * DETAIL_PAGE_URL
    * ACTIVE
    * SITE_ID
    * SORT       
    * GROUP_ID
* delete(CODE)

### iblock_property
* create(array)
    * NAME(required)
    * CODE(required)
    * IBLOCK_CODE(or IBLOCK_TYPE_ID)(required)
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
* delete(array)
    * IBLOCK_CODE(required)
    * CODE(required)

### url_rewrite
* create(array)
    * CONDITION (required)
    * SITE_ID
    * PATH
    * RULE
* delete(array)
    * CONDITION (required)
    * SITE_ID
