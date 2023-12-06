<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

class Equipes {
    private $id;
    private $j_id;
    private $m_id;
    private $j1_id;
    private $j1_nom;
    private $j2_id;
    private $j2_nom;
    private $j3_id;
    private $j3_nom;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM equipes WHERE id = ' . $id;
            if ($result = Connexion::query($req)){
                $result = $result[0];
                $this->setId($result['id']);
                $this->setJ_id($result['j_id']);
                $this->setM_id($result['m_id']);
                $this->setJ1_id($result['j1_id']);
                $this->setJ1_nom($result['j1_nom']);
                $this->setJ2_id($result['j2_id']);
                $this->setJ2_nom($result['j2_nom']);
                $this->setJ3_id($result['j3_id']);
                $this->setJ3_nom($result['j3_nom']);
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

    public function getM_id()
    {
        return $this->m_id;
    }

    public function setM_id($m_id)
    {
        $this->m_id = $m_id;
    }

    public function getJ1_id()
    {
        return $this->j1_id;
    }

    public function setJ1_id($j1_id)
    {
        $this->j1_id = $j1_id;
    }

    public function getJ1_nom()
    {
        return $this->j1_nom;
    }

    public function setJ1_nom($j1_nom)
    {
        $this->j1_nom = $j1_nom;
    }

    public function getJ2_id()
    {
        return $this->j2_id;
    }

    public function setJ2_id($j2_id)
    {
        $this->j2_id = $j2_id;
    }

    public function getJ2_nom()
    {
        return $this->j2_nom;
    }

    public function setJ2_nom($j2_nom)
    {
        $this->j2_nom = $j2_nom;
    }

    public function getJ3_id()
    {
        return $this->j3_id;
    }

    public function setJ3_id($j3_id)
    {
        $this->j3_id = $j3_id;
    }

    public function getJ3_nom()
    {
        return $this->j3_nom;
    }

    public function setJ3_nom($j3_nom)
    {
        $this->j3_nom = $j3_nom;
    }

    static function creation_equipes($j_id, $m_id)
    {
        // Liste de joueurs présents
        $liste_joueurs = Joueurs::liste_joueurs_presents();
        $joueurs = [];
        foreach ($liste_joueurs as $joueur)
        {
            $joueurs[] = $joueur['nom'];
        }

        // Mélanger la liste de joueurs de manière aléatoire
        shuffle($joueurs);

        $equipes = [];
        
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
            $equipes[] = $equipe;
        }
        
        return $equipes;
    }
    
    function insert()
    {
        $req = 'INSERT INTO equipes values (
                    NULL,
                    "' . $this->getNom_joueur() . '",
            "0")';
        return Connexion::query($req);
    }
}