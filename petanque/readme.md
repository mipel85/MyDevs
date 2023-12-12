# Petanque casual competition manager

Version 1.0 Alpha

## Connect to the database
- create database
- import /_datas/petanque.sql
- create file ConnectionConfig.class.php in /classes directory
```
<?php
/*
 * Database login credentials
 */

class ConnexionConfig
{
    const DB_ADDR = ''; // address of server
    const DB_NAME = ''; // name of the database
    const DB_USER = ''; // username to connect to the database
    const DB_PSWD = ''; // password to connect to the database
}
?>
```