<?php
class ConfigHelper {
    private static $instance;
    private $count = 0;
    
    private static $config = null;

    private function __construct()
    {
        $APPLICATION_ENVIRONMENT = getenv('APPLICATION_ENVIRONMENT');
        if (strlen($APPLICATION_ENVIRONMENT) > 0 && $APPLICATION_ENVIRONMENT == 'dev') {
            self::$config = json_decode(file_get_contents('../application/configs/dev.config.json'));
        } else {
            self::$config = json_decode(file_get_contents('../application/configs/prod.config.json'));
        }

    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    public function getConfig() {
        return self::$config;
    }

    public function getEnvironmnent() {
        return $this->getConfig()->env;
    }

    public function getTempPath() {
        return $this->getConfig()->temppath;
    }

    public function getPartialsPath() {
        return $this->getConfig()->partialspath;
    }

     public function increment()
    {
        return $this->count++;
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }
}
