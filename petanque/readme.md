# Petanque casual competition manager

## Connect to the database
- create database
- import /_datas/petanque.sql
- create file connection_config.class.php in /classes directory
```
<?php
/*
 * identifiants de connexion à la base de données
 */

class CONNECTION_CONFIG
{
    const DB_ADDR = ''; // address of server
    const DB_NAME = ''; // name of the database
    const DB_USER = ''; // username to connect to the database
    const DB_PSWD = ''; // password to connect to the database
}
?>
```