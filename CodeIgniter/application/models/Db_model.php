
<?php
/* ==============================
// Nom du fichier : Db_model.php
// Auteur: AFFIGLIATI Enzo
// Date de création:15 nov 2022
// Version: V2 
// ++
// Description:
// Fichier contenant les fonctions permetant 
// de faire le lien entre l'application et
// la base de données
------------------------------ */
class Db_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	//Renvoie les pseudos des responsables
	public function get_all_compte() {
		$query = $this->db->query("SELECT * FROM T_RESPONSABLE_RSP JOIN T_PROFIL_PRF USING(RSP_id);");
    	return $query->result_array();
    }

    //Renvoie le rôle d'un responsable
	public function get_role($username) {
		$query = $this->db->query("SELECT PRF_role FROM T_PROFIL_PRF JOIN T_RESPONSABLE_RSP USING(RSP_id) WHERE RSP_pseudo like '" . $username . "';");
		$result = $query->row();
    	return $result->PRF_role;
    }

    //Renvoie les données de la ligne de la table T_NEWS_NEW d'id $numero
	public function get_actualite($numero) {
		$query = $this->db->query("SELECT new_id, new_text FROM T_NEWS_NEW WHERE new_id = " . $numero . ";");
    	return $query->row();
	}

	//Renvoie 5 dernières actualité de la table T_NEWS_NEW
	public function get_all_actualite() {
		$query = $this->db->query("SELECT new_intitule, new_text, new_date, idPseudo(rsp_id) as auteur FROM T_NEWS_NEW ORDER BY NEW_date DESC LIMIT 5");
    	return $query->result_array();
	}
	//Renvoie le nombre de comptes utilisateur présents dans la table T_RESPONSABLE_RSP
	public function count_responsable(){
		$query = $this->db->query("SELECT count(rsp_id) as nbResponsable FROM T_RESPONSABLE_RSP;");
		return $query->row();
	}

	//Renvoie toutes les questions et réponse d'un quiz à partir du code du match passé en paramètre
	public function get_all_que_rep($matchCode){
		$query = $this->db->query("SELECT QUI_intitule, MTC_code, QUE_text,QUE_id,RES_text,RES_validite,RES_id FROM T_MATCH_MTC JOIN T_QUIZ_QUI USING(QUI_id) JOIN T_QUESTION_QUE USING(QUI_id) JOIN T_REPONSE_RES USING(QUE_id) WHERE MTC_code = '" . $matchCode . "' ORDER BY QUE_ordre;");
		return $query->result_array();
	}

	//Ajout d'un joueur à un match
	public function insert_new_player($matchCode,$pseudoJou){
		$query = $this->db->query("SELECT JOU_pseudo FROM T_JOUEUR_JOU WHERE JOU_pseudo = '" . $pseudoJou . "' AND MTC_code = '" . $matchCode . "';");
		//Test si il y a un joueur avec un pseudo identique participant au même match
		//Si vrai -> on renvoie null
		//Si faux -> on insert dans la table T_JOUEUR_JOU un nouveau joueur
		if($query->result_array() != null){
			return FALSE;
		}else{
			$query = $this->db->query("INSERT INTO T_JOUEUR_JOU(JOU_pseudo,JOU_score,MTC_code)VALUES('" . $pseudoJou . "', 0, '" . $matchCode . "');");		}
		return TRUE;
		
	}

	//Test si il y a au moins un match
	//Si vrai -> Renvoie TRUE
	//Si faux -> Renvoie FALSE
	public function get_match_in_bdd(){
		$query = $this->db->query("SELECT MTC_code FROM T_MATCH_MTC LIMIT 1;");
		if($query->result_array() != null){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//Test si le code est associé à un match
	//Si vrai -> Renvoie TRUE
	//Si faux -> Renvoie FALSE
	public function get_match_exist($codeMtc){
		$query = $this->db->query("SELECT MTC_code FROM T_MATCH_MTC WHERE MTC_code like '" . $codeMtc . "';");
		if($query->result_array() != null){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//Test si le quiz associé est actif
	//Si vrai -> Renvoie TRUE
	//Si faux -> Renvoie FALSE
	public function get_quiz_actif($codeMtc){
		$query = $this->db->query("SELECT MTC_code FROM T_MATCH_MTC JOIN T_QUIZ_QUI USING(QUI_id) WHERE MTC_code = '" . $codeMtc . "' AND QUI_etat = 'A';");
		if($query->result_array() != null){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//Test si le match est actif ou démarré
	//Si vrai -> Renvoie TRUE
	//Si faux -> Renvoie FALSE
	public function get_match_availability($codeMtc){
		$query = $this->db->query("SELECT MTC_code FROM T_MATCH_MTC WHERE MTC_code = '" . $codeMtc . "' AND MTC_dateFin is null AND MTC_dateDebut <= NOW() AND MTC_etat = 'A';");
		if($query->result_array() != null){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//Test si le match n'est pas terminé
	//Si vrai -> Renvoie TRUE
	//Si faux -> Renvoie FALSE
	public function test_match_date($codeMtc){
		$query = $this->db->query("SELECT MTC_code FROM T_MATCH_MTC WHERE MTC_code = '" . $codeMtc . "' AND MTC_dateFin is null");
		if($query->row() != null){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//Insert dans la table T_RESPONSABLE_RSP d'un nouveau responsable
	public function set_compte(){
    	$this->load->helper('url');
		$id=$this->input->post('id');
		$mdp=$this->input->post('mdp');
		$req="INSERT INTO T_RESPONSABLE_RSP(RSP_pseudo,RSP_mdp) VALUES ('".$id."','".$mdp."');";
		$query = $this->db->query($req);
      	return ($query);
	}

	//Test si le pseudo et le mot de passe passé en paramètre correspond à un compte
	//Si vrai -> Renvoie TRUE
	//Si faux -> Renvoie False
	public function connect_compte($username, $password){
		$query = $this->db->query("SELECT RSP_pseudo, RSP_mdp FROM T_RESPONSABLE_RSP WHERE RSP_pseudo = '" . $username . "' AND RSP_mdp = hashMdp('" . $password . "');");

		if($query->num_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//Modifie le mot de passe du responsable connecté
	//Si le mot de passe est modifié -> Renvoie TRUE
	//Si le mot de passe n'a pas été modifié -> Renvoie FALSE
	public function modPassword($newPass,$confirmPass){
		if(strcmp($newPass, $confirmPass) == 0){
			$this->db->query("UPDATE T_RESPONSABLE_RSP SET RSP_mdp = hashMdp('" . $newPass . "') WHERE RSP_pseudo like '" . $_SESSION['username'] . "';");
			//Test si le mot de passe dans la base correspont au nouveau mot de passe
			//Si vrai -> Renvoie TRUE
			//Si faux -> Renvoie FALSE
			$query = $this->db->query("SELECT RSP_id FROM T_RESPONSABLE_RSP WHERE RSP_mdp like hashMdp('" . $newPass . "');");
			if($query->row() != null){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	//Renvoie les matchs associés au formateur connecté
	public function get_match_formateur(){
		$query = $this->db->query("SELECT MTC_code, MTC_etat, MTC_dateDebut, MTC_dateFin, MTC_correction, QuizIdQuizNom(QUI_id) as nomQuiz FROM T_MATCH_MTC JOIN T_RESPONSABLE_RSP USING(RSP_id) JOIN T_QUIZ_QUI USING(QUI_id) WHERE RSP_pseudo LIKE '" . $_SESSION['username'] . "';");
		return $query->result_array();
	}

	//Mets à jour la date de fin du match et renvoie le score final d'un match
	public function endMatch($codeMtc){
		$this->db->query("UPDATE T_MATCH_MTC SET MTC_dateFin = NOW() WHERE MTC_code like '" . $codeMtc . "';");
		$query = $this->db->query("SELECT CAST(AVG(JOU_score)*10 AS INT) as scoreFinal FROM T_JOUEUR_JOU WHERE MTC_code like '" . $codeMtc . "';");
		return $query->row();
	}

	//Renvoie les joueurs et leur score pour un match donné
	public function getPlayerScore($codeMtc){
		$query = $this->db->query("SELECT JOU_pseudo, JOU_score FROM T_JOUEUR_JOU WHERE MTC_code like '" . $codeMtc . "' ORDER BY JOU_score DESC ;");
		return $query->result_array();
	}

	//Renvoie le nombre de joueurs ayant participé à un match
	public function getNbPlayer($codeMtc){
		$query = $this->db->query("SELECT count(JOU_id) as nbJou FROM T_JOUEUR_JOU WHERE MTC_code like '" . $codeMtc . "';");
		return $query->row();
	}

	//Renvoie les informations personnelles associé au responsable connecté
	public function getInfoPerso(){
		$query = $this->db->query("SELECT PRF_nom, PRF_prenom FROM T_PROFIL_PRF JOIN T_RESPONSABLE_RSP USING(RSP_id) WHERE RSP_pseudo LIKE '" . $_SESSION['username'] . "';");
		return $query->row();
	}

	//Renvoie les informations des quiz actif et les informations de leur matchs associés
	public function getQuizMatch(){
		$query = $this->db->query("SELECT QUI_id, QUI_intitule, QUI_etat, idPseudo(T_QUIZ_QUI.RSP_id) as auteurQuiz, MTC_code, MTC_etat, MTC_dateDebut, MTC_dateFin, MTC_correction, idPseudo(T_MATCH_MTC.RSP_id) as auteurMatch FROM T_QUIZ_QUI LEFT JOIN T_MATCH_MTC USING(QUI_id) WHERE QUI_etat = 'A';");
		return $query->result_array();
	}

	//Renvoie les informations des quiz
	public function getAllQuiz(){
		$query = $this->db->query("SELECT QUI_id, QUI_intitule, QUI_etat, idPseudo(RSP_id) as auteurQuiz FROM T_QUIZ_QUI");
		return $query->result_array();
	}

	//Test si le quiz passé en paramètre est vide
	//Si vrai -> renvoie TRUE
	//Si faux -> renvoie FALSE
	public function testQuizVide($idQuiz){
		$query = $this->db->query("SELECT DISTINCT QUI_id, QUI_intitule, QUI_etat, idPseudo(RSP_id) as auteurQuiz FROM T_QUIZ_QUI WHERE QUI_id = " . $idQuiz . " AND QUI_id not in (SELECT DISTINCT QUI_id FROM T_QUIZ_QUI JOIN T_QUESTION_QUE USING(QUI_id));");
		 if($query->row() == NULL){
		 	return FALSE;
		 }else{
		 	return TRUE;
		 }
	}

	//Trigger le déclencheur de remise à zéro d'un match
	public function resetMatch($codeMtc){
		$query = $this->db->query("UPDATE T_MATCH_MTC SET MTC_dateDebut = NOW() + INTERVAL 1 MINUTE, MTC_dateFin = NULL WHERE MTC_code LIKE '" . $codeMtc . "';");
	}

	//Inverse l'état d'un match
	public function reverseEtatMatch($codeMtc){
		$etat = $this->db->query("SELECT MTC_etat FROM T_MATCH_MTC WHERE MTC_code LIKE '" . $codeMtc . "';");
		$etat = $etat->row();
		if($etat->MTC_etat == "A"){
			$etat = "D";
		}else{
			$etat = "A";
		}
		$query = $this->db->query("UPDATE T_MATCH_MTC SET MTC_etat = '" . $etat . "' WHERE MTC_code LIKE '" . $codeMtc . "';");
	}

	//Renvoie les donnée d'un quiz
	public function getQuiz($quiz){
		$query = $this->db->query("SELECT QUI_id, QUI_intitule, QUI_etat, idPseudo(RSP_id) as auteurQuiz FROM T_QUIZ_QUI WHERE QUI_id = " . $quiz . ";");
		return $query->row();
	}

	//Génère un code de match à partir de l'id d'un quiz
	//Si le code généré existe déja on renvoie null
	public function create_MtcCode($quiz){
		$codeMtc = $this->db->query("SET @codeMtc = '';");
		$codeMtc = $this->db->query("CALL codeMtc(" . $quiz . ",@codeMtc);");
		$codeMtc = $this->db->query("SELECT @codeMtc as codeMtc;");
		$codeMtc = $codeMtc->row();
		if($codeMtc->codeMtc == "Erreur"){
			return NULL;
		}else{
			return $codeMtc;
		}
	}

	//Insertion d'un match
	//Si réussi -> retourne le code du match
	//Sinon -> retourne NULL
	public function insert_new_match($quiz,$mtcCode,$mtcDateDebut,$mtcEtat,$mtcCorrection){
		$test = $this->db->query("SELECT MTC_code FROM T_MATCH_MTC WHERE MTC_code LIKE '" . $mtcCode . "';");
		$test = $test->row();
		//Test si le code du match n'est pas déja dans la table
		//Si vrai -> insert du match
		//Si faux -> renvoie d'une erreur
		if($test != NULL){
			return NULL;
		}else{
			$query = $this->db->query("INSERT INTO T_MATCH_MTC VALUES('" . $mtcCode . "','" . $mtcEtat . "','" . $mtcDateDebut . "',NULL,'" . $mtcCorrection . "'," . $quiz . ",pseudoId('" . $_SESSION['username'] . "'));");
			$result = $this->db->query("SELECT MTC_code FROM T_MATCH_MTC WHERE MTC_code LIKE '" . $mtcCode . "';");
			return $result->row();
		}
	}

	//Supprime un match et ses joueurs
	//Si réussi -> retourne TRUE
	//Sinon -> retourne FALSE
	public function delete_match($mtcCode){
		$query = $this->db->query("DELETE FROM T_JOUEUR_JOU WHERE MTC_code like '" . $mtcCode . "';");
		$query = $this->db->query("DELETE FROM T_MATCH_MTC WHERE MTC_code LIKE '" . $mtcCode . "';");
		$query = $this->db->query("SELECT MTC_code FROM T_MATCH_MTC WHERE MTC_code LIKE '" . $mtcCode . "';");
		if($query->row() == NULL){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//Incrémente de 1 le score du joueur si la réponse est valide
	public function test_answer($idQue,$idRep,$codeMtc,$pseudoJou){
		$query = $this->db->query("SELECT QUE_id FROM T_QUESTION_QUE JOIN T_REPONSE_RES USING(QUE_id) WHERE QUE_id = " . $idQue . " AND RES_id = " . $idRep . " AND RES_validite = 'V';");
		$query = $query->row();
		if($query != NULL){
			$lastScore = $this->db->query("SELECT JOU_score FROM T_JOUEUR_JOU WHERE JOU_pseudo LIKE '" . $pseudoJou . "' AND MTC_code like '" . $codeMtc . "' ");
			$lastScore = $lastScore->row();
			$score = $lastScore->JOU_score + 1;

			$this->db->query("UPDATE T_JOUEUR_JOU SET JOU_score = " . $score . " WHERE JOU_pseudo LIKE '" . $pseudoJou . "' AND MTC_code like '" . $codeMtc . "';");
		}
	}

	//Renvoie l'état de la correction d'un match
	public function get_correction_etat($mtcCode){
		$query = $this->db->query("SELECT MTC_correction FROM T_MATCH_MTC WHERE MTC_code LIKE '" . $mtcCode . "';");
		return $query->row();
	}

	//Renvoie le pourcentage de réussite d'un joueur à un match
	public function get_score_player($pseudoJou,$codeMtc){
		$query = $this->db->query("SELECT CAST((JOU_score/COUNT(QUE_id))*100 AS INT) as scoreJou FROM T_JOUEUR_JOU JOIN T_MATCH_MTC USING(MTC_code) JOIN T_QUESTION_QUE USING(QUI_id) WHERE MTC_code like '" . $codeMtc . "' AND JOU_pseudo like '" . $pseudoJou . "';");
		return $query->row();
	}

	//Test si un match est actif
	//Si vrai -> renvoie TRUE
	//Si faux -> renvoie FALSE
	public function get_etat_match($mtcCode){
		$query = $this->db->query("SELECT MTC_code FROM T_MATCH_MTC WHERE MTC_etat LIKE 'A' AND MTC_code like '" . $mtcCode . "';");
		if($query->row() != NULL){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>