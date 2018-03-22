# Bitrix migrations
Миграции для CMS 1C Bitrix. Миграции также поддерживают стандартное апи CMS Bitrix

## Установка
Скопировать в нужный проект, рекомендуемое место установки '/local/migrations';
В 'config.json' настроить пути;
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

### Пример
```php
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
```

### Доступные обертки
- [x] iblock_type
- [x] iblock
- [x] url_rewrite
- [ ] iblock_property
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
    * IBLOCK_TYPE_ID(required)
    * CODE_TRANSLIT - true | false - опция автоматической транслитерации имени элемента в код
    * LIST_PAGE_URL
    * DETAIL_PAGE_URL
    * ACTIVE
    * SITE_ID
    * SORT       
    * GROUP_ID
* delete(CODE)

### url_rewrite
* create(array)
    * CONDITION (required)
    * SITE_ID
    * PATH
    * RULE
* delete(array)
    * CONDITION (required)
    * SITE_ID
