<?php
namespace Izica;


class CommandCreate extends Command {
    private $nTime = 0;
    public $sName = 'create';
    public $sDescription = 'Create migration. Example: php bxm create InformationIblockCreate';

    public function execute($argv) {
        $this->nTime = time();
        $sClassName = $this->getClassName($argv);
        $sFileName = 'migration/' . $this->nTime . '-' . $sClassName . '.php';
        $arParams = $this->getParams($argv);

        $sTemplate = $this->getTemplate($arParams['--template']);

        $sContent = str_replace("__NAME__", $sClassName, $sTemplate);
        file_put_contents($sFileName, $sContent);

        MigrationLog::add('OK', "Migration {$sClassName} created");
        MigrationLog::show(true);
    }

    public function getTemplate($sTemplateName) {
        $sTemplateFileName = "template/{$sTemplateName}.php";

        if (!file_exists($sTemplateFileName)) {
            MigrationLog::add('TEMPLATE_NOT_FOUND', "Cant find \"{$sTemplateName}\" template");
            MigrationLog::show(true);
        }
        return file_get_contents($sTemplateFileName);
    }

    private function getParams($arArguments) {
        $arResult = [];
        foreach ($arArguments as $sArgument) {
            $arArgument = explode('=', $sArgument);
            if (count($arArgument) > 1) {
                $arResult[$arArgument[0]] = $arArgument[1];
            }
        }
        if (!isset($arResult['--template'])) {
            MigrationLog::add('TEMPLATE_PARAM_NOT_FOUND', "Cant find --template. Template = default.");
            $arResult['--template'] = 'default';
        }
        return $arResult;
    }

    public function getClassName($argv) {
        if (!isset($argv[2])) {
            MigrationLog::add('MIGRATION', 'Name not found');
            MigrationLog::show(true);
        }
        $sName = preg_replace('/[^\w]/', ' ', $argv[2]);
        $sName = ucwords($sName) . '_' . $this->nTime;
        return str_replace(' ', '', $sName);
    }
}
