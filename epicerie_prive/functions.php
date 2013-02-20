<?php
function menu($items)
{
    foreach($items as $droit => $pages)
    {
	switch($droit)
	{
	    case 'admin' : if(is_admin()) lien_menu($pages);
		break;
	    case 'client' : if(is_client()) lien_menu($pages);
		break;
	    case 'membre' : if(is_client() || is_admin()) lien_menu($pages);
		break;
	    case 'non-membre' : if(!is_client() && !is_admin())
		lien_menu($pages);
		break;
	    case 'tous' :
		lien_menu($pages);
	}
    }
}

function lien_menu($pages)
{
    foreach($pages as $url => $titre)
    {
	echo '<li><a href="';
	url($url);
	echo '">' . $titre . '</a></li>';
    }
}

function html($string)
{
    return utf8_encode(htmlspecialchars($string, ENT_QUOTES));
}

function champ($s, $method = "POST")
{
    if($method == "POST")
        return (isset($_POST["$s"])) ? htmlspecialchars($_POST["$s"]) : "";
    else
	return (isset($_GET["$s"])) ? htmlspecialchars($_GET["$s"]) : "";
}

function url($path)
{
    $string = str_replace(' ', '-', strtolower($path));
    echo $_SERVER['HTTP_ROOT'] . utf8_encode($string);
}

function is_client()
{
    return isset($_SESSION['membre']) && $_SESSION['membre']['type'] == "client";
}

function is_admin()
{
    return isset($_SESSION['membre']) && $_SESSION['membre']['type'] == "admin";
}

/**
 * Comment déduire le nom du fichier à inclure à partir du nom de la classe ?
 * Exemple :
 *    - classe convoquée      : "Controller_Truc.php", "Model_Machin.php", etc.
 *    - fichier correspondant : "Controller/Truc.php", "Model/Machin.php", etc.
 * 
 * Note : cette fonction est appellée automatiquement
 * cf. instruction : "spl_autoload_register('generic_autoload');"
 * dans "index.php" (ligne 5).
 */
function generic_autoload($class)
{
    require_once str_replace('_', '/', $class . '.php');
}