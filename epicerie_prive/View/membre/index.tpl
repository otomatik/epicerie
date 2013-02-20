<table class="clients">
    <thead>
	<th>Nom</th>
	<th>Prénom</th>
	<th>Email</th>
	<th>Facture</th>
    </thead>
    <tbody>
	<?php foreach($membres as $membre) : ?>
	<tr>
	    <td><?php echo $membre['nom']; ?></td>
	    <td><?php echo $membre['prenom']; ?></td>
	    <td><?php echo $membre['email']; ?></td>
	    <td><a href="<?php url('achats/'.$membre['id_membre'].'-'.$membre['prenom']); ?>">voir</a></td>
	</tr>
	<?php endforeach; ?>
    </tbody>
</table>