<?php
$compteur = 0;
foreach($categories as $i => $categorie) :
	$third = ($compteur%3 == 0) ? true :false;
	if(!empty($categorie['produits'])) :
	$compteur ++;
?>
<div class="categorie <?php if($third) echo 'third';?>" >
<h3 class="titre-categorie">
    <a href="<?php url('produits/' . $categorie['id_categorie'] . '-' . $categorie['nom']); ?>"><?php echo html($categorie['nom']); ?></a>
    <span>
	(<a href="<?php url('produits/' . $categorie['id_categorie_mere'] . '-' . $categorie['categorie_mere']); ?>"><?php echo html($categorie['categorie_mere']); ?></a>)
    </span>
</h3>
<ul>
<?php	foreach($categorie['produits'] as $j => $produit) : ?>
	<li>
	    <a
		href="<?php url('produit/' . $produit['id_produit'] . '-' . $produit['label']); ?>"
		title="<?php echo html($produit['label']); ?>"><?php echo html($produit['label']); ?>
	    </a>
	</li>
	<?php
	    if($j == 2) :
		echo '<li><a href="';
		url('produits/' . $categorie['id_categorie'] . '-' . $categorie['nom']);
		echo '">...</a></li>';
		break;
	    endif;
	endforeach;
	?>
</ul>
</div>
<?php endif;
endforeach; ?>