<?php
if($envoi)
{
    echo isset($erreur) ? $erreur : "Le produit a bien été ajouté";
}

$cat = array();
foreach($categories as $i => $categorie)
    $cat[$categorie['categorie_mere']][] = $categorie;
?>
<form method="post" action="<?php url('produits/ajout'); ?>" enctype="multipart/form-data">
    <ul>
	<li>
	    <label for="label">Label</label>
	    <input type="text" name="label" value="" />
	</li>
	<li>
	    <label for="prix">Prix</label>
	    <input type="text" name="prix" value="" size="1" />
	</li>
	<li>
	    <label for="stock">Stock</label>
	    <input type="text" name="stock" value="" size="1" />
	</li>
	<li>
	    <label for="categorie">Catégorie</label>
	    <select name="categorie">
		<?php foreach($cat as $mere => $categories) : ?>
		<optgroup label="<?php echo $mere; ?>">
		    <?php foreach($categories as $categorie) : ?>
			<option value="<?php echo $categorie['id_categorie']; ?>"><?php echo html($categorie['nom']); ?></option>
		    <?php endforeach; ?>
		    </optgroup>
		<?php endforeach; ?>
	    </select>
	</li>
	<li>
	    <label for="file">Image</label>
	    <input type="file" name="image" />
	</li>
	<li class="submit">
	    <input class="submit" type="submit" value="Ajouter" />
	</li>
    </ul>
</form>