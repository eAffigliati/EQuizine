<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Accueil extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('db_model');
			$this->load->helper('url');
		}

		public function afficher() {
			$this->load->helper('form');
			$this->load->library('form_validation');

			if(!isset($_SESSION['username'])){
				$menu = 'menu_visiteur';
			}else{
				if($_SESSION['role'] == 'A'){
					$menu = 'menu_administrateur';
				}else{
					$menu = 'menu_formateur';
				}
			}

			$data['titre'] = 'Liste des actualitées :';
			$data['actu'] = $this->db_model->get_all_actualite();
			$data['matchExist'] = $this->db_model->get_match_in_bdd();
			$data['erreur'] = '';

			$this->load->view('templates/haut');
			$this->load->view($menu);
			$this->load->view('page_accueil', $data);
			$this->load->view('templates/bas');
		}

		public function participer() {
			if(!isset($_SESSION['username'])){
				$menu = 'menu_visiteur';
			}else{
				if($_SESSION['role'] == 'A'){
					$menu = 'menu_administrateur';
				}else{
					$menu = 'menu_formateur';
				}
			}

			$this->load->helper('form');
			$this->load->library('form_validation');
			$data['titre'] = 'Liste des actualitées :';
			$data['actu'] = $this->db_model->get_all_actualite();
			$data['matchExist'] = $this->db_model->get_match_in_bdd();

			if ($this->input->post('codeMtc') == NULL){

				$data['erreur'] = 'Veuillez saisir un code de match !';

				$this->load->view('templates/haut');
				$this->load->view($menu);
				$this->load->view('page_accueil', $data);
				$this->load->view('templates/bas');
			}else{

				//Test si le code de match saisi existe
				//Si vrai -> Test si le quiz associé est accessible
				//Si faux -> Réaffichae du formulaire pour saisir le code d'un match dans la page page_accueil et d'un message d'erreur;
				if ($this->db_model->get_match_exist($this->input->post('codeMtc')) == TRUE) {
					//Test si le quiz associé au match est actif
					//Si vrai -> Test si le match est actif ou démarré
					//Si faux -> Réaffichae du formulaire pour saisir le code d'un match dans la page page_accueil et d'un message d'erreur;
					if ($this->db_model->get_quiz_actif($this->input->post('codeMtc')) == TRUE) {
						//Test si le match est actif ou démarré
						//Si vrai -> Affichage du formulaire pour saisir le pseudo dans la page page_accueil
						//Si faux -> Réaffichae du formulaire pour saisir le code d'un match dans la page page_accueil et d'un message d'erreur;
						if ($this->db_model->get_match_availability($this->input->post('codeMtc')) == TRUE) {
							$data['mtcCode'] = $this->input->post('codeMtc');
							$data['erreur'] = '';
							$this->load->view('templates/haut');
							$this->load->view($menu);
							$this->load->view('page_accueil',$data);
							$this->load->view('templates/bas');
						}else{//Le match est désactivé ou non démarré
							$data['erreur'] = 'Match désactivé ou non démarré !';
							$this->load->view('templates/haut');
							$this->load->view($menu);
							$this->load->view('page_accueil',$data);
							$this->load->view('templates/bas');
						}
					}else{//Quiz associé non actif
						$data['erreur'] = 'Quiz du match désactivé !';
						$this->load->view('templates/haut');
						$this->load->view($menu);
						$this->load->view('page_accueil',$data);
						$this->load->view('templates/bas');
					}
				}else{//Code de match non existant
					$data['erreur'] = 'Code de match non existant !';
					$this->load->view('templates/haut');
					$this->load->view($menu);
					$this->load->view('page_accueil',$data);
					$this->load->view('templates/bas');
				}
			}
		}
	}
?>