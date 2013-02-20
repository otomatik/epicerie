<?php
if($envoi)
{
    echo isset($erreur) ? $erreur : "La categorie a bien été ajoutée";
}
?>
<form method="post" action="<?php url('categories/ajout'); ?>" >
    <ul>
	<li>
	    <label>Nom</label>
	    <input type="text" name="nom" value="" />
	</li>
	<li>
	    <label for="categorie">Catégorie mère</label>
	    <select name="categorie">
		<option value="">pas de catégorie parente</option>
		<optgroup label="catégories parentes :">
		<?php foreach($categories as $categorie) : ?>
		    <option value="<?php echo $categorie['id_categorie']; ?>"><?php echo html($categorie['nom']); ?></option>
		<?php endforeach; ?>
		</optgroup>
	    </select>
	</li>
	<li class="submit">
	    <input class="submit" type="submit" value="Ajouter" />
	</li>
    </ul>
</form>