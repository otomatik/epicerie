<?php

class Controller_Admin extends Controller_Template
{
    protected $categoriesModel;

    protected function __construct()
    {
	parent::__construct();
	$this->categoriesModel = null;
    }

    public function index()
    {
	$this->categoriesModel = new Model_Categorie();
	$ventes = $this->categoriesModel->getCategoriesVentes();
	foreach($ventes as $i => $vente)
	{
	    $cat = $this->categoriesModel->getById($vente['categorie']);
	    $ventes[$i]['nom'] = $cat['nom'];
	}
	$title = "Résultats des ventes";
	header('Content-Type: text/html; charset=utf-8');
	require "View/header.tpl";
	require "View/admin/index.tpl";
	require "View/rightcol.tpl";
	require "View/footer.tpl";
    }
}
