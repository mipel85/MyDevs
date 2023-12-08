<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

class Teams {
    private $id;
    private $party_id;
    private $round_id;
    private $player_1_id;
    private $player_1_name;
    private $player_2_id;
    private $player_2_name;
    private $player_3_id;
    private $player_3_name;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM teams WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_party_id($result['party_id']);
                $this->set_round_id($result['round_id']);
                $this->set_player_1_id($result['player_1_id']);
                $this->set_player_1_name($result['player_1_name']);
                $this->set_player_2_id($result['player_2_id']);
                $this->set_player_2_name($result['player_2_name']);
                $this->set_player_3_id($result['player_3_id']);
                $this->set_player_3_name($result['player_3_name']);
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

    public function get_round_id()
    {
        return $this->round_id;
    }

    public function set_round_id($round_id)
    {
        $this->round_id = $round_id;
    }

    public function get_player_1_id()
    {
        return $this->player_1_id;
    }

    public function set_player_1_id($player_1_id)
    {
        $this->player_1_id = $player_1_id;
    }

    public function get_player_1_name()
    {
        return $this->player_1_name;
    }

    public function set_player_1_name($player_1_name)
    {
        $this->player_1_name = $player_1_name;
    }

    public function get_player_2_id()
    {
        return $this->player_2_id;
    }

    public function set_player_2_id($player_2_id)
    {
        $this->player_2_id = $player_2_id;
    }

    public function get_player_2_name()
    {
        return $this->player_2_name;
    }

    public function set_player_2_name($player_2_name)
    {
        $this->player_2_name = $player_2_name;
    }

    public function get_player_3_id()
    {
        return $this->player_3_id;
    }

    public function set_player_3_id($player_3_id)
    {
        $this->player_3_id = $player_3_id;
    }

    public function get_player_3_name()
    {
        return $this->player_3_name;
    }

    public function set_player_3_name($player_3_name)
    {
        $this->player_3_name = $player_3_name;
    }

    static function creation_teams($party_id, $round_id)
    {
        // Liste de joueurs présents
        $players_list = Players::present_players_list();
        $joueurs = [];
        foreach ($players_list as $joueur)
        {
            $joueurs[] = $joueur['nom'];
        }

        // Mélanger la liste de joueurs de manière aléatoire
        shuffle($joueurs);

        $teams = [];
        
        $nbJoueurs = count($joueurs);
        $equipeDe2 = floor($nbJoueurs / 2);
        $equipeDe2Pair = $equipeDe2 % 2 == 0;
        $equipeDe3 = floor($nbJoueurs / 3);
        $equipeDe3Pair = $equipeDe3 % 2 == 0;
        
        // Tant qu'il y a des joueurs dans la liste
        while (!empty($joueurs)) {
            // Si nb d'équipes de 2 possibles est pair et nb d'équipes de 3 possibles est pair
            // ou si nb d'équipes de 2 possibles est pair et nb d'équipes de 3 possibles est impair
            if (($equipeDe2Pair && $equipeDe3Pair) || ($equipeDe2Pair && !$equipeDe3Pair))
            {
                if (count($joueurs) <= 3) {
                    $equipe = array_splice($joueurs, 0, 3);
                } else {
                    $equipe = array_splice($joueurs, 0, 2); // Sinon, prend les joueurs 2 par 2
                }
            }
            // Si nb d'équipes de 2 possibles est impair et nb d'équipes de 3 possibles est pair
            // ou si nb d'équipes de 2 possibles est impair et nb d'équipes de 3 possibles est impair
            elseif ((!$equipeDe2Pair && $equipeDe3Pair) || (!$equipeDe2Pair && !$equipeDe3Pair))
            {
                if (count($joueurs) <= 9) {
                    $equipe = array_splice($joueurs, 0, 3);
                } else {
                    $equipe = array_splice($joueurs, 0, 2); // Sinon, prend les joueurs 2 par 2
                }
            }
            
            // Ajoute l'équipe formée à la liste des équipes
            $teams[] = $equipe;
        }
        
        return $teams;
    }
    
    function insert_team()
    {
        $req = 'INSERT INTO teams values (
                    NULL,
                    "' . $this->getNom_joueur() . '",
            "0")';
        return Connection::query($req);
    }
}