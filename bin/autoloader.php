<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');

require_once('core/Migration.php');
require_once('core/Bxm.php');
require_once('core/Rollback.php');

require_once('helpers/IblockType.php');
require_once('helpers/Iblock.php');
require_once('helpers/IblockProperty.php');
require_once('helpers/UrlRewrite.php');

require_once('helpers/MigrationTemplate.php');
