<?php

class Model_Produit extends Model_Template
{

    protected $selectByCategory;
    protected $selectByDateDesc;
    protected $selectByVenteDesc;
    protected $selectRandom;
    protected $findByLabel;
    protected $insertProduit;
    protected $updateStockProduit;
    protected $updateVenteProduit;
    protected $deleteProduit;

    public function __construct()
    {
	parent::__construct();
	$sql = 'SELECT label, prix, categorie, stock, image
		FROM produit
		WHERE id_produit = ?';
	$this->selectById = Controller_Template::$db->prepare($sql);

	$sql = 'SELECT id_produit, label, prix
		FROM produit
		WHERE categorie = ?
		ORDER BY label';
	$this->selectByCategorie = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT id_produit, label 
		FROM  produit
		ORDER BY date_ajout DESC 
		LIMIT 0 , 5';
	$this->selectByDateDesc = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT id_produit, label 
		FROM  produit
		ORDER BY vente DESC 
		LIMIT 0 , 5';
	$this->selectByVenteDesc = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT id_produit, label 
		FROM  produit
		ORDER BY RAND()
		LIMIT 0 , 5';
	$this->selectRandom = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT DISTINCT id_produit, label
		FROM produit
		WHERE label LIKE ?';
	$this->findByLabel = Controller_Template::$db->prepare($sql);
	
	$sql = 'INSERT
		INTO produit (id_produit, label , prix, categorie, stock, vente, date_ajout, image)
		VALUES (NULL, ?, ?, ?, ?, 0, CURRENT_TIMESTAMP(), ?)';
	$this->insertProduit = Controller_Template::$db->prepare($sql);
	
	$sql = 'UPDATE produit
		SET stock = stock + ?
		WHERE id_produit = ?';
	$this->updateStockProduit = Controller_Template::$db->prepare($sql);
	
	$sql = 'UPDATE produit
		SET vente = vente + 1
		WHERE id_produit = ?';
	$this->updateVenteProduit = Controller_Template::$db->prepare($sql);
	
	$sql = 'DELETE
		FROM produit
		WHERE id_produit = ?';
	$this->deleteProduit = Controller_Template::$db->prepare($sql);

    }

    public function getByCategorie($id)
    {
	$this->selectByCategorie->execute(array($id));
	return $this->selectByCategorie->fetchAll();
    }
    
    public function getByDateAjout()
    {
	$this->selectByDateDesc->execute();
	return $this->selectByDateDesc->fetchAll();
    }
    
    public function getByVente()
    {
	$this->selectByVenteDesc->execute();
	return $this->selectByVenteDesc->fetchAll();
    }
    
    public function getRandom()
    {
	$this->selectRandom->execute();
	return $this->selectRandom->fetchAll();
    }
    
    public function find($label)
    {
	$this->findByLabel->execute(array("%$label%"));
	return $this->findByLabel->fetchAll();
    }
    
    public function insertProduit($label, $prix, $stock, $categorie, $image)
    {
	$this->insertProduit->execute(array($label, $prix, $categorie, $stock, $image));
    }
    
    public function deleteProduit($idProduit)
    {
	$this->deleteProduit->execute(array($idProduit));
    }
    
    public function majStockProduit($idProduit, $stock)
    {
	$this->updateStockProduit->execute(array($stock, $idProduit));
    }
    
    public function majVenteProduit($idProduit)
    {
	$this->updateVenteProduit->execute(array($idProduit));
    }

}