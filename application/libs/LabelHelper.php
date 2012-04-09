<?php
class LabelHelper {
    private static $instance;
    private $count = 0;
    
    private static $label = null;

    private function __construct()
    {

        self::$label = json_decode(file_get_contents('../application/configs/labels.json'));


    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    public function getLabel($label) {
        return self::$label->$label;
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
