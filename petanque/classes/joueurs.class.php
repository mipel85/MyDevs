<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

class Joueurs {
    private $id;
    private $nom_joueur;
    private $present;
    private $fav;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM joueurs WHERE id = ' . $id;
            if ($result = Connexion::query($req)){
                $result = $result[0];
                $this->setId($result['id']);
                $this->setNom_joueur($result['nom']);
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

    public function getNom_joueur()
    {
        return $this->nom_joueur;
    }

    public function setNom_joueur($nom_joueur)
    {
        $this->nom_joueur = $nom_joueur;
    }

    public function getPresent()
    {
        return $this->present;
    }

    public function setPresent($present)
    {
        $this->present = $present;
    }

    public function getFav()
    {
        return $this->fav;
    }

    public function setFav($fav)
    {
        $this->fav = $fav;
    }

// fin  --- getters setters  
    function insert()
    {
        $req = 'INSERT INTO joueurs values (
                    NULL,
                    "' . $this->getNom_joueur() . '",
                    "0",
                    "0")
                ';
        return Connexion::query($req);
    }

    function suppression()
    {
        $req = 'DELETE FROM joueurs WHERE id = "' . $this->getId() . '"';
        return Connexion::query($req);
    }

    function select_present()
    {
        $req = 'UPDATE joueurs SET `present` = 1 WHERE `joueurs`.`id` = ' . $this->getId() . '';
        return Connexion::query($req);
    }

    function reset_present()
    {
        $req = 'UPDATE joueurs SET `present` = 0 WHERE `joueurs`.`id` = ' . $this->getId() . '';
        return Connexion::query($req);
    }

    function reset_all_presents()
    {
        $req = 'UPDATE joueurs SET `present` = 0';
        return Connexion::query($req);
    }

    function select_fav()
    {
        $req = 'UPDATE joueurs SET `fav` = 1 WHERE `joueurs`.`id` = ' . $this->getId() . '';
        return Connexion::query($req);
    }

    function reset_fav()
    {
        $req = 'UPDATE joueurs SET `fav` = 0 WHERE `joueurs`.`id` = ' . $this->getId() . '';
        return Connexion::query($req);
    }

    function reset_all_favs()
    {
        $req = 'UPDATE joueurs SET `fav` = 0';
        return Connexion::query($req);
    }

    static function liste_joueurs_connus()
    {
        $liste_joueurs = array();
        $req = 'SELECT id, nom, fav, present FROM joueurs ORDER BY `nom` ASC';
        if ($result = Connexion::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $liste_joueurs[] = $value;
                }
            }
        }
        return $liste_joueurs;
    }

    static function liste_joueurs_presents()
    {
        $joueurs_presents = array();
        $req = 'SELECT id, nom FROM joueurs'
            . ' WHERE `present` = 1'
            . ' ORDER BY `nom` ASC';

        if ($result = Connexion::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $joueurs_presents[] = $value;
                }
            }
        }
        return $joueurs_presents;
    }

    static function affiche_liste($liste)
    {
        foreach ($liste as $val)
        {
            echo '<tr><td>' . $val['nom'] . '</td><td><button id="' . $val['id'] . '" class="btn-sup"></button></td></tr>';
        }
    }
}