<?php

namespace App\Db;

class Config
{
    public $settings = [];
    private static $config;

    public function __construct()
    {
        $this->settings = require 'db_config.php';
    }

    public static function get_config()
    {
        if (is_null(self::$config)) {
            self::$config = new Config();
        }
        return self::$config;
    }

    public function get($key)
    {
        if(is_null($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }
}
?>