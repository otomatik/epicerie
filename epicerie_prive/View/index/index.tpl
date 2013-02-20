<p>Bienvenue chez Polo & Toto - Epicerie</p><br/>
<div class="categorie third">
    <h3 class="titre-categorie">Derniers produits</h3>
    <ul>
    <?php foreach($derniersProduits as $produit) : ?>
	<li><a href="<?php url('produit/' . $produit['id_produit'] .'-'. $produit['label']);?>" ><?php echo $produit['label']; ?></a></li>
    <?php endforeach; ?>
    </ul>
</div>
<div class="categorie">
    <h3 class="titre-categorie">Meilleures ventes</h3>
    <ul>
    <?php foreach($meilleureVente as $produit) : ?>
	<li><a href="<?php url('produit/' . $produit['id_produit'] .'-'. $produit['label']);?>" ><?php echo $produit['label']; ?></a></li>
    <?php endforeach; ?>
    </ul>
</div>
<div class="categorie">
    <h3 class="titre-categorie">Produits au hasard</h3>
    <ul>
    <?php foreach($hasards as $produit) : ?>
	<li><a href="<?php url('produit/' . $produit['id_produit'] .'-'. $produit['label']);?>" ><?php echo $produit['label']; ?></a></li>
    <?php endforeach; ?>
    </ul>
</div>