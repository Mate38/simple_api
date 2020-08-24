<?php

class Config {
    
    protected $configs = [
        'ACCOUNTS_PATH' => "C:\\wamp64\\www\\ebanx\\simple_api\\Storage\\accounts.json"
    ];

    public function getConfig($config) {
        return $this->configs[$config];
    }

}


