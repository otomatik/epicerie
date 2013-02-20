<?php

class Controller_Panier extends Controller_Template
{

    protected $produitModel;
    protected $listeModel;

    protected function __construct()
    {
	parent::__construct();
	$this->selfModel = new Model_Panier();
	$this->produitModel = null;
	$this->listeModel = null;
    }

    public function display($erreur = null)
    {
	$panier = $this->selfModel->getAllProduits($_SESSION['membre']['id_membre']);
	$title = "Mon panier";
	header('Content-Type: text/html; charset=utf-8');
	require 'View/header.tpl';
	require 'View/panier/display.tpl';
	require 'View/footer.tpl';
    }
    
    public function json_display($erreur = null)
    {
	$panier = $this->selfModel->getAllProduits($_SESSION['membre']['id_membre']);
	header('Content-Type: application/json; charset=utf-8');
	require 'View/panier/json_display.tpl';
    }

    public function add()
    {
	$this->produitModel = new Model_Produit();
	$produit = $this->produitModel->getById($_POST['id_produit']);
	
	$quantite = is_float(floatval($_POST['quantite'])) && $_POST['quantite'] > 0 ? $_POST['quantite'] : 1;
	if($quantite <= $produit['stock'])
	{
	    try
	    {
		$res = $this->selfModel->addProduit($_POST['id_produit'], $_SESSION['membre']['id_membre'], $quantite);
		$this->display();
	    }
	    catch(Exception $exc)
	    {
		$this->display("Vous avez déjà ajouté ce produit mais vous pouvez en changer la quantité :");
	    }
	}
	else
	    Controller_Error::overStock("Pas assez de stock !");
    }
    
    public function add_multiple()
    {
	$this->produitModel = new Model_Produit();
	$err_deja = array();
	$err_stock = array();
	$id_produits = explode(',', $_POST['id_produits']);
	foreach($id_produits as $id) :
	    $produit = $this->produitModel->getById($id);
	    if($produit['stock'] > 0)
	    {
		try
		{
		    $res = $this->selfModel->addProduit($id, $_SESSION['membre']['id_membre'], 1);
		}
		catch(Exception $exc)
		{
		    $err_deja[] = $produit['label'];
		}
	    }
	    else $err_stock[] = $produit['label'];
	endforeach;
	$erreurs = (!empty($err_deja)) ? "Les produits suivants étaient déjà dans le panier : " . implode(", ", $err_deja) : "";
	$erreurs .= (!empty($err_stock)) ? "<br/>Le stock pour les produits suivant est épuisé : " . implode(", ", $err_stock) : "";
	$this->display($erreurs);
    }
    
    public function remove()
    {
	$this->produitModel = new Model_Produit();
	if(isset($_POST['produits'])) :
	    foreach($_POST['produits'] as $id_produit) :
		$this->produitModel->majStockProduit($id_produit, html($_POST['quantites'][$id_produit]));
		$res = $this->selfModel->removeProduit($id_produit, $_SESSION['membre']['id_membre']);
	    endforeach;
	    $this->display();
	else :
	    $this->display("Vous devez selectionner au moins un produit à retirer :");
	endif;
    }

    public function maj()
    {
	$this->produitModel = new Model_Produit();
	$err = array();
	if(isset($_POST['quantites']))
	{
	    foreach($_POST['quantites'] as $id_produit => $quantite)
	    {
	    	$produit = $this->produitModel->getById($id_produit);
		$quantite = is_float(floatval($quantite)) && $quantite > 0 ? $quantite : 1;
		$old_quantite = html($_POST['old_quantites'][$id_produit]);
		if(abs($quantite - $old_quantite) <= $produit['stock'])
		    $res = $this->selfModel->majPanier($id_produit, $_SESSION['membre']['id_membre'], $quantite);
		else
		    $err[] = $produit['label'];
	    }
	    $erreur = !empty($err) ? "Les quantités demandées pour les produits suivants sont supérieures au stock disponible : " . implode(", ", $err) : null;
	    $this->display($erreur);
	}
	else    
	    $this->display("Vous devez modifier au moins un produit :");
    }

    public function clean()
    {
	$this->produitModel = new Model_Produit();
	foreach($_POST['quantites'] as $id_produit => $quantite)
	{
	    $this->produitModel->majStockProduit($id_produit, $quantite);
	}
	$res = $this->selfModel->removeAllProduits($_SESSION['membre']['id_membre']);
	$this->display();
    }
    
    public function valid()
    {
	$this->produitModel = new Model_Produit();
	$this->listeModel = new Model_Liste();
	$id_liste = $this->listeModel->insertListe(date("d/m/y (H\hi)"), $_SESSION['membre']['id_membre'], '1');
	$produits = $this->selfModel->getAllProduits($_SESSION['membre']['id_membre']);
	
	foreach($produits as $produit)
	{
	    $this->listeModel->insertProduit($produit['id_produit'], $id_liste);
	    $this->produitModel->majVenteProduit($produit['id_produit']);
	}
	
	$res = $this->selfModel->removeAllProduits($_SESSION['membre']['id_membre']);
	$this->display("Votre commande a bien été prise en compte.");
    }

}

