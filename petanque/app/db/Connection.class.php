<?php

namespace App\Db;

use \PDO;
use \Exception;

/*
 * Connect to the database and execute requests.
 */

require_once('Config.class.php'); // needed for install process

class Connection
{
    static private $db = null;
    static private $table;

    function __construct($table = NULL)
    {
        self::$table = $table;   // :: la classe s'auto appelle 
    }

    static function exec($query)
    {
        $result = self::pdo()->query($query); // on appelle la methode query qui appelle la methode pdo pour se connecter.
        return $result;
    }

    static function pdo()
    {
        if (is_null(self::$db)){
            try {
                $dsn = 'mysql:host=' . Config::get_config()->get('db_host') . ';dbname=' . Config::get_config()->get('db_name');
                $username = Config::get_config()->get('db_user');
                $password = Config::get_config()->get('db_pass');
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
                self::$db = new PDO($dsn, $username, $password, $options);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (Exception $e){
                echo 'Error : ' . $e->getMessage() . '<br />';
            }
        }
        return self::$db;
    }

    static function query($query)
    {
        $result = self::pdo()->query($query);
        if ($result === false) {
            exit('Error');
        }
        $a = array();
        foreach ($result as $row)
        {
            $a[] = $row;
        }
        return $a;
    }

    static function lastInId()
    {
        return self::pdo()->lastInsertId();
    }

}
?>