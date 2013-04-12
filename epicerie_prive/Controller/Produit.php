<?php

class Controller_Produit extends Controller_Template
{

    protected $categoriesModel;
    protected $listesModel;

    protected function __construct()
    {
	parent::__construct();
	$this->selfModel = new Model_Produit();
	$this->categoriesModel = null;
    }

    public function index()
    {
	$title = "Tous les produits";
	$this->categoriesModel = new Model_Categorie();
	$categories = $this->categoriesModel->getAll();

	foreach($categories as $i => $categorie)
	{
	    $categories[$i]['produits'] = $this->selfModel->getByCategorie($categorie['id_categorie']);
	}

	header('Content-Type: text/html; charset=utf-8');
	require 'View/header.tpl';
	require 'View/produit/index.tpl';
	require 'View/rightcol.tpl';
	require 'View/footer.tpl';
    }

    public function display($id)
    {
	$produit = $this->selfModel->getById($id);
	
	if(!$produit)
	{
	    Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	}
	else
	{
	    if(is_client()) :
		$this->listesModel = new Model_Liste();
		$listes = $this->listesModel->getAll($_SESSION['membre']['id_membre']);
	    endif;
	    $this->categoriesModel = new Model_Categorie();
	    $categorie = $this->categoriesModel->getById($produit['categorie']);
	    $title = $produit['label'];
	    header('Content-Type: text/html; charset=utf-8');
	    require 'View/header.tpl';
	    require 'View/produit/display.tpl';
	    require 'View/rightcol.tpl';
	    require 'View/footer.tpl';
	}
    }
    
    public function search($label)
    {
	if(empty($label))
	    Controller_Error::emptySearch("Recherche vide");
	else
	{
	    $produits = $this->selfModel->find($label);
	    $title = 'Résultats pour "' . $label .'" :';
	    header('Content-Type: text/html; charset=utf-8');
	    require 'View/header.tpl';
	    require 'View/produit/search.tpl';
	    require 'View/rightcol.tpl';
	    require 'View/footer.tpl';
	}
    }
    
    public function json_search($label)
    {
	$produits = $this->selfModel->find($label);
	$suggestions = array();
	$data = array();
	foreach($produits as $produit)
	{
	    $suggestions[] = $produit['label'];
	    $data[] = $produit['id_produit'];
	}
	$resultats = array("query" => $label, "suggestions" => $suggestions, "data" => $data);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($resultats);
    }
    
    public function delete($id)
    {
	$this->selfModel->deleteProduit($id);
	$this->index();
    }
    
    public function create($label = null, $prix = null, $stock = null, $categorie = null, $image = null)
    {
	$title = "Ajouter un produit";
	$this->categoriesModel = new Model_Categorie();
	$categories = $this->categoriesModel->getAll();
	
	if(!empty($image))
	    move_uploaded_file($image["tmp_name"], $image['name']);
	else
	    $image_name = "NULL";
	
	if(isset($label) && isset($prix) && isset($stock) && isset($categorie))
	{
	    $envoi = true;
	    if(!empty($label) && !empty($prix) && !empty($stock) && !empty($categorie))
	    {
		if(floatval($prix) > 0 && floatval($stock) > 0)
		    $this->selfModel->insertProduit($label, $prix, $stock, $categorie, $image['name']);
		else
		    $erreur = "Vous ne pouvez entrer des valeurs négatives.";
	    }
	    else
		$erreur = "Vous devez renseigner tous les champs.";
	}
	else
	    $envoi = false;
	
	header('Content-Type: text/html; charset=utf-8');
	require 'View/header.tpl';
	require 'View/produit/create.tpl';
	require 'View/rightcol.tpl';
	require 'View/footer.tpl';
    }

}

