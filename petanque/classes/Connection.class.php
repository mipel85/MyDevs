<?php
/*
 * Connect to the database and execute requests.
 */

require_once('ConnectionConfig.class.php');

class Connection
{
    static private $DB = null;
    static private $DB_ADDR = ConnexionConfig::DB_ADDR;
    static private $DB_NAME = ConnexionConfig::DB_NAME;
    static private $DB_USER = ConnexionConfig::DB_USER;
    static private $DB_PSWD = ConnexionConfig::DB_PSWD;
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
        if (is_null(self::$DB)){
            try {
                $dsn = 'mysql:host=' . self::$DB_ADDR . ';dbname=' . self::$DB_NAME;
                $username = self::$DB_USER;
                $password = self::$DB_PSWD;
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
                self::$DB = new PDO($dsn, $username, $password, $options);
            }catch (Exception $e){
                echo 'Error : ' . $e->getMessage() . '<br />';
            }
        }
        return self::$DB;
    }

    static function query($query)
    {
        $result = self::pdo()->query($query);
        if ($result === false){
            var_dump($query);
            var_dump(self::$DB->errorInfo());
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