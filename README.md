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
php bxm create create-iblock-news --template={templateName}
php bxm create create-iblock-news --template=iblock
```
### Шаблоны
Библиотека имеет список встроенных шаблонов.
```markdown
* default - пустой шаблон
* iblocktype - создание типа инфоблока
* iblock - создание инфоблока
* iblock-property - создание свойства инфоблока
* iblock-catalog - создание каталога(инфоблока типа Торговый каталог)
```

Для создания собственных шаблонов их можно размещать в соседнюю с миграциями папку "template".

### Пример Миграции
```php
<?php

use Izica\Migration;
use CModule;

class CreateIblockNews_1550830432 extends Migration {
    public function up() {
        CModule::IncludeModule('iblock');

        $obIblock = new CIBlock;
        $arFields = [
            "ACTIVE"           => 'Y',
            "NAME"             => 'Новости',
            "CODE"             => 'news',
            "IBLOCK_TYPE_ID"   => 'info',
            "SITE_ID"          => ["s1"],
            "GROUP_ID"         => ["2" => "D", "3" => "R"]
        ];

        $nId = $obIblock->Add($arFields);
        
        $this->log('CIBlock news created');
    }

    public function down() {
        CModule::IncludeModule('iblock');

        CIBlock::Delete($this->getIblockIdByCode('news'));

        $this->log('CIBlock news deleted');
    }
}
```
### Дополнительные функции класса Migration
* log($message, $code) - вывод сообщения в консоль в процесса миграции
* set($key, $value) - сохранение данных в буфер миграции, удобно использовать например при создании свойств инфоблока.
* get($key) - получить данные из буфера.
* getIblockIdByCode($code) - получить ID инфоблока по его коду

```php
<?
class Example extends Migration {
    public function up() {
        /*
         * тут создается свойсво
         */
        $nPropertyId = $obProperty->Add($arFields);
        $this->set('PROPERTY_CODE', $nPropertyId);
        $this->log('CIBlock news created');
    }

    public function down() {
        CModule::IncludeModule('iblock');
        
        $nPropertyId = $this->get('ADDITIONAL_DESCRIPTION');
        CIBlockProperty::Delete($nPropertyId);

        $this->log('Property PROPERTY_CODE deleted');
    }
}
```
