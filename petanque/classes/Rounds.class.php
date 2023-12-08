<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

class Rounds {
    private $id;
    private $party_id;
    private $i_order;
    private $players_number;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM rounds WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_party_id($result['party_id']);
                $this->set_i_order($result['i_order']);
                $this->set_players_number($result['players_number']);
            }
        }
    }

// getters setters 
    public function get_id()
    {
        return $this->id;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function get_party_id()
    {
        return $this->party_id;
    }

    public function set_party_id($party_id)
    {
        $this->party_id = $party_id;
    }

    public function get_i_order()
    {
        return $this->i_order;
    }

    public function set_i_order($i_order)
    {
        $this->i_order = $i_order;
    }

    public function get_players_number()
    {
        return $this->players_number;
    }

    public function set_players_number($players_number)
    {
        $this->players_number = $players_number;
    }

// fin  --- getters setters
    function add_round()
    {
        $req = 'INSERT INTO rounds values (
                    NULL,
                    "' . $this->get_party_id() . '",
                    "' . $this->get_i_order() . '",
                    "' . $this->get_players_number() . '"
                )';
        var_dump($req);
        return Connection::query($req);
    }

    function remove_round()
    {
        $req = 'DELETE FROM rounds WHERE id = "' . $this->get_id() . '"';
        return Connection::query($req);
    }

    function remove_rounds_serie($party_id)
    {
        $req = 'DELETE FROM rounds WHERE party_id = "' . $party_id . '"';
        return Connection::query($req);
    }

    function remove_all_rounds()
    {
        $req = 'DELETE FROM rounds';
        return Connection::query($req);
    }

    static function rounds_list()
    {
        $rounds = array();
        $req = 'SELECT rounds.id, rounds.party_id, rounds.i_order, parties.date AS date FROM rounds '
            . ' LEFT JOIN parties ON parties.id = rounds.party_id'
            . ' ORDER BY rounds.party_id DESC, rounds.i_order DESC';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $rounds[] = $value;
                }
            }
        }
        return $rounds;
    }

    static function party_rounds_list($party_id)
    {
        $rounds = array();
        $req = 'SELECT rounds.id, rounds.party_id, rounds.i_order, parties.date AS date FROM rounds '
            . ' LEFT JOIN parties ON parties.id = rounds.party_id'
            . ' WHERE rounds.party_id = ' . $party_id
            . ' ORDER BY rounds.i_order';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    if($value['party_id'] = $party_id)
                        $rounds[] = $value;
                }
            }
        }
        return $rounds;
    }

    static function round_i_order($party_id)
    {
        $i_order = [];
        foreach (self::party_rounds_list($party_id) as $values)
        {
            if($values['party_id'] = $party_id)
                $i_order[] = $values['i_order'];
        }
        return $i_order;
    }

    static function choix_terrain()
    {
        // Liste de terrain
        $listeTerrains = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];

        // Choisir un terrain aléatoire
        $terrainChoisi = array_rand($listeTerrains);

        // Supprimer le terrain de la liste
        unset($listeTerrains[$terrainChoisi]);

        return $listeTerrains[$terrainChoisi];
    }
}