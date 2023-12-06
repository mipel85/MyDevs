<?php
require_once('connexion.class.php');
class install {

    static function create_database()
    {
        $req = 'CREATE DATABASE IF NOT EXISTS `petanque` COLLATE utf8mb4_general_ci;';
        return Connexion::query($req);
    }

    static function create_players_table()
    {
        $requete = 'CREATE TABLE IF NOT EXISTS petanque.joueurs (
                        `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                        `nom` varchar(200) NOT NULL,
                        `present` tinyint(1) DEFAULT NULL,
                        `fav` tinyint(1) DEFAULT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

        return Connexion::query($requete);
    }

    static function insert_data_players()
    {
        $req = 'SELECT COUNT(*) AS NB FROM `joueurs`';
        $empty_table = Connexion::query($req);
        if ($empty_table[0]['NB'] === 0){
            $requete = 'INSERT INTO `joueurs` (`nom`) VALUES
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
            return Connexion::query($requete);
        }
    }
}