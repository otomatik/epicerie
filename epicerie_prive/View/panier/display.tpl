		<?php
		echo isset($erreur) && !empty($erreur) ? $erreur ."<br/>" : "";
		if(empty($panier))
		{
		    if(!isset($erreur) || empty($erreur))
			echo "Votre panier est vide.";
		}
		else
		{
		    $total = 0;
		    $sous_total = 0;
		?>
		<form method="post" action="panier" id="panier">
		<ul>
		<?php
		    foreach($panier as $i => $produit) :
			$sous_total = floatval($produit['prix']) * floatval($produit['quantite']);
			echo '<li><input class="checkbox" type="checkbox" name="produits[]" value="'.$produit['id_produit'].'" /><label><a href="';
			url('produit/' . $produit['id_produit'].'-'.$produit['label']);
			echo '">' .$produit['label'] . '</a></label>';
			echo '<input type="hidden" name="old_quantites['. $produit['id_produit'] .']" value="' .$produit['quantite'] .'" size="1" />';
			echo '<input class="quantite" type="text" name="quantites['. $produit['id_produit'] .']" value="' .$produit['quantite'] .'" size="1" />kg';
			echo '&nbsp; x '.number_format($produit['prix'], 2, ',', ' ') .'€ = '. number_format($sous_total, 2, ',', ' ') .'€</li>';
			$total += $sous_total;
		    endforeach;
		?>
		    </ul>
		    <ul id="actions">
			<li><input class="submit" type="submit" value="Actualiser" name="maj" /></li>
			<li><input id="enlever" class="submit" type="submit" value="Enlever" name="remove" /></li>
			<li><input id="vider" class="submit" type="submit" value="Vider" name="clean" /></li>
		    </ul>
		<?php } ?>
		</form>
	    </div>
	<div class="block-bottom"></div>
    </div>
</div>
<div id="rightcol">
    <div class="block">
	<div class="block-top"></div>
	<div class="block-content">
	    <?php
	    if(empty($panier))
	    {
	    echo "<h3>Total : 0€</h3>Ajoutez des produits !";
	    }
	    else
	    { ?>
	    <form method="post" action="panier" id="panier">
	    <?php
		foreach($panier as $i => $produit) :
		    echo '<input type="hidden" name="old_quantites['. $produit['id_produit'] .']" value="' .$produit['quantite'] .'" size="1" />';
		    echo '<input class="quantite hidden" type="text" name="quantites['. $produit['id_produit'] .']" value="' .$produit['quantite'] .'" size="1" />';
		endforeach;
	    ?>
	    <h3><?php echo "Total : " . number_format($total, 2, ',', ' ') . "€"; ?></h3>
	    <input class="submit" type="submit" value="Valider" name="valid" />
	    </form>
	    <?php } ?>
	</div>
	<div class="block-bottom"></div>
    </div>
    <?php echo eval('?>'.file_get_contents('View/rightcol.tpl', 'FILE_USE_INCLUDE_PATH', null, 97)); ?>