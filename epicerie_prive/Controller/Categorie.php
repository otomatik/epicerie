<?php

class Controller_Categorie extends Controller_Template
{
    
    protected $produitsModel;

    protected function __construct()
    {
	parent::__construct();
	$this->selfModel = new Model_Categorie();
	$this->produitsModel = null;
    }

    public function display($id)
    {
	$categorie = $this->selfModel->getById($id);
	if(!$categorie)
	{
	    Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	}
	else
	{
	    $this->produitsModel = new Model_Produit();
	    $produits = $this->produitsModel->getByCategorie($id);
	    $categories_filles = $this->selfModel->getCategoriesFilles($id);
	    $categorie_mere = $this->selfModel->getById($categorie['categorie']);
	    $ariane = (isset($categorie_mere['nom'])) ? $categorie_mere['nom'] . ' > ' : '' ;
	    $title = html("Tous les produits > " . $ariane . $categorie['nom']);
	    header('Content-Type: text/html; charset=utf-8');
	    require 'View/header.tpl';
	    require 'View/categorie/display.tpl';
	    require 'View/rightcol.tpl';
	    require 'View/footer.tpl';
	}
    }
    
    public function create($nom = null, $categorie = null)
    {
	$this->categoriesModel = new Model_Categorie();	
	if(isset($nom))
	{
	    $envoi = true;
	    if(!empty($nom))
	    {
		$this->selfModel->insertCategorie($nom, $categorie);
	    }
	    else
		$erreur = "Vous devez renseigner tous les champs.";
	}
	else
	    $envoi = false;
	
	$categories = $this->categoriesModel->getCategoriesMeres();
	$title = "Ajouter une categorie";
	header('Content-Type: text/html; charset=utf-8');
	require 'View/header.tpl';
	require 'View/categorie/create.tpl';
	require 'View/rightcol.tpl';
	require 'View/footer.tpl';
    }
    
}

