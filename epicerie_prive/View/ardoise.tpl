<div id="ardoise">
    <?php if(!is_client() && !is_admin()) : ?>
	<h3>Connexion</h3>
	<form method="post" action="<?php url('connexion');?>">
	    <fieldset>
		<table>
		    <tr>
			<td><label>Email</label><input type="text" name="email" value="<?php echo champ('email');?>"/></td>
			<td><label>Mot de passe</label><input type="password" name="mdp"/></td>
		    </tr>
		    <tr>
			<td class="submit">
			    <input class="submit" type="submit" name="connexion" value="Connexion"/>
			    <span>ou bien&nbsp;</span>
			</td>
			<td><a class="yellow-button" href="<?php url('inscription'); ?>"><span>Inscrivez-vous</span></a></td>
		    </tr>
		</table>
	    </fieldset>
	</form>
    <?php else : ?>
	<div>
	    <h3>Mon Compte</h3>
	    <ul>
		<?php menu(array('membre' => array('compte' => 'Mes infos', 'deconnexion"class="yellow-button"' => '<span>Déconnexion</span>'))); ?>
	    </ul>
	</div>
	<?php if(is_admin()) : ?>
	<div>
	    <h3>Admin</h3>
	    <ul>
		<li><a href="<?php url('admin'); ?>">Résultats des ventes</a> / 
		    <a href="<?php url('admin/clients'); ?>">Gestion des clients</a></li>
		
		<li><a class="yellow-button" href="<?php url('produits/ajout'); ?>"><span>Ajouter un produit</span></a></li>
		<li style="float: right; margin-right: 110px;"><a class="yellow-button" href="<?php url('categories/ajout'); ?>"><span>Ajouter une categorie</span></a></li>
	    </ul>
	</div>
	<?php elseif(is_client()) : ?>
	<div>
	    <h3>Mes Listes</h3>
	    <noscript><p class="erreur">Vous devez</p></noscript>
	    <ul id="listes"></ul>
	    <script>get_listes();</script>
	</div>
	<div>
	    <h3>Mon panier</h3>
	    <noscript><p class="erreur">activer javascript !</p></noscript>
	    <ul id="panier"></ul>
	    <script>get_panier();</script>
	</div>
    <?php
	endif;
    endif;
    ?>
</div>