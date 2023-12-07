<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

class Parties {
    private $id;
    private $date;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM parties WHERE id = ' . $id;
            if ($result = Connexion::query($req)){
                $result = $result[0];
                $this->setId($result['id']);
                $this->setDate(date('d-m-Y'));
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

    public function getdate()
    {
        return $this->date;
    }

    public function setdate($date)
    {
        $this->date = $date;
    }

// fin  --- getters setters

    function ajouter_partie()
    {
        $req = 'INSERT INTO parties values (
                    NULL,
                    "' . $this->getDate() . '"
                )';
        return Connexion::query($req);
    }

    function supprimer_partie()
    {
        $req = 'DELETE FROM parties WHERE id = "' . $this->getId() . '"';
        return Connexion::query($req);
    }

    function delete_all_parties()
    {
        $req = 'DELETE FROM parties';
        return Connexion::query($req);
    }

    static function liste_parties()
    {
        $liste_parties = array();
        $req = 'SELECT id, date FROM parties ORDER BY `date` DESC';
        if ($result = Connexion::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $liste_parties[] = $value;
                }
            }
        }
        return $liste_parties;
    }

    static function partie_id($date)
    {
        $id = [];
        foreach (self::liste_parties() as $values)
        {
            if($values['date'] == $date)
                $id[] = $values['id'];
        }
        return $id[0];
    }
}