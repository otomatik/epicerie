<?php
if($envoi)
{
    echo isset($erreur) ? $erreur : "La liste a bien été créée";
}
?>
<form method="post" action="<?php url('listes/ajout'); ?>" >
    <ul>
	<li>
	    <label for="label">Label</label>
	    <input type="text" name="label" value="" />
	</li>
	<li class="submit">
	    <input class="submit" type="submit"  value="Créer" />
	    <a class="yellow-button" href="<?php url('listes'); ?>"><span>Retour aux listes</span></a>
	</li>
    </ul>
</form>