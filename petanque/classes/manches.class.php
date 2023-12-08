<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

class Manches {
    private $id;
    private $p_id;
    private $i_order;
    private $nb_joueurs;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM manches WHERE id = ' . $id;
            if ($result = Connexion::query($req)){
                $result = $result[0];
                $this->setId($result['id']);
                $this->setp_id($result['p_id']);
                $this->setI_order($result['i_order']);
                $this->setNbJoueurs($result['nb_joueurs']);
            }
        }
    }

// getters setters 
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getP_id()
    {
        return $this->p_id;
    }

    public function setp_id($p_id)
    {
        $this->p_id = $p_id;
    }

    public function getI_order()
    {
        return $this->i_order;
    }

    public function setI_order($i_order)
    {
        $this->i_order = $i_order;
    }

    public function getNbJoueurs()
    {
        return $this->nb_joueurs;
    }

    public function setNbJoueurs($nb_joueurs)
    {
        $this->nb_joueurs = $nb_joueurs;
    }

// fin  --- getters setters
    function ajouter_manche()
    {
        $req = 'INSERT INTO manches values (
                    NULL,
                    "' . $this->getP_id() . '",
                    "' . $this->getI_order() . '",
                    "' . $this->getNbJoueurs() . '"
                )';
        var_dump($req);
        return Connexion::query($req);
    }

    function supprimer_manche()
    {
        $req = 'DELETE FROM manches WHERE id = "' . $this->getId() . '"';
        return Connexion::query($req);
    }

    function delete_manches_serie($p_id)
    {
        $req = 'DELETE FROM manches WHERE p_id = "' . $p_id . '"';
        return Connexion::query($req);
    }

    function delete_all_manches()
    {
        $req = 'DELETE FROM manches';
        return Connexion::query($req);
    }

    static function liste_manches()
    {
        $manches = array();
        $req = 'SELECT manches.id, manches.p_id, manches.i_order, parties.date AS date FROM manches '
            . ' LEFT JOIN parties ON parties.id = manches.p_id'
            . ' ORDER BY manches.p_id, manches.i_order';

        if ($result = Connexion::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $manches[] = $value;
                }
            }
        }
        return $manches;
    }

    static function party_rounds_list($p_id)
    {
        $manches = array();
        $req = 'SELECT manches.id, manches.p_id, manches.i_order, parties.date AS date FROM manches '
            . ' LEFT JOIN parties ON parties.id = manches.p_id'
            . ' WHERE manches.p_id = ' . $p_id
            . ' ORDER BY manches.i_order';

        if ($result = Connexion::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    if($value['p_id'] = $p_id)
                        $manches[] = $value;
                }
            }
        }
        return $manches;
    }

    static function manche_i_order($p_id)
    {
        $i_order = [];
        foreach (self::party_rounds_list($p_id) as $values)
        {
            if($values['p_id'] = $p_id)
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