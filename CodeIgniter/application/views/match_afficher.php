<?php
if($match != NULL){
    echo '<form action="'. base_url() . 'index.php/match/terminer/' . $codeMtc . '/' . $pseudoJou . '">';
	echo "<h1>" . $match[0]['QUI_intitule'] . " - " . $match[0]['MTC_code'] . "</h1>";
	foreach($match as $duple){
		if(!isset($traite[$duple["QUE_text"]])){
			echo'
					<legend>' . $duple["QUE_text"] . '</legend>';

			$repText = $duple["QUE_text"];

			foreach($match as $duple2){
				if(strcmp($repText, $duple2["QUE_text"]) == 0){
					echo'<div>
      						<input type="radio" id="' . $duple2["RES_id"] . '" name="' . $duple2["QUE_id"] . '" value="' . $duple2["RES_id"] . '">
      						<label for="' . $duple2["RES_id"] . '">' . $duple2["RES_text"] . '</label>
    					</div>';
				}
			}
			$traite[$duple["QUE_text"]] = 1;

		}
	}
    echo '<button type="submit" class="btn btn-success" style="margin-top: 5%;">Envoyer mes réponses</button>';
}else{
	echo "<br />";
	echo "Aucun résultat";
}


?>