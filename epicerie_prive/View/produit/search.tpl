<?php if(!empty($produits)) : ?>
	<ul>
	<?php
	foreach($produits as $produit) : ?>
		<li>
			<a
			href="<?php url('produit/' . $produit['id_produit'] . '-' . $produit['label']); ?>"
			title="<?php echo html($produit['label']); ?>"><?php echo html($produit['label']); ?>
			</a>
		</li>
	<?php
	endforeach;
	?>
	</ul>
<?php else : ?>
	<p>Aucun résultat !</p>
<?php endif; ?>