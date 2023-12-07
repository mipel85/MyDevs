<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

class Manches {
    private $id;
    private $j_id;
    private $nb_joueurs;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM manches WHERE id = ' . $id;
            if ($result = Connexion::query($req)){
                $result = $result[0];
                $this->setId($result['id']);
                $this->setJ_id($result['j_id']);
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

    public function getJ_id()
    {
        return $this->j_id;
    }

    public function setJ_id($j_id)
    {
        $this->j_id = $j_id;
    }

    public function getI_order()
    {
        return $this->j_id;
    }

    public function setI_order($j_id)
    {
        $this->j_id = $j_id;
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
                    "' . $this->getJ_id() . '",
                    "' . $this->getI_order() . '",
                    "' . $this->getNbJoueurs() . '"
                )';
        return Connexion::query($req);
    }

    function supprimer_manche()
    {
        $req = 'DELETE FROM manches WHERE id = "' . $this->getId() . '"';
        return Connexion::query($req);
    }

    static function liste_manches()
    {
        $manches = array();
        $req = 'SELECT manches.id, manches.j_id, manches.i_order, parties.date AS date FROM manches '
            . ' LEFT JOIN parties ON parties.id = manches.j_id'
            . ' ORDER BY manches.i_order';

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

    static function liste_partie_manches($j_id)
    {
        $manches = array();
        $req = 'SELECT manches.id, manches.j_id, manches.i_order, parties.date AS date FROM manches '
            . ' LEFT JOIN parties ON parties.id = manches.j_id'
            . ' ORDER BY manches.i_order';

        if ($result = Connexion::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    if($value['j_id'] = $j_id)
                        $manches[] = $value;
                }
            }
        }
        return $manches;
    }

    static function manche_i_order($j_id)
    {
        $i_order = [];
        foreach (self::liste_manches() as $values)
        {
            if($values['j_id'] = $j_id)
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