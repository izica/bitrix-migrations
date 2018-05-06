<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');

require_once('class/Migration.php');
require_once('class/Bxm.php');
require_once('class/Rollback.php');

require_once('helper/IblockType.php');
require_once('helper/Iblock.php');
require_once('helper/IblockForm.php');
require_once('helper/IblockElementProperty.php');
require_once('helper/IblockSectionProperty.php');
require_once('helper/UrlRewrite.php');

require_once('helper/MigrationAbstract.php');
