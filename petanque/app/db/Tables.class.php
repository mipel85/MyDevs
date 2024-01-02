<?php

namespace App\Db;

class Tables
{
    static function create_days($prefix)
    {
        $table = $prefix . 'days';
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table . ' (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `date` varchar(11) NOT NULL,
            `active` tinyint(1) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
    
    static function create_fields($prefix)
    {
        $table = $prefix . 'fields';
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table . ' (
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
    
    static function create_matches($prefix)
    {
        $table = $prefix . 'matches';
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table . ' (
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
    
    static function create_members($prefix)
    {
        $table = $prefix . 'members';
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table . ' (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `present` tinyint(1) DEFAULT NULL,
            `fav` tinyint(1) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
    
    static function create_players($prefix)
    {
        $table = $prefix . 'players';
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table . ' (
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
    
    static function create_rankings($prefix)
    {
        $table = $prefix . 'rankings';
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table . ' (
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
    
    static function create_rounds($prefix)
    {
        $table = $prefix . 'rounds';
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table . ' (
            `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `day_id` int(11) NOT NULL,
            `i_order` int(11) NOT NULL,
            `players_number` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
        return Connection::query($sql);
    }
    
    static function create_teams($prefix)
    {
        $table = $prefix . 'teams';
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table . ' (
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