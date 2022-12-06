<?php
if($correction != NULL){
	echo "<h1>" . $correction[0]['QUI_intitule'] . " - " . $correction[0]['MTC_code'] . "</h1>";
	echo "<ul>";
	foreach($correction as $duple){
		if(!isset($traite[$duple["QUE_text"]])){
			echo "<li>";
			echo $duple["QUE_text"];
			echo "<ul>";

			$repText = $duple["QUE_text"];

			foreach($correction as $duple2){
				if(strcmp($repText, $duple2["QUE_text"]) == 0){
					if($duple2["RES_validite"] == "V"){
						$color = "green";
					}else{
						$color = "black";
					}
					echo "<li style='color : " . $color . ";'>";
					echo $duple2["RES_text"];
					echo "</li>";
				}
			}
			echo "</ul></li>";
			$traite[$duple["QUE_text"]] = 1;
		}
	}
	echo "</ul>";
}else{
	echo "<br />";
	echo "Aucun résultat";
}


?>