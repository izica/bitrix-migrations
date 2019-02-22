<?php

namespace Izica;


class Command {
    public $sName = '';
    public $sDescription = '';

    public function getName(){
        return $this->sName;
    }

    public function getDescription() {
        return $this->sDescription;
    }

    public function execute($argv){
        echo 'Execute ' . $this->sName . ' command';
        return;
    }
}
