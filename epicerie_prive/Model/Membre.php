<?php

class Model_Membre extends Model_Template
{

    protected $selectByEmail;
    protected $selectMdpByEmail;
    protected $insert;
    protected $update;

    public function __construct()
    {
	parent::__construct();
	$sql = 'SELECT id_membre, nom, prenom, email
		FROM membre
		WHERE type = \'client\'';
	$this->selectAll = Controller_Template::$db->prepare($sql);
	
	$sql = 'SELECT nom, prenom, email, type
		FROM membre
		WHERE id_membre = ?';
	$this->selectById = Controller_Template::$db->prepare($sql);

	$sql = 'SELECT id_membre, nom, prenom, type
		FROM membre
		WHERE email = ?';
	$this->selectByEmail = Controller_Template::$db->prepare($sql);

	$sql = 'SELECT mdp
		FROM membre
		WHERE email = ?';
	$this->selectMdpByEmail = Controller_Template::$db->prepare($sql);

	$sql = "INSERT INTO membre
		VALUES (:id_membre, :nom, :prenom, :email, :mdp, :type)";
	$this->insert = Controller_Template::$db->prepare($sql);
	
	$sql = "UPDATE membre
		SET nom = :nom , prenom = :prenom
		WHERE  id_membre = :id;";
	$this->update = Controller_Template::$db->prepare($sql);
    }

    public function getByEmail($email)
    {
	$this->selectByEmail->execute(array($email));
	$membres = $this->selectByEmail->fetchAll();
	return empty($membres[0]) ? array() : $membres[0];
    }
    
    public function update($id, $nom, $prenom)
    {
	$this->update->execute
			(
			    array
			    (
				    ':nom' => $nom,
				    ':prenom' => $prenom,
				    ':id' => $id
			    )
			);
    }

    public function insert($nom, $prenom, $mdp, $mdp2, $email)
    {
	if
	(
	    $this->identiteValide($nom) &&
	    $this->identiteValide($prenom) &&
	    $mdp === $mdp2 &&
	    strlen($mdp) > 4 &&
	    $this->emailValide($email) &&
	    $this->emailUnique($email)
	)
	{
	    $this->insert->execute(
		array
		(
			':id_membre' => "",
			':nom' => $nom,
			':prenom' => $prenom,
			':email' => $email,
			':mdp' => md5($mdp),
			':type' => 1
		)
	    );
	    return null;
	}
	else
	{
	    if($mdp != $mdp2)
		$erreurs[] = "Les mots de passe ne sont pas identiques.";
	    if(strlen($mdp) <= 4)
		$erreurs[] = "Le mot de passe doit mesurer plus de 4 caractères.";
	    if(!$this->emailValide($email))
		$erreurs[] = "L'email saisit est invalide.";
	    if(!$this->emailUnique($email))
		$erreurs[] = "L'email saisit est déjà utilisé.";
	    if(!$this->identiteValide($nom) || !$this->identiteValide($prenom))
		$erreurs[] = "Le nom et le prénom ne peuvent contenir que des caractères alphabétiques.";
	    return $erreurs;
	}
    }

    public function verifierMdp($email, $mdp)
    {
	if($this->emailValide($email))
	{
	    $this->selectMdpByEmail->execute(array($email));
	    $tab = $this->selectMdpByEmail->fetch();
	    $md5Mdp = $tab['mdp'];
	    $mdp = md5($mdp);
	    return ($mdp === $md5Mdp) ? $this->getByEmail($email) : null;
	}
	return null;
    }

    private function identiteValide($id)
    {
	return (gettype($id) == 'string' && preg_match("([a-zA-Z]$)", $id) === 1);
    }

    private function emailValide($email)
    {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function emailUnique($email)
    {
	$this->selectByEmail->execute(array($email));
	return $this->selectByEmail->rowCount() === 0;
    }

}
