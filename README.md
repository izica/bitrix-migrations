# Bitrix migrations
Миграции для CMS 1C Bitrix. Миграции также поддерживают стандартное апи CMS Bitrix

## Установка
Скопировать в нужный проект, рекомендуемое место установки '/local/migrations';

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
[x] iblock_type
[x] iblock
[x] url_rewrite
[] iblock_property
[] TODO

## Параметры
### iblock_type
*ID or CODE(required) - iblock type code
*SORT
*
