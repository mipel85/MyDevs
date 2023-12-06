<?php
/*
 * Cette classe permet de se connecter à la base de données et d'executer des requetes.
 */

require_once('connection_config.class.php');

class Connexion
{
    static private $DB = null;
    static private $DB_ADDR = CONNECTION_CONFIG::DB_ADDR;
    static private $DB_NAME = CONNECTION_CONFIG::DB_NAME;
    static private $DB_USER = CONNECTION_CONFIG::DB_USER;
    static private $DB_PSWD = CONNECTION_CONFIG::DB_PSWD;
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