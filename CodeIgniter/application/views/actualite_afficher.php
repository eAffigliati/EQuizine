<h1><?php echo $titre;?></h1>
<br />
<?php

if(isset($actu)){
	echo $actu->new_id;
	echo(" -- ");
	echo $actu->new_text;
}else{
	echo "pas d'actualité !";
}

?>