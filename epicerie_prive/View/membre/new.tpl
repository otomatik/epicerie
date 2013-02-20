<?php
if(!$verif || ($verif && isset($erreurs)))
{
    if($verif && isset($erreurs))
    {
		echo '<p>Les erreurs suivantes ont été rencontrées :</p>';
		echo '<ul>';
		foreach($erreurs as $e)
		  echo '<li>'.$e.'</li>';
		echo '</ul>';
    }
?>
<form method="post" action="inscription" id="signup-form">
    <fieldset>
	<ul>
	    <li><label>Nom</label><input type="text" id="nom" name="nom" value="<?php echo champ('nom'); ?>" maxlength="100"/></li>
	    <li><label>Prénom</label><input type="text" id="prenom" name="prenom" value="<?php echo champ('prenom'); ?>"maxlength="100"/></li>
	    <li><label>Mot de passe</label><input type="password" id="mdp" name="mdp" maxlength="100"/></li>
	    <li><label>Confirmez-le</label><input type="password" id="mdp2" name="mdp2" maxlength="100"/></li>
	    <li><label>Adresse mail</label><input type="text" value="<?php echo champ('email'); ?>" id="email" name="email" maxlength="100"/></li>
	    <li class="submit"><input class="submit" type="submit" value="Inscription"/><input class="submit" type="reset" value="Annuler"/></li>
	</ul>
    </fieldset>
</form>
<?php
} else {
?>
    <h4>Inscription réussie.</h4>
    <p>Connectez-vous.</p>
<?php	
}
?>