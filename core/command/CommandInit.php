<?php
namespace Izica;


class CommandInit extends Command {
    public $sName = 'init';
    public $sDescription = 'Init migrations module. Example: php /vendor/izica/bitrix-migrations/bxm init';

    public function execute($arArguments) {
        $arParams = $this->getParams($arArguments);
        print_r($arParams);
        $arParams['--root'] = $this->getDocumentRoot($arParams['--root']);

        $this->createMigrationsDirectories($arParams);
        $this->createExecFileText($arParams);
        $this->copyDirectory($this->getScriptDirectory($arParams) . '/template', $arParams['--directory'] . '/template');
    }

    private function createMigrationsDirectories($arParams) {
        if (!is_dir($arParams['--directory'])) {
            mkdir($arParams['--directory']);
        }

        $sMigration = $this->parseDirPath($arParams['--directory'] . '/migration');
        if (!is_dir($sMigration)) {
            mkdir($sMigration);
        }

        $sTemplate = $this->parseDirPath($arParams['--directory'] . '/template');
        if (!is_dir($sTemplate)) {
            mkdir($sTemplate);
        }
    }

    private function createExecFileText($arParams) {
        $sFilename = $this->parseDirPath("{$arParams['--directory']}/{$arParams['--file']}");
        $sText = "<?php\n";
        $sText .= '$_SERVER["DOCUMENT_ROOT"] = "../' . $arParams['--root'] . '";' . "\n";
        $sText .= 'include "../' . $arParams['--script'] . '";';
        file_put_contents($sFilename, $sText);
    }

    private function getParams($arArguments) {
        $arResult = [];
        foreach ($arArguments as $sArgument) {
            $arArgument = explode('=', $sArgument);
            if (count($arArgument) > 1) {
                $arResult[$arArgument[0]] = $arArgument[1];
            }
        }
        if (!isset($arResult['--file'])) {
            $arResult['--file'] = 'bxm';
        }
        if (!isset($arResult['--directory'])) {
            $arResult['--directory'] = 'migrations';
        }
        if (!isset($arResult['--root'])) {
            echo '--root argument is required';
            die();
        }
        if (!isset($arResult['--script'])) {
            $arResult['--script'] = $sTemplate = $this->parseDirPath($arArguments[0]);
        }
        return $arResult;
    }

    private function parseDirPath($sPath) {
        $sPath = str_replace('\\', '/', $sPath);
        $sPath = str_replace('//', '/', $sPath);
        return $sPath;
    }

    private function getDocumentRoot($sRoot) {
        if (!is_dir($sRoot)) {
            echo '[ERROR] DOCUMENT_ROOT directory fail';
            die();
        }
        if (!is_dir($sRoot . '/bitrix')) {
            echo '[ERROR] DOCUMENT_ROOT directory fail';
            die();
        }
        return str_replace('\\', '/', $sRoot);
    }

    private function getScriptDirectory($arParams) {
        $arPath = explode('/', $arParams['--script']);
        unset($arPath[count($arPath)-1]);
        return implode('/', $arPath);
    }

    private function copyDirectory($source, $dest) {
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        if (is_file($source)) {
            return copy($source, $dest);
        }

        if (!is_dir($dest)) {
            mkdir($dest);
        }
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            $this->copyDirectory("$source/$entry", "$dest/$entry");
        }
        $dir->close();
        return true;
    }
}
