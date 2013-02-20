<?php

class Model_Categorie extends Model_Template
{

    public function __construct()
    {
	parent::__construct();
	$sql = 'SELECT c.id_categorie, c.nom, d.id_categorie as id_categorie_mere, d.nom as categorie_mere, COUNT(*) AS nb_produits
		FROM categorie AS c
		INNER JOIN categorie AS d on c.categorie = d.id_categorie
		GROUP BY c.id_categorie, c.nom
		ORDER BY c.nom';
	$this->selectAll = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT nom, categorie
		FROM categorie
		WHERE id_categorie = ?';
	$this->selectById = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT id_categorie, nom
		FROM categorie
		WHERE categorie is null';
	$this->selectCategoriesMeres = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT nom, id_categorie
		FROM categorie
		WHERE categorie = ?';
	$this->selectCategoriesFilles = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT categorie , SUM( vente ) AS ventes
		FROM produit
		GROUP BY categorie';
	$this->selectCategoriesGroupedByVentes = Controller_Template::$db->prepare($sql);
	
	$sql = 'INSERT INTO categorie (id_categorie , nom, categorie)
		VALUES (NULL , ? , ?)';
	$this->insertCategorie = Controller_Template::$db->prepare($sql);
    }
    
    public function getCategoriesMeres()
    {
	$this->selectCategoriesMeres->execute();
	return $this->selectCategoriesMeres->fetchAll();
    }
    
    public function getCategoriesFilles($id)
    {
	$this->selectCategoriesFilles->execute(array($id));
	return $this->selectCategoriesFilles->fetchAll();
    }
    
    public function getCategoriesVentes()
    {
	$this->selectCategoriesGroupedByVentes->execute();
	return $this->selectCategoriesGroupedByVentes->fetchAll();
    }
    
    public function insertCategorie($nom, $categorie)
    {
	if(empty($categorie))
	    $this->insertCategorie->execute(array($nom, NULL));
	else
	    $this->insertCategorie->execute(array(utf8_decode($nom), $categorie));
    }

}

