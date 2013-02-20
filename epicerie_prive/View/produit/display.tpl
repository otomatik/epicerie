<table>
    <tr>
	<td class="produit-image">
	    <?php $image = ($produit['image'] == NULL) ? 'default.png' : $produit['image']; ?>
	    <img id="image_produit" src="<?php url('img/' . $image); ?>" />
	</td>
	<td class="produit-infos">
	    <ul>
		<li><?php echo $produit['prix']; ?>€ le kilo</li>
		<?php
		    if($produit['stock'] == 0) echo "<li>Rupture de stock</li>";
		    else echo "<li>".$produit['stock']." kg en stock</li>";
		    
		    if(is_client()) : 
		    if($produit['stock'] > 0) :
		?>
		<li class="submit">
		    <form method="post" action="<?php url('panier'); ?>" >
			<input type="hidden" id="id_produit" name="id_produit" value="<?php echo $id; ?>" />
			Quantité <input class="quantite" type="text" name="quantite" value="1" size="1" />kg&nbsp;
			<input class="submit" id="ajout_panier" style="float: none;" type="submit" name="add" value="Ajouter au panier" />
		    </form>
		</li>
		<?php
		    endif;
		    if(!empty($listes['persos'])) :
		?>
		<li class="submit">
		    <form method="post" action="<?php url('liste/ajout'); ?>" >
			<input type="hidden" name="id_produit" value="<?php echo $id; ?>" />
			<input id="ajout_liste" class="submit" style="float: right;"  type="submit" name="add" value="Ajouter à la liste" />
			<select name="id_liste" id="id_liste">
			<?php foreach($listes['persos'] as $liste) : ?>
			    <option value="<?php echo $liste['id_liste']; ?>"><?php echo html($liste['label']); ?></option>
			<?php endforeach; ?>
			</select>
		    </form>
		    <?php
		    endif;
		    endif;
		    ?>
		</li>
		<?php if(is_admin()) : ?>
		<li style="list-style: none">
		    <form method="post" action="<?php url('produit/' . $id .'-'. $produit['label']); ?>" >
			<input class="submit" type="submit" name="delete" value="Supprimer" />
		    </form>
		</li>
		<?php endif; ?>
	    </ul>
	</td>   
    </tr>
</table>
<a class="yellow-button"  href="<?php url('produits/' . $produit['categorie'] . '-' .$categorie['nom']);?>">
    <span>Retour aux <?php echo html($categorie['nom']); ?></span>
</a>