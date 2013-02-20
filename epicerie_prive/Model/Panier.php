<?php

class Model_Panier extends Model_Template
{

    protected $selectAllProduits;
    protected $insertProduit;
    protected $majPanier;
    protected $removeProduit;
    protected $removeAllProduits;

    public function __construct()
    {
	parent::__construct();
	$sql = 'SELECT p.id_produit, p.label, p.prix, c.quantite
		FROM panier AS c
		INNER JOIN produit AS p ON c.produit = p.id_produit
		WHERE c.client = ?';
	$this->selectAllProduits = Controller_Template::$db->prepare($sql);

	$sql = 'INSERT
		INTO panier (client, produit, quantite)
		VALUES (?, ?, ?)';
	$this->insertProduit = Controller_Template::$db->prepare($sql);
	
	$sql = 'UPDATE panier
		SET quantite = ?
		WHERE client = ?
		AND produit = ?';
	$this->majPanier = Controller_Template::$db->prepare($sql);

	$sql = 'DELETE
		FROM panier
		WHERE client = ? AND produit = ?';
	$this->removeProduit = Controller_Template::$db->prepare($sql);

	$sql = 'DELETE
		FROM panier
		WHERE client = ?';
	$this->removeAllProduits = Controller_Template::$db->prepare($sql);
    }

    public function getAllProduits($id)
    {
	$this->selectAllProduits->execute(array($id));
	$panier = $this->selectAllProduits->fetchAll();
	return empty($panier[0]) ? array() : $panier;
    }

    public function addProduit($idProduit, $idClient, $quantite)
    {
	return $this->insertProduit->execute(array($idClient, $idProduit, $quantite));
    }
    
    public function majPanier($idProduit, $idClient, $quantite)
    {
	
	return $this->majPanier->execute(array($quantite, $idClient, $idProduit));
    }

    public function removeProduit($idProduit, $idClient)
    {
	return $this->removeProduit->execute(array($idClient, $idProduit));
    }

    public function removeAllProduits($idClient)
    {
	return $this->removeAllProduits->execute(array($idClient));
    }

}