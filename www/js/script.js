$(document).ready(function()
{
    reequilibre();
    $('form.modifiable p').dblclick(edit_it);
    $('#ardoise form').submit(connect);
    $('#ajout_panier').click(ajout_panier);
    $('#ajout_liste').click(ajout_liste);
    $('#enlever').click(retirer_panier);
    $('#enlever').attr('disabled', 'disabled');
    $('#vider').click(vider_panier);
    $(':checkbox').click(toogle_action_enlever);
    $("#recherche").autocomplete(
    { 
		serviceUrl:'/epicerie/recherche.json',
		minChars:2, 
		maxHeight:400,
		width:165,
		zIndex: 9999,
		onSelect: function(value, data)
		{
			var href = 'href="/epicerie/produit/' + data + '-' + value +'"';
			var html = '<a class="yellow-button" style="margin-top: -26px; float: right" ' + href + '><span>Go</span></a>';
			$("#recherche").next('input').after(html);
		}
    });
    $("#signup-form").validate({
		rules: {
			prenom: "required",
			nom: "required",
			mdp: {
				required: true,
				minlength: 4
			},
			mdp2: {
				required: true,
				minlength: 4,
				equalTo: "#mdp"
			},
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			prenom: "Entrez votre prénom",
			nom: "Entrez votre nom",
			mdp: {
				required: "Entrez un mot de passe",
				minlength: "Taille minimum : 4 caractères"
			},
			mdp2: {
				required: "Confirmer le mot de passe",
				minlength: "Taille minimum : 4 caractères",
				equalTo: "Mots de passe différents !"
			},
			email: "Entrez un email valide"
		}
	});
	
});
function connect()
{
    event.preventDefault();
    var login = $("#ardoise input[name=email]").val();
    var pwd = $("#ardoise input[name=mdp]").val();
    if(login.length != 0 && pwd.length != 0)
    {
	  $.ajax(
	  {
		  type: "POST",
		  url: "/epicerie/connexion",
		  data: {email: login, mdp: pwd},
		  success: function(msg)
		  {
		  if(msg != null)
			  $("#ardoise h3").html("Connexion : " + msg);
		  else if (window.location.pathname != "/epicerie/inscription")
			  window.location.reload();
		  else
			  window.location.pathname = "/epicerie";
		  }
	  });
    }
	else
	  $("#ardoise h3").html("Connexion : " + "Vous devez tout renseigner !");
}

function get_listes()
{
    $.getJSON('/epicerie/listes.json', function(data)
    {
	var items = [];
	if(data.length != 0)
	{
	    $.each(data, function(key, liste) {
		items.push('<li><a href="/epicerie/liste/' + liste['id_liste'] + '-' + liste['label'] + '">' + liste['label'] + '</a></li>');
	    });
	}
	items.push('<li><a class="yellow-button" href="/epicerie/listes/ajout"><span>Nouvelle</span></a></li>');
	$('#listes').html(items.join(''))
    });
}
function get_panier()
{
    $.getJSON('/epicerie/panier.json', function(data)
    {
	var items = [];
	
	if(!data['vide'])
	{
	    $.each(data, function(key, produit) {
		items.push('<li><a href="/epicerie/produit/' + produit['id_produit'] + '-' + produit['label'] + '">' + produit['label'] + '</a></li>');
	    });
	    $('#panier').html(items.join(''));
	    $('#panier').after('<a class="yellow-button" href="/epicerie/panier"><span>Voir</span></a>');
	}
	else
	    $('#panier').html('<li>Vide !</li>');
    });
}
function ajout_liste(event)
{
    event.preventDefault();
    var id_pdt = $("input[name=id_produit]").val();
    var id_lst = $("#id_liste option:selected").val();
    $.add2cart('image_produit', 'listes', function()
    {
	$.ajax(
	{
	    type: "POST",
	    url: "/epicerie/liste/ajout",
	    data: {add: "add", id_produit: id_pdt, id_liste: id_lst}
	}).done($('#image_produit_shadow').remove());
    });
}
function ajout_panier(event)
{
    event.preventDefault();
    var id = $("#id_produit").val();
    $.add2cart('image_produit', 'panier', function()
    {
	$.ajax(
	{
	    type: "POST",
	    url: "/epicerie/panier",
	    data: {add: "add", id_produit: id, quantite: '1'}
	}).done(get_panier);
    });
}
function retirer_panier(event)
{
    if(!confirm("Etes-vous certain de vouloir retirer les produits selectionés ?"))
	event.preventDefault();
}
function vider_panier(event)
{
    if(!confirm("Etes-vous certain de vouloir vider votre panier ?"))
	event.preventDefault();
}
function toogle_action_enlever()
{
    if($(':checked').length > 0)
	$('#enlever').removeAttr('disabled');
    else
	$('#enlever').attr('disabled', 'disabled');
	
}
function edit_it()
{
    $("li.submit").show();
    $("li input").show();
    $(this).next("input").focus();
    $("li p").hide();
}
function reequilibre()
{
    var leftcol_size = $('#leftcol').height();
    var rightcol_size = $('#rightcol').height();
    if(leftcol_size < rightcol_size)
	$('#leftcol .block-content').css('min-height', rightcol_size-99);
}