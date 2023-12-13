<?php
/*
 * TODO 
 *  - finalize db
 *  - separate from index to specific directory
*/

require_once('Connection.class.php');

class install {

    static function create_database()
    {
        $req = 'CREATE DATABASE IF NOT EXISTS `petanque` COLLATE utf8mb4_general_ci;';
        return Connection::query($req);
    }

    static function create_teams_table()
    {
        $requete = 'CREATE TABLE IF NOT EXISTS petanque.teams (
                        `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                        `day_id` int(11) NOT NULL,
                        `round_id` int(11) NOT NULL,
                        `player_1_id` int(11) NOT NULL,
                        `player_1_name` varchar(255) NOT NULL,
                        `player_2_id` int(11) DEFAULT NULL,
                        `player_2_name` varchar(255) DEFAULT NULL,
                        `player_3_id` int(11) DEFAULT NULL,
                        `player_3_name` varchar(255) DEFAULT NULL,
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

        return Connection::query($requete);
    }

    static function create_members_table()
    {
        $requete = 'CREATE TABLE IF NOT EXISTS petanque.members (
                        `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                        `name` varchar(255) NOT NULL,
                        `present` tinyint(1) DEFAULT NULL,
                        `fav` tinyint(1) DEFAULT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

        return Connection::query($requete);
    }

    static function insert_data_members()
    {
        $req = 'SELECT COUNT(*) AS NB FROM `members`';
        $empty_table = Connection::query($req);
        if ($empty_table[0]['NB'] === 0){
            $requete = 'INSERT INTO `members` (`nom`) VALUES
            ("Alain.G"),
            ("Alain.M"),
            ("Annick.G"),
            ("Christophe.B"),
            ("Claudie.F"),
            ("Daniel.E"),
            ("Daniel.R"),
            ("Daniel.T"),
            ("Danielle.L"),
            ("Dany.R"),
            ("Denis.D"),
            ("Denis.G"),
            ("Dominique.B"),
            ("Eric.E"),
            ("Fernand.D"),
            ("Fernando.L"),
            ("Franck.H"),
            ("Frederic.D"),
            ("Francois.S"),
            ("Gaetan.F"),
            ("Gerard.F"),
            ("Gerard.M"),
            ("Ghislain.G"),
            ("Gilbert.M"),
            ("Guy.A"),
            ("Jean-Claude.F"),
            ("Jean-Guy.A"),
            ("Jean-Jacques.B"),
            ("Jean-Louis.D"),
            ("Jean-Luc.C"),
            ("Jean-Luc.L"),
            ("Jean-Marcel.S"),
            ("Jean-Paul.C"),
            ("Jean-Pierre.L"),
            ("Jean-Pierre.P"),
            ("Laurent.S"),
            ("Louis.R"),
            ("Marcel .B"),
            ("Marie.M"),
            ("Mathieu.M"),
            ("Michel.C"),
            ("Michel.P"),
            ("Michel.R"),
            ("Nicky.M"),
            ("Nicole.H"),
            ("Noel.L"),
            ("Pascal.L"),
            ("Patrick.D"),
            ("Patrick.L"),
            ("Philippe.G"),
            ("Philippe.R"),
            ("Roland.C"),
            ("Yannick.G"),
            ("Claire.S"),
            ("Marc.S"),
            ("Sylvain.B"),
            ("Mathieu.M"),
            ("Gilles.T"),
            ("Catherine.D"),
            ("Jean-Louis.D")';
            return Connection::query($requete);
        }
    }
}