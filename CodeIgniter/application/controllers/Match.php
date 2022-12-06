<?php
/* ==============================
// Nom du fichier : Match.php
// Auteur: AFFIGLIATI Enzo
// Date de création: 15 nov 2022
// Version: V1.0
// ++
// Description:
// Controlle l'affichage des questions et informations d'un match
// ------------------------------
// A noter:
// Il est possible d'accéder à la page d'un match de deux manières
// Solution 1 -> Le code du match a été passé en paramètres de l'url sans passé par le formulaire
// Solution 2 -> Le code du match et le pseudo ont été passés en paramètres de l'url 
//==*/

/* Dans le model */
/* ------------------------------
-- Gestion CRUD des Actualités --
------------------------------ */
defined('BASEPATH') OR exit('No direct script access allowed');

class Match extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('db_model');
		$this->load->helper('url_helper');
	}

	public function afficher($matchCode = FALSE){
		if ($matchCode == FALSE){
			$url = base_url();
			header("Location:$url");
		}else{
			
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['match'] = $this->db_model->get_all_que_rep($matchCode);

			//Test si le pseudo du joueur n'a pas été passé en paramètre
			//Si vrai -> On affiche directement la page du match
			//Si faux -> On test si le pseudo n'est pas déja associé au match
			if(!isset($_GET['pseudoJou'])){
				$data['titre'] = 'Liste des actualitées :';
				$data['actu'] = $this->db_model->get_all_actualite();
				$data['matchExist'] = $this->db_model->get_match_in_bdd();
				$data['erreur'] = '';
				$data['mtcCode'] = $matchCode;
	
				$this->load->view('templates/haut');
				$this->load->view('menu_visiteur');
				$this->load->view('page_accueil',$data);
				$this->load->view('templates/bas');
			}else{
				//Test si le champs du pseudo est vide
				//Si vrai ->On redirige le visiteur vers la page page_accueil pour saisir un nouveau pseudo avec un message d'erreur
				//Si faux -> Test si le pseudo du joueur est bien formé
				if($_GET['pseudoJou'] == NULL){
					$data['titre'] = 'Liste des actualitées :';
					$data['actu'] = $this->db_model->get_all_actualite();
					$data['matchExist'] = $this->db_model->get_match_in_bdd();
					$data['erreur'] = 'Veuillez saisir un pseudo !';
					$data['mtcCode'] = $matchCode;
	
					$this->load->view('templates/haut');
					$this->load->view('menu_visiteur');
					$this->load->view('page_accueil',$data);
					$this->load->view('templates/bas');
				}
				//Test si le pseudo du joueur est bien formé
				//Si vrai -> Test si il y a un joueur avec un pseudo identique participant au même match
				//Si faux -> On redirige le visiteur vers la page page_accueil pour saisir un nouveau pseudo avec un message d'erreur
				if(preg_match("/^[a-zA-Z0-9]+$/", $_GET['pseudoJou'])){
	
					//Test si il y a un joueur avec un pseudo identique participant au même match
					//Si vrai -> On redirige le visiteur vers la page page_accueil pour saisir un nouveau pseudo avec un message d'erreur
					//Si faux -> on insert dans la table T_JOUEUR_JOU un nouveau joueur et on affiche la page match_afficher avec le quiz correspondant
					if($this->db_model->insert_new_player($matchCode,$_GET['pseudoJou']) == FALSE){

						$data['titre'] = 'Liste des actualitées :';
						$data['actu'] = $this->db_model->get_all_actualite();
						$data['matchExist'] = $this->db_model->get_match_in_bdd();
						$data['erreur'] = 'Pseudo déjà utilisé !';
						$data['mtcCode'] = $matchCode;
	
						$this->load->view('templates/haut');
						$this->load->view('menu_visiteur');
						$this->load->view('page_accueil',$data);
						$this->load->view('templates/bas');
					}else{

						$data['codeMtc'] = $matchCode;
						$data['pseudoJou'] = $_GET['pseudoJou'];
						//Affichage du match
						$this->load->view('templates/haut');
						$this->load->view('menu_visiteur');
						$this->load->view('match_afficher',$data);
						$this->load->view('templates/bas');
					}

					
				}else{
					
					$data['titre'] = 'Liste des actualitées :';
					$data['actu'] = $this->db_model->get_all_actualite();
					$data['matchExist'] = $this->db_model->get_match_in_bdd();
					$data['erreur'] = 'Le pseudo contient des caractères non autorisés';
					$data['mtcCode'] = $matchCode;
	
					$this->load->view('templates/haut');
					$this->load->view('menu_visiteur');
					$this->load->view('page_accueil',$data);
					$this->load->view('templates/bas');
					
				}
			}
		}
	}

	public function lister(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		if(!isset($_SESSION['username'])){
			$data['erreur'] = "Vous n'avez pas accès à cet espace!";
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur'); 
			$this->load->view('compte_connecter',$data); 
			$this->load->view('templates/bas');
		}else{
			if($_SESSION['role'] == "A"){
				$data['result'] = "Vous n'avez pas accès à cet espace!";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_administrateur'); 
				$this->load->view('compte_menu',$data); 
				$this->load->view('templates/bas');
			}else{
				$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_formateur');
				$this->load->view('rubrique_match',$data); 
				$this->load->view('templates/bas');
			}
		}
	}

	public function afficherFormateur($codeMtc = FALSE){
		if ($codeMtc == FALSE){
			$url = base_url();
			header("Location:$url" . "index.php/match/lister");
		}
		if(!isset($_SESSION['username'])){
			$data['erreur'] = "Vous n'avez pas accès à cet espace!";
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur'); 
			$this->load->view('compte_connecter',$data); 
			$this->load->view('templates/bas');
		}else{
			if($_SESSION['role'] == "A"){
				$data['result'] = "Vous n'avez pas accès à cet espace!";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_administrateur'); 
				$this->load->view('compte_menu',$data); 
				$this->load->view('templates/bas');
			}else{
				$data['match'] = $this->db_model->get_all_que_rep($codeMtc);
				if($this->db_model->test_match_date($codeMtc) == FALSE){
					$data["scoreFinal"] = $this->db_model->endMatch($codeMtc);
					$data["nombreJoueur"] = $this->db_model->getNbPlayer($codeMtc);
				}
				//Affichage du match
				$this->load->view('templates/hautBack');
				$this->load->view('menu_formateur');
				$this->load->view('match_afficher_formateur',$data);
				$this->load->view('templates/bas');
			
			}
		}
	}

	public function afficherScore($codeMtc = FALSE){
		if ($codeMtc == FALSE){
			$url = base_url();
			header("Location:$url" . "index.php/match/lister");
		}
		
		if(!isset($_SESSION['username'])){
			$data['erreur'] = "Vous n'avez pas accès à cet espace!";
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur'); 
			$this->load->view('compte_connecter',$data); 
			$this->load->view('templates/bas');
		}else{
			if($_SESSION['role'] == "A"){
				$data['result'] = "Vous n'avez pas accès à cet espace!";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_administrateur'); 
				$this->load->view('compte_menu',$data); 
				$this->load->view('templates/bas');
			}else{
				$data["scoreFinal"] = $this->db_model->endMatch($codeMtc);
				$data["scoreJoueur"] = $this->db_model->getPlayerScore($codeMtc);
				$data["nombreJoueur"] = $this->db_model->getNbPlayer($codeMtc);
				$data["infoMatch"] = $this->db_model->get_all_que_rep($codeMtc);
				$this->load->view('templates/hautBack');
				$this->load->view('menu_formateur');
				$this->load->view('match_afficher_final',$data);
				$this->load->view('templates/bas');
			}
		}
	}

	public function reset($codeMtc = FALSE){
		if(!isset($_SESSION['username'])){
			$data['erreur'] = "Vous n'avez pas accès à cet espace!";
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur'); 
			$this->load->view('compte_connecter',$data); 
			$this->load->view('templates/bas');
		}else{
			if($_SESSION['role'] == "A"){
				$data['result'] = "Vous n'avez pas accès à cet espace!";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_administrateur'); 
				$this->load->view('compte_menu',$data); 
				$this->load->view('templates/bas');
			}else{
				if($codeMtc == FALSE){
					$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
					$data['result'] = "La remise à zéro de ce match n'est pas disponible !";
					$data['resultType'] = "primary";
					$this->load->view('templates/hautBack'); 
					$this->load->view('menu_formateur');
					$this->load->view('rubrique_match',$data); 
					$this->load->view('templates/bas');
				}else{
					$this->db_model->resetMatch($codeMtc);
					$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
					$data['result'] = "Le match a été remis à zéro avec succès !";
					$data['resultType'] = "success";
					$this->load->view('templates/hautBack'); 
					$this->load->view('menu_formateur');
					$this->load->view('rubrique_match',$data); 
					$this->load->view('templates/bas');
				}
			}
		}
	}

	public function resetEtat($codeMtc = FALSE){
		if(!isset($_SESSION['username'])){
			$data['erreur'] = "Vous n'avez pas accès à cet espace!";
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur'); 
			$this->load->view('compte_connecter',$data); 
			$this->load->view('templates/bas');
		}else{
			if($_SESSION['role'] == "A"){
				$data['result'] = "Vous n'avez pas accès à cet espace!";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_administrateur'); 
				$this->load->view('compte_menu',$data); 
				$this->load->view('templates/bas');
			}else{
				if($codeMtc == FALSE){
					$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
					$data['result'] = "Le changement d'état de ce match n'est pas disponible !";
					$data['resultType'] = "primary";
					$this->load->view('templates/hautBack'); 
					$this->load->view('menu_formateur');
					$this->load->view('rubrique_match',$data); 
					$this->load->view('templates/bas');
				}else{
					$this->db_model->reverseEtatMatch($codeMtc);
					$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
					$data['result'] = "L'état a été changé avec succès!";
					$data['resultType'] = "success";
					$this->load->view('templates/hautBack'); 
					$this->load->view('menu_formateur');
					$this->load->view('rubrique_match',$data); 
					$this->load->view('templates/bas');
				}
			}
		}
	}

	public function creer($quizId = FALSE,$mtcCode = FALSE){
		if(!isset($_SESSION['username'])){
			$data['erreur'] = "Vous n'avez pas accès à cet espace!";
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur'); 
			$this->load->view('compte_connecter',$data); 
			$this->load->view('templates/bas');
		}else{
			if($_SESSION['role'] == "A"){
				$data['result'] = "Vous n'avez pas accès à cet espace!";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_administrateur'); 
				$this->load->view('compte_menu',$data); 
				$this->load->view('templates/bas');
			}else{
				$this->load->helper('form');
				$this->load->library('form_validation');
				if($mtcCode == FALSE){
					if($quizId != FALSE){
						//Test si le quiz passé en paramètre existe
						//Si vrai -> On génère un code de match et on test si il a été correctement généré
						//Si faux -> On réaffiche la page des match avec un message d'erreur
						$quizData = $this->db_model->getQuiz($quizId);
						if($quizData != NULL){
							//Test si le quiz passé en paramètre est vide
							//Si vide -> renvoie TRUE
							//Sinon -> renvoie FALSE
							$quizTest = $this->db_model->testQuizVide($quizId);
							if($quizTest == FALSE){
								$codeMtc = $this->db_model->create_MtcCode($quizId);
								//Test si le code a été généré
								//Si vrai -> On affiche un formulaire pour paramétrer les données du match
								//Si faux -> On affiche la page des match avec un message d'erreur
								if($codeMtc != NULL){
									$data["codeMtc"] = $codeMtc->codeMtc;
									$data["quizData"] = $quizData;
									$this->load->view('templates/hautBack'); 
									$this->load->view('menu_formateur');
									$this->load->view('rubrique_create_match',$data); 
									$this->load->view('templates/bas');
								}else{
									$data['result'] = "Echec de génération d'un code de match, veuillez réessayer !";
									$data['resultType'] = "primary";
									$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
									$this->load->view('templates/hautBack'); 
									$this->load->view('menu_formateur');
									$this->load->view('rubrique_match',$data); 
									$this->load->view('templates/bas');
								}
							}else{
								$data['result'] = "Echec de création d'un match! Le quiz sélectionné est vide, veuillez réessayer !";
								$data['resultType'] = "primary";
								$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
								$this->load->view('templates/hautBack'); 
								$this->load->view('menu_formateur');
								$this->load->view('rubrique_match',$data); 
								$this->load->view('templates/bas');
							}
						}else{
							$data['result'] = "Echec de génération d'un match, le quiz n'existe pas !";
							$data['resultType'] = "primary";
							$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
							$this->load->view('templates/hautBack'); 
							$this->load->view('menu_formateur');
							$this->load->view('rubrique_match',$data); 
							$this->load->view('templates/bas');
						}
					}else{
						$data["listQuiz"] = $this->db_model->getAllQuiz();
						$this->load->view('templates/hautBack'); 
						$this->load->view('menu_formateur');
						$this->load->view('rubrique_create_match_quiz',$data); 
						$this->load->view('templates/bas');
					}
				}else{
					$mtcDateDebut = $_GET['dateDebut'];
					$mtcEtat = $_GET['etatMtc'];
					$mtcCorrection = $_GET['correctionMtc'];
					//Test si il n'y a pas eu d'erreur de formulaire
					//Si vrai insertion du nouveau match et redirection vers la rubrique des matchs
					//Si faux redirection vers la rubrique des matchs avec un message d'erreur
					if($mtcDateDebut != NULL && $mtcEtat != NULL && $mtcCorrection != NULL){
						$result = $this->db_model->insert_new_match($quizId,$mtcCode,$mtcDateDebut,$mtcEtat,$mtcCorrection);
						//Test si l'insertion a été effectué
						//Si vrai -> Redirection vers la rubrique des matchs
						//Si faux redirection vers la rubrique des matchs avec un message d'erreur
						if($result != NULL){
							$data['result'] = "Match créé avec succès !";
							$data['resultType'] = "success";
							$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
							$this->load->view('templates/hautBack'); 
							$this->load->view('menu_formateur');
							$this->load->view('rubrique_match',$data); 
							$this->load->view('templates/bas');
						}else{
							$data['result'] = "Echec de la création du match !";
							$data['resultType'] = "primary";
							$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
							$this->load->view('templates/hautBack'); 
							$this->load->view('menu_formateur');
							$this->load->view('rubrique_match',$data); 
							$this->load->view('templates/bas');
						}
					}else{
						$data['result'] = "Echec de la création du match, formulaire défectueux !";
						$data['resultType'] = "primary";
						$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
						$this->load->view('templates/hautBack'); 
						$this->load->view('menu_formateur');
						$this->load->view('rubrique_match',$data); 
						$this->load->view('templates/bas');
					}
				}
			}
		}
	}

	public function supprimer($mtcCode = FALSE){
		if(!isset($_SESSION['username'])){
			$data['erreur'] = "Vous n'avez pas accès à cet espace!";
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur'); 
			$this->load->view('compte_connecter',$data); 
			$this->load->view('templates/bas');
		}else{
			if($_SESSION['role'] == "A"){
				$data['result'] = "Vous n'avez pas accès à cet espace!";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_administrateur'); 
				$this->load->view('compte_menu',$data); 
				$this->load->view('templates/bas');
			}else{
				if($mtcCode == FALSE){
					$data['result'] = "Echec de la suppression du match !";
					$data['resultType'] = "primary";
					$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
					$this->load->view('templates/hautBack'); 
					$this->load->view('menu_formateur');
					$this->load->view('rubrique_match',$data); 
					$this->load->view('templates/bas');
				}else{
					//Supprime et test si le match a été supprimé
					//Si vrai -> redirection vers la rubrique des matchs
					//Si faux -> redirection vers la rubrique des matchs et affichage d'un message d'erreur
					if($this->db_model->delete_match($mtcCode) == TRUE){
						$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
						$this->load->view('templates/hautBack'); 
						$this->load->view('menu_formateur');
						$this->load->view('rubrique_match',$data); 
						$this->load->view('templates/bas');
					}else{
						$data['result'] = "Echec de la suppression du match !";
						$data['resultType'] = "primary";
						$data['listMatchQuiz'] = $this->db_model->getQuizMatch();
						$this->load->view('templates/hautBack'); 
						$this->load->view('menu_formateur');
						$this->load->view('rubrique_match',$data); 
						$this->load->view('templates/bas');
					}
				}
			}
		}
	}

	public function terminer($mtcCode = FALSE,$pseudoJou = FALSE){
		$this->load->helper('form');
		$this->load->library('form_validation');
		if($mtcCode == FALSE){
			$data['titre'] = 'Liste des actualitées :';
			$data['actu'] = $this->db_model->get_all_actualite();
			$data['matchExist'] = $this->db_model->get_match_in_bdd();
			$data['erreur'] = 'Le match n\'existe pas!';

			$this->load->view('templates/haut');
			$this->load->view('menu_visiteur');
			$this->load->view('page_accueil', $data);
			$this->load->view('templates/bas');
		}else{
			if($pseudoJou == FALSE){
				$data['titre'] = 'Liste des actualitées :';
				$data['actu'] = $this->db_model->get_all_actualite();
				$data['matchExist'] = $this->db_model->get_match_in_bdd();
				$data['erreur'] = 'Pour participer à un match il vous faut un pseudo, veuillez réessayer!';

				$this->load->view('templates/haut');
				$this->load->view('menu_visiteur');
				$this->load->view('page_accueil', $data);
				$this->load->view('templates/bas');
			}else{
				//Test si un match est toujours actif
				//Si vrai -> MaJ du score du joueur
				//Si faux -> redirection vers la page d'accueil et affichage d'un message d'erreur
				if($this->db_model->get_etat_match($mtcCode) == TRUE){
					$match = $this->db_model->get_all_que_rep($mtcCode);
					foreach($match as $duple){
						if(!isset($traite[$duple["QUE_text"]])){
							if(isset($_GET[$duple["QUE_id"]])){
								$this->db_model->test_answer($duple["QUE_id"],$_GET[$duple["QUE_id"]],$match[0]['MTC_code'],$pseudoJou);
							}
							$traite[$duple["QUE_text"]] = 1;
					}
					}
					$data["score"] = $this->db_model->get_score_player($pseudoJou,$mtcCode);
					$data["correction"] = $this->db_model->get_correction_etat($mtcCode);
					$data["codeMtc"] = $mtcCode;
	
					$this->load->view('templates/haut');
					$this->load->view('menu_visiteur');
					$this->load->view('match_afficher_fin',$data);
					$this->load->view('templates/bas');
				}else{
					$data['titre'] = 'Liste des actualitées :';
					$data['actu'] = $this->db_model->get_all_actualite();
					$data['matchExist'] = $this->db_model->get_match_in_bdd();
					$data['erreur'] = 'Le match a été terminé avant que vous n\'ayait soumit vos réponses!';
					$this->load->view('templates/haut');
					$this->load->view('menu_visiteur');
					$this->load->view('page_accueil', $data);
					$this->load->view('templates/bas');
				}
			}
		}
	}

	public function corriger($codeMtc){
		$correction = $this->db_model->get_correction_etat($codeMtc);
		//Test si la correction est accessible
		//Si accessible -> affiche la page de la correction
		//Sinon -> redirection vers la page d'accueil
		if($correction->MTC_correction == "D"){
			$data["correction"] = $this->db_model->get_all_que_rep($codeMtc);
			$this->load->view('templates/haut');
			$this->load->view('menu_visiteur');
			$this->load->view('match_afficher_corrige',$data);
			$this->load->view('templates/bas');
		}else{
			$data['titre'] = 'Liste des actualitées :';
			$data['actu'] = $this->db_model->get_all_actualite();
			$data['matchExist'] = $this->db_model->get_match_in_bdd();
			$data['erreur'] = 'La correction n\'est pas disponible';
			$this->load->view('templates/haut');
			$this->load->view('menu_visiteur');
			$this->load->view('page_accueil', $data);
			$this->load->view('templates/bas');
		}
	}
}