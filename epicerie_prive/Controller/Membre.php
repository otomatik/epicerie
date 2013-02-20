<?php

class Controller_Membre extends Controller_Template
{

    protected function __construct()
    {
	parent::__construct();
	$this->selfModel = new Model_Membre();
    }
    
    public function index()
    {
	$membres = $this->selfModel->getAll();
	
	$title = "Gestion des clients";
	header('Content-Type: text/html; charset=utf-8');
	require 'View/header.tpl';
	require 'View/membre/index.tpl';
	require 'View/rightcol.tpl';
	require 'View/footer.tpl';
    }

    public function display($id)
    {
	$membre = $this->selfModel->getById($id);
	if(empty($membre))
	{
	    Controller_Error::documentNotFound();
	}
	else
	{
	    $title = ($membre['type'] == "admin") ? " Compte admin" : "Mes infos";
	    header('Content-Type: text/html; charset=utf-8');
	    require 'View/header.tpl';
	    require 'View/membre/display.tpl';
	    require 'View/rightcol.tpl';
	    require 'View/footer.tpl';
	}
    }

    public function connect($email = null, $mdp = null)
    {
	$identifie = false;
	if(isset($email) || isset($mdp))
	{
	    if(isset($email) && isset($mdp))
		$membre = $this->selfModel->verifierMdp($email, $mdp);
	    if(isset($membre))
	    {
		$_SESSION['membre'] = $membre;
		$identifie = true;
	    }
	}
	if(array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER)
	&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
	{
	    header('Content-Type: application/json; charset=utf-8');
	    if(!$identifie)
		Controller_Error::connectionFailed("Identification mauvaise", true);
	}
	else
	{
	    if($identifie)
		header('Location: /projet');
	    else
		Controller_Error::connectionFailed("Identification mauvaise");
	}
    }

    public function deconnect()
    {
	if(isset($_SESSION['membre']))
	{
	    session_destroy();
	    header('Location: ' . $_SERVER['HTTP_ROOT']);
	}
    }

    public function create()
    {
	$verif = false;
	if
	(
		isset($_POST['nom']) ||
		isset($_POST['prenom']) ||
		isset($_POST['mdp']) ||
		isset($_POST['mdp2']) ||
		isset($_POST['email'])
	)
	{
	    $verif = true;
	    $erreurs = $this->selfModel->insert
	    (
		    html($_POST['nom']), html($_POST['prenom']), html($_POST['mdp']), html($_POST['mdp2']), html($_POST['email'])
	    );
	}
	$title = "Inscription";
	header('Content-Type: text/html; charset=utf-8');
	require 'View/header.tpl';
	require 'View/membre/new.tpl';
	require 'View/rightcol.tpl';
	require 'View/footer.tpl';
    }
    
    public function edit($id)
    {
	$verif = false;
	if
	(
		isset($_POST['nom']) ||
		isset($_POST['prenom'])
	)
	{
	    $verif = true;
	    $erreurs = $this->selfModel->update
	    (
		    $id, html($_POST['nom']), html($_POST['prenom'])
	    );
	}
	$this->display($id);
	$this->majSession($id);
    }
    
    private function majSession($id)
    {
	$membre = $this->selfModel->getById($id);
	$_SESSION['membre']['prenom'] = $membre['prenom'];
	$_SESSION['membre']['nom'] = $membre['nom'];
    }

}
