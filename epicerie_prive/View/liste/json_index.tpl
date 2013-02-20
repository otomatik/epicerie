<?php
if(!empty($listes['persos'])) :
    echo "[";
    foreach($listes['persos'] as $i => $liste) :
	echo '{';
	echo '"id_liste" : "' . $liste['id_liste'];
	echo '", "label" : "' . utf8_encode($liste['label']);
	echo '"}';
	if($i < count($listes['persos'])-1) echo ',';
    endforeach;
    echo "]";
else :
    echo "[]";
endif;