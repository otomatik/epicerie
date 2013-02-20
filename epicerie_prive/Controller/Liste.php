<?php

class Controller_Liste extends Controller_Template
{
    
    protected $produitsModel;

    protected function __construct()
    {
	parent::__construct();
	$this->selfModel = new Model_Liste();
	$this->produitsModel = null;
    }

    public function display($id)
    {
	$liste = $this->selfModel->getById($id);
	if(!$liste)
	{
	    Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	}
	else
	{
	    $id_produits = $this->selfModel->getAllProduits($id);
	    $produits = array();
	    if(!empty($id_produits))
	    {
		$this->produitsModel = new Model_Produit();
		foreach($id_produits as $i => $produit)
		{
		    $produits[] = $this->produitsModel->getById($produit['id_produit']);
		    $produits[$i]['id_produit'] = $produit['id_produit'];
		    $produits[$i]['quantite'] = $id_produits[$i]['quantite'];
		}
	    }
	    $title = ($liste['achat'] == '1') ? "Achats du " : "" ;
	    $title .= html($liste['label']);
	    header('Content-Type: text/html; charset=utf-8');
	    require 'View/header.tpl';
	    require 'View/liste/display.tpl';
	    require 'View/rightcol.tpl';
	    require 'View/footer.tpl';
	}
    }
    
    public function index($id, $factures = false)
    {
	$listes = $this->selfModel->getAll($id);
	$title = (!$factures) ? "Mes listes" : "Les factures de " . $factures;
	header('Content-Type: text/html; charset=utf-8');
	require 'View/header.tpl';
	require 'View/liste/index.tpl';
	require 'View/rightcol.tpl';
	require 'View/footer.tpl';
    }
    
    public function json_index($id)
    {
	$listes = $this->selfModel->getAll($id);
	header('Content-Type: application/json; charset=utf-8');
	require 'View/liste/json_index.tpl';
    }
    
    public function create($nom = null)
    {
	if(isset($nom))
	{
	    $envoi = true;
	    if(!empty($nom))
	    {
		$this->selfModel->insertListe($nom, $_SESSION['membre']['id_membre']);
	    }
	    else
		$erreur = "Vous devez renseigner tous les champs.";
	}
	else
	    $envoi = false;
	
	$title = "Créer une liste";
	header('Content-Type: text/html; charset=utf-8');
	require 'View/header.tpl';
	require 'View/liste/create.tpl';
	require 'View/rightcol.tpl';
	require 'View/footer.tpl';
    }
    
    public function addProduit($id_liste, $id_produit)
    {
	try
	{
	    $this->selfModel->insertProduit($id_produit, $id_liste);
	    $this->display($id_liste);
	}
	catch(Exception $exc)
	{
	    Controller_Error::alreadyInList("Déjà ajouté !");
	}
    }
    
}

