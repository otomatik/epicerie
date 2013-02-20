<form action="" method="post" class="modifiable">
<ul>
    <li>
	<label>Prénom</label>
	<input type="text" name="prenom" size="20" value="<?php echo $membre['prenom'];?>" />
    </li>
    <li>
	<label>Nom</label>
	<input type="text" name="nom" size="20" value="<?php echo $membre['nom'];?>" />
    </li>
    <li class="submit">
	<input class="submit" type="submit" value="Enregistrer" name="edit" />
	<a class="yellow-button" href="<?php url('compte'); ?>"><span>Annuler</span></a>
    </li>
</ul>
</form>
<script>
    $('form.modifiable').before("(Double-cliquez sur une donnée pour l'éditer)");
    $('.modifiable input:not(.submit), .modifiable li.submit').hide();
    $('.modifiable input:not(.submit)').each(function(id, el)
    {
	$('<p>'+$(el).val()+'</p>').insertBefore($(el));
    });
</script>