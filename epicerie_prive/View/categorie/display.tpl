<?php
if(!empty($categories_filles)) :
    echo "<ul>";
    foreach($categories_filles as $categorie) :
?>	
<li><a href="<?php url('produits/' . $categorie['id_categorie'] . '-' .$categorie['nom']); ?>"><?php echo html($categorie['nom']); ?></a></li>
<?php
    endforeach;
?>
    </ul>
    <a class="yellow-button" href="<?php url('produits'); ?>"><span>Retour aux produits</span></a>
<?php
else :
    if(empty($produits)) :
	echo "<p>Pas encore de produits !</p><br/>";
    else :
	echo '<ul>';
	foreach($produits as $produit) :
?>
<li><a href="<?php url('produit/' . $produit['id_produit'] . '-' . $produit['label']); ?>"><?php echo $produit['label'];?></a></li>
<?php
	endforeach;
    endif;
?>
    </ul>
    <a class="yellow-button" href="<?php url('produits/' . $categorie['categorie'] . '-' . $categorie_mere['nom']); ?>">
	<span>Retour aux <?php echo $categorie_mere['nom'];?></span>
    </a>
<?php
endif;
?>