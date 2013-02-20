<?php

class Controller_Index extends Controller_Template
{
    
    protected $produitsModel;
    
    public function index()
    {
	$this->produitsModel = new Model_Produit();
	
	$derniersProduits = $this->produitsModel->getByDateAjout();
	$meilleureVente = $this->produitsModel->getByVente();
	$hasards = $this->produitsModel->getRandom();
	
	$title = "Une petite épicerie";
	header('Content-Type: text/html; charset=utf-8');
	require 'View/header.tpl';
	require 'View/index/index.tpl';
	require 'View/rightcol.tpl';
	require 'View/footer.tpl';
    }

}

