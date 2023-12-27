<?php

require_once('../classes/Connection.class.php');

class Install
{
    static function create_days()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS days (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `date` varchar(11) NOT NULL,
            `active` tinyint(1) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
    
    static function create_fields()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS fields (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `day_id` int(11) NOT NULL,
            `field_1` tinyint(1) DEFAULT NULL,
            `field_2` tinyint(1) DEFAULT NULL,
            `field_3` tinyint(1) DEFAULT NULL,
            `field_4` tinyint(1) DEFAULT NULL,
            `field_5` tinyint(1) DEFAULT NULL,
            `field_6` tinyint(1) DEFAULT NULL,
            `field_7` tinyint(1) DEFAULT NULL,
            `field_8` tinyint(1) DEFAULT NULL,
            `field_9` tinyint(1) DEFAULT NULL,
            `field_10` tinyint(1) DEFAULT NULL,
            `field_11` tinyint(1) DEFAULT NULL,
            `field_12` tinyint(1) DEFAULT NULL,
            `field_13` tinyint(1) DEFAULT NULL,
            `field_14` tinyint(1) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
    
    static function create_matches()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS matches (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `day_id` int(11) NOT NULL,
            `round_id` int(11) NOT NULL,
            `team_1_id` int(11) NOT NULL,
            `team_1_score` int(11) NULL,
            `team_2_id` int(11) NOT NULL,
            `team_2_score` int(11) NULL,
            `field` int(11) NOT NULL,
            `score_status` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
    
    static function create_members()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS members (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `present` tinyint(1) DEFAULT NULL,
            `fav` tinyint(1) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
    
    static function create_players()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS players (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `day_id` int(11) NOT NULL,
            `round_id` int(11) NOT NULL,
            `match_id` int(11) NOT NULL,
            `score_status` tinyint(1) NOT NULL,
            `member_id` int(11) NOT NULL,
            `member_name` varchar(255) NOT NULL,
            `points_for` int(11) NOT NULL,
            `points_against` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
    
    static function create_rankings()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS rankings (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `day_id` int(11) NOT NULL,
            `day_date` varchar(11) NOT NULL,
            `member_id` int(11) NOT NULL,
            `member_name` varchar(255) NOT NULL,
            `played` int(11) NOT NULL,
            `victory` int(11) NOT NULL,
            `loss` int(11) NOT NULL,
            `pos_points` int(11) NOT NULL,
            `neg_points` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
    
    static function create_rounds()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS rounds (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `day_id` int(11) NOT NULL,
            `i_order` int(11) NOT NULL,
            `players_number` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
    
    static function create_teams()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS teams (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `day_id` int(11) NOT NULL,
            `round_id` int(11) NOT NULL,
            `player_1_id` int(11) NOT NULL,
            `player_1_name` varchar(255) NOT NULL,
            `player_2_id` int(11) DEFAULT NULL,
            `player_2_name` varchar(255) DEFAULT NULL,
            `player_3_id` int(11) DEFAULT NULL,
            `player_3_name` varchar(255) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
}