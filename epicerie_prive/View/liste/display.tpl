<?php if(empty($produits)) : ?>
<p>La liste est vide</p>
<?php else :
	if($liste['achat'] == 1) 
	    echo '<a href="#" class="yellow-button" style="float: right; margin-top:-43px" onclick="window.print();return false;"><span>Imprimer</span></a>';
?>
<ul>
<?php
$id_produits = array();
$total = 0;
foreach($produits as $produit) :
    $id_produits[] = $produit['id_produit'];
    $total =+ $produit['prix'];
?>
<li>
    <a href="<?php url('produit/' . $produit['id_produit'] . '-' . $produit['label']); ?>">
	<?php echo $produit['label'];?>
    </a>
    <?php echo ($liste['achat'] == '1') ? " (".$produit['quantite'].")" : "";?>
</li>
<?php
endforeach;
?>
</ul>
<?php echo ($liste['achat'] == '1') ? '<h3>Total : ' . number_format($total, 2, ',', ' ') . ' €</h3>' : ''; ?>
    <?php if(is_client()) : ?>
    <form method="post" action="<?php url('panier'); ?>">
	<input type="hidden" name="id_produits" value="<?php echo implode(',', $id_produits);?>" />
	<input class="submit" type="submit" name="add_multiple" value="Ajouter au panier" />
    </form>
<a class="yellow-button" href="<?php url('listes'); ?>"><span>Retour aux listes</span></a>
<?php endif;
endif; ?>