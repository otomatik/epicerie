<?php
echo isset($erreur) && !empty($erreur) ? $erreur ."<br/>" : "";
if(empty($panier))
{
    if(!isset($erreur) || empty($erreur))
	echo '{"vide" : "Votre panier est vide."}';
}
else
{
    echo json_encode($panier);
}
