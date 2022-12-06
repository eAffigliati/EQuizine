<?php
echo validation_errors(); 
if(!isset($erreur)){
	$erreur = '';
}?>
<?php echo form_open('compte/connecter'); ?> 
	<label><?php echo $erreur ?></label><br>
	<label>Saisissez vos identifiants ici :</label><br> 
	<input type="text" name="pseudo" />
	<input type="password" name="mdp" />
	<input type="submit" value="Connexion"/>
</form>