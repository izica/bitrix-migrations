<?php

class CommandInit extends Command {
    public $sName = 'init';
    public $sDescription = 'Init migrations module. Example: php /vendor/izica/bitrix-migrations/bxm init';

    public function execute($argv) {
        $sFilename = 'bxm';
        $sDocumentRoot = $this->getDocumentRoot($argv);

        $sText = "<?php\n";
        $sText .= '$_SERVER["DOCUMENT_ROOT"] = "' . $sDocumentRoot . '";' . "\n";
        $sText .= 'include "' . $this->getScriptPath() . '";';

        file_put_contents($sFilename, $sText);

        $sDirName = $this->getCurrentPath() . 'migration';
        if (!is_dir($sDirName)) {
            mkdir($sDirName, 0644);
        }

        $this->copyDirectory($this->getScriptDirectory() . 'template', $this->getCurrentPath() . 'template');

        echo 'Bitrix migrations initialization done.';
    }

    private function getDocumentRoot($argv) {
        if (!isset($argv[2])) {
            echo 'DOCUMENT_ROOT not provided';
            die();
        }
        if (!is_dir($argv[2])) {
            echo 'Error[DOCUMENT_ROOT]: directory not found';
            die();
        }
        if (!is_dir($argv[2] . '/bitrix')) {
            echo 'Error[DOCUMENT_ROOT]: bitrix directory not found';
            die();
        }
        return str_replace('\\', '/', $argv[2]);
    }

    private function getCurrentPath() {
        return getcwd() . '/';
    }

    private function getScriptPath() {
        $sPath = $this->getCurrentPath() . $_SERVER['SCRIPT_FILENAME'];
        return str_replace('\\', '/', $sPath);
    }

    private function getScriptDirectory() {
        $sDirectoryPath = $this->getScriptPath();
        return substr($sDirectoryPath, 0, -7);
    }

    private function copyDirectory($source, $dest) {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
        }
        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            $this->copyDirectory("$source/$entry", "$dest/$entry");
        }
        // Clean up
        $dir->close();
        return true;
    }
}
