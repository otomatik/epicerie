<?php
if(is_client()) :
    if(!empty($listes['achats']) || !empty($listes['persos'])) : ?>
<ul>
    <?php
    if(!empty($listes['persos'])) :
	foreach($listes['persos'] as $liste) :
    ?>
	<li><a href="<?php url('liste/'.$liste['id_liste'].'-'.$liste['label']);?>"><?php echo html($liste['label']); ?></a></li>
    <?php
	endforeach;
    endif;
    if(!empty($listes['achats'])) :
	echo "<li>Achats du : </li><ul>";
	foreach($listes['achats'] as $liste) :
    ?>
	<li><a href="<?php url('liste/'.$liste['id_liste'].'-achats');?>"><?php echo html($liste['label']); ?></a></li>
    <?php
	endforeach;
	echo "</ul>";
    endif;
    ?>
</ul>
<?php else : ?>
    <p>Vous n'avez pas créé de liste ni effectué d'achats</p><br/>
<?php endif; ?>
<a class="yellow-button"href="<?php url('listes/ajout');?>"><span>Nouvelle liste</span></a>
<?php
else :
    echo "<ul>";
    foreach($listes['achats'] as $liste) :
?>
	<li><a href="<?php url('liste/'.$liste['id_liste'].'-achats');?>"><?php echo html($liste['label']); ?></a></li>
<?php
    endforeach;
    echo "</ul>";
endif;
?>