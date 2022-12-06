<?php
if($score != NULL){
	echo "<h1>Vous avez obtenue " . $score->scoreJou . "% de réussite</h1>";
	if($correction->MTC_correction == "D"){
		echo '<a href="' . base_url() . 'index.php/match/corriger/' . $codeMtc . '" class="btn btn-success" style="margin-top: 5%;">Voir la correction</button>';
	}
}else{
	echo "<br />";
	echo "Une erreur est survenue!";
}


?>