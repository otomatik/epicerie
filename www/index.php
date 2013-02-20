<?php

session_start();

require 'functions.php';

spl_autoload_register('generic_autoload');

$GLOBALS['menu'] = array
(
    'tous' => array('' => 'Accueil', 'produits' => 'Nos produits'),
    'client' => array('listes' => 'Mes listes', 'panier' => 'Mon panier'),
    'admin' => array('admin' => 'Administration'),
    'non-membre' => array('inscription' => 'Inscription')
);

Controller_Template::$db = new MyPDO('***');

$_SERVER['HTTP_ROOT'] = "/epicerie/";

preg_match("#^{$_SERVER['HTTP_ROOT']}([a-z]+\.?[a-z]+)#", $_SERVER['REQUEST_URI'], $match);

/* Liste des appels possibles et des droits nécessaires :
    /url			[droit]	 page
    /				[tous]	 accueil
    /produit/id-label		[tous]	 un produit
    /produits			[tous]	 tous les produits
    /produits/id-catégorieMère	[tous]	 toutes les sous-categories d'une catégorie
    /produits/id-catégorieFille	[tous]	 tous les produits d'une sous-catégorie
    /admin			[admin]	 panel d'administration
    /admin/clients		[admin]	 tous les clients du site
    /produits/ajout		[admin]	 ajouter un nouveau produit
    /categories/ajout		[admin]	 ajouter une nouvelle catégorie
    /listes(.json)		[client] toutes les listes d'un client (optionnel : au format json)
    /listes/ajout		[client] ajout d'une liste
    /liste/id-label		[client] tous les produits d'une liste
    /liste/ajout		[client] ajouter un produit à une liste
    /panier(.json)		[client] tous les produits ajoutés au panier (au format json)
    /compte			[membre] informations concernant le membre
    /inscription		[tous]	 créer un nouveau client
    /connexion			[tous]	 connexion d'un membre
    /deconnexion		[membre] déconnexion d'un membre
 */

if(empty($match[1]))
{
    $controller = Controller_Template::getInstance('Index');
    $controller->index();
}
else
{
    switch($match[1])
    {
	case 'categories':
	    if(preg_match("#^{$_SERVER['HTTP_ROOT']}categories/ajout$#", $_SERVER['REQUEST_URI'], $match))
	    {
		if(is_admin())
		{
		    $controller = Controller_Template::getInstance('Categorie');
		    if(isset($_POST['nom']))
			$controller->create(html($_POST['nom']), html($_POST['categorie']));
		    else
			$controller->create();
		}
		else
		    Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	    }
	    break;
	case 'produits':
	    if(preg_match("#^{$_SERVER['HTTP_ROOT']}produits/ajout$#", $_SERVER['REQUEST_URI'], $match))
	    {
		if(is_admin())
		{
		    $controller = Controller_Template::getInstance('Produit');
		    if(isset($_POST['label']) && isset($_POST['prix']) && isset($_POST['stock']) && isset($_POST['categorie']))
			$controller->create(html($_POST['label']), html($_POST['prix']), html($_POST['stock']), html($_POST['categorie']), $_FILES['image']);
		    else
			$controller->create();
		}
		else
		    Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	    }
	    elseif(preg_match("#^{$_SERVER['HTTP_ROOT']}produits/([0-9]+)-.*$#", $_SERVER['REQUEST_URI'], $match))
	    {
		$controller = Controller_Template::getInstance('Categorie');
		$controller->display($match[1]);
	    }
	    elseif(preg_match("#^{$_SERVER['HTTP_ROOT']}produits(\/?)$#", $_SERVER['REQUEST_URI'], $match))
	    {
		$controller = Controller_Template::getInstance('Produit');
		$controller->index();
	    }
	    break;
	case 'produit':
	    if(preg_match("#^{$_SERVER['HTTP_ROOT']}produit/([0-9]+)-.*$#", $_SERVER['REQUEST_URI'], $match))
	    {
		$controller = Controller_Template::getInstance('Produit');
		if(isset($_POST['delete']) && is_admin())
		    $controller->delete($match[1]);
		else
		    $controller->display($match[1]);
	    }
	    else
		Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	    break;
	case 'panier':
	    if(is_client())
	    {
		$controller = Controller_Template::getInstance('Panier');
		if(isset($_POST['remove']))
		{
		    $controller->remove();
		}
		elseif(isset($_POST['clean']))
		{
		    $controller->clean();
		}
		elseif(isset($_POST['add']))
		{
		    $controller->add();
		}
		elseif(isset($_POST['add_multiple']))
		{
		    $controller->add_multiple();
		}
		elseif(isset($_POST['maj']))
		{
		    $controller->maj();
		}
		elseif(isset($_POST['valid']))
		{
		    $controller->valid();
		}
		else
		{
		    $controller->display();
		}
	    }
	    else
		Controller_Error::connectionNeeded("Accès réservé");
	    break;
	case 'panier.json':
	    if(is_client())
	    {
		$controller = Controller_Template::getInstance('Panier');
		$controller->json_display();
	    }
	    break;
	case 'listes':
	    if(preg_match("#^{$_SERVER['HTTP_ROOT']}listes/ajout$#", $_SERVER['REQUEST_URI'], $match))
	    {
		if(is_client())
		{
		    $controller = Controller_Template::getInstance('Liste');
		    if(isset($_POST['label']))
			$controller->create(html($_POST['label']));
		    else
			$controller->create();
		}
		else
		    Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	    }
	    else
	    {
		$controller = Controller_Template::getInstance('Liste');
		$controller->index($_SESSION['membre']['id_membre']);
	    }
	    break;
	case 'listes.json':
	    if(is_client())
	    {
		$controller = Controller_Template::getInstance('Liste');
		$controller->json_index($_SESSION['membre']['id_membre']);
	    }
	    break;
	case 'liste':
	    if(preg_match("#^{$_SERVER['HTTP_ROOT']}liste/([0-9]+)-.*$#", $_SERVER['REQUEST_URI'], $match))
	    {
		$controller = Controller_Template::getInstance('Liste');
		if(is_client() || is_admin())
		    $controller->display($match[1]);
		else
		    Controller_Error::connectionNeeded("Accès réservé");
	    }
	    elseif(preg_match("#^{$_SERVER['HTTP_ROOT']}liste/ajout$#", $_SERVER['REQUEST_URI'], $match))
	    {
		$controller = Controller_Template::getInstance('Liste');
		if(isset($_POST['add']))
		    $controller->addProduit(html($_POST['id_liste']), html($_POST['id_produit']));;
	    }
	    else
		Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	    break;
	case 'recherche':
	    if(isset($_GET['query']))
	    {
		$controller = Controller_Template::getInstance('Produit');
		if(preg_match("#^{$_SERVER['HTTP_ROOT']}recherche\?query=([a-z]*)$#", $_SERVER['REQUEST_URI'], $match))
		{
			$controller->search($match[1]);
		}
		else
		    Controller_Error::emptySearch("Recherche incorrecte");
			    
	    }
	    else
		Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	    break;
	case 'recherche.json':
	    if(preg_match("#^{$_SERVER['HTTP_ROOT']}recherche.json\?query=([a-z]+)$#", $_SERVER['REQUEST_URI'], $match))
	    {
			$controller = Controller_Template::getInstance('Produit');
			$controller->json_search($match[1]);
	    }
	    break;
	case 'admin':
	    if(is_admin())
	    {
		if(preg_match("#^{$_SERVER['HTTP_ROOT']}admin/clients$#", $_SERVER['REQUEST_URI'], $match))
		{
		    $controller = Controller_Template::getInstance('Membre');
		    $controller->index();
		}
		else
		{
		    $controller = Controller_Template::getInstance('Admin');
		    $controller->index();
		}
	    }
	    else
		Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	    break;
	case 'achats':
	    if(preg_match("#^{$_SERVER['HTTP_ROOT']}achats/([0-9]+)-([a-z]+)*$#", $_SERVER['REQUEST_URI'], $match))
	    {
		$controller = Controller_Template::getInstance('Liste');
		if(is_admin())
		    $controller->index($match[1], $match[2]);
		else
		    Controller_Error::connectionNeeded("Accès réservé");
	    }
	    else
		Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	    break;
	case 'inscription':
	    if(!isset($_SESSION['membre']))
	    {
		$controller = Controller_Template::getInstance('Membre');
		$controller->create();
	    }
	    else
		Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	    break;
	case 'connexion':
	    if(!isset($_SESSION['membre']))
	    {
		$controller = Controller_Template::getInstance('Membre');
		if(isset($_POST['email']) && isset($_POST['mdp']))
		    $controller->connect(html($_POST['email']), html($_POST['mdp']));
		else
		    $controller->connect();
	    }
	    else
		Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
	    break;
	case 'deconnexion':
	    if(isset($_SESSION['membre']))
	    {
		$controller = Controller_Template::getInstance('Membre');
		$controller->deconnect();
	    }
	    else
		Controller_Error::documentNotFound("Erreur");
	    break;
	case 'compte':
	    if(isset($_SESSION['membre']))
	    {
		$controller = Controller_Template::getInstance('Membre');
		if(isset($_POST['edit']))
		    $controller->edit($_SESSION['membre']['id_membre']);
		else
		    $controller->display($_SESSION['membre']['id_membre']);
	    }
	    else
		Controller_Error::connectionNeeded("Accès réservé");
	    break;
	default:
	    Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
    }
}
?>
