<?php

class UrlRewrite
{
    private $service;

    public function __construct() {
    }

    public function create($data){
        CUrlRewriter::Add(
            array(
                "SITE_ID"   => isset($data['SITE_ID']) ? $data['SITE_ID'] : 's1',
                "CONDITION" => $data['CONDITION'],
                "ID"        => $data['COMPONENT'],
                "PATH"      => $data['PATH'],
                "RULE"      => $data['RULE'],
            )
        );
    }

    public function delete($data){
        CUrlRewriter::Delete(
            array(
                "SITE_ID" => isset($data['SITE_ID']) ? $data['SITE_ID'] : 's1',
                "CONDITION" => $data['CONDITION']
            )
        );
    }
}
