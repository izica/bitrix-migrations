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
  * migration - миграции
  * template - шаблоны
 
#### Пример установки из папки local
```
cd local/php_interface
composer require izica/bitrix-migrations
cd ..
php php_interface/vendor/izica/bitrix-migrations/bxm.php init --root=../
```

#### Пример установки из папки local/php_interface
```
cd local/php_interface
composer require izica/bitrix-migrations
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
php bxm create CreateNewsIblock
```
