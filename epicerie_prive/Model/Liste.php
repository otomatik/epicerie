<?php

class Model_Liste extends Model_Template
{
    
    protected $selectAllProduits;
    protected $selectByMembre;
    protected $insertListe;

    public function __construct()
    {
	parent::__construct();
	$sql = 'SELECT id_liste, label, achat
		FROM liste_membre
		WHERE membre = ?
		ORDER BY achat ASC';
	$this->selectAll = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT label, achat
		FROM liste_membre
		WHERE id_liste = ?';
	$this->selectById = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT label, id_liste, achat
		FROM liste_membre
		WHERE membre = ?';
	$this->selectByMembre = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT p.id_produit, p.label, l.quantite
		FROM liste AS l
		INNER JOIN produit AS p on p.id_produit = l.produit
		WHERE l.liste = ?
		ORDER BY p.label';
	$this->selectAllProduits = Controller_Template::$db->prepare($sql);
	
	$sql = 'INSERT INTO liste_membre (id_liste, label, membre, achat)
		VALUES (NULL , ? , ?, ?)';
	$this->insertListe = Controller_Template::$db->prepare($sql);
	
	$sql = 'INSERT INTO liste (liste, produit)
		VALUES (? , ?)';
	$this->insertProduit = Controller_Template::$db->prepare($sql);
    }
    
    function getAllProduits($id_liste)
    {
	$this->selectAllProduits->execute(array($id_liste));
	return $this->selectAllProduits->fetchAll();
    }
    
    function getAll($id_membre)
    {
	$this->selectAll->execute(array($id_membre));
	$listes = $this->selectAll->fetchAll();
	$listes_distinctes = array('persos' => array(), 'achats' => array());
	foreach($listes as $liste) :
	    $i = $liste['achat'] == 0 ? 'persos' : 'achats';
	    $listes_distinctes[$i][] = $liste;
	endforeach;
	return $listes_distinctes;
    }
    
    function getByMembre($id_membre)
    {
	$this->selectByMembre->execute(array($id_membre));
	return $this->selectByMembre->fetchAll();
    }
    
    function insertListe($nom, $id_membre, $achat = '0')
    {
	$this->insertListe->execute(array($nom, $id_membre, $achat));
	return Controller_Template::$db->lastInsertId();
    }
    
    function insertProduit($id_produit, $id_liste)
    {
	$this->insertProduit->execute(array($id_liste, $id_produit));;
    }

}