<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profil extends CI_Controller { 

	public function __construct(){
		parent::__construct();
		$this->load->model('db_model');
		$this->load->helper('url_helper');
	}

	

	public function afficher($choix = 'afficher'){
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		if(!isset($_SESSION['username'])){
			$data['erreur'] = "Vous n'avez pas accès à cet espace!";
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur'); 
			$this->load->view('compte_connecter',$data); 
			$this->load->view('templates/bas');
		}
		if($_SESSION["role"] == "A"){
			$menu = "menu_administrateur";
		}else {
			$menu = "menu_formateur";
		}


		$data["infoPerso"] = $this->db_model->getInfoPerso();
		$data["choix"] = $choix;
		$this->load->view('templates/hautBack'); 
		$this->load->view($menu); 
		$this->load->view('compte_profil',$data); 
		$this->load->view('templates/bas');
	}


	public function modifier(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		if(!isset($_SESSION['username'])){
			$date['erreur'] = "Vous n'avez pas accès à cet espace!";
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur'); 
			$this->load->view('compte_connecter',$data); 
			$this->load->view('templates/bas');
		}else{
			if($_SESSION['role'] == 'A'){
				$view = 'menu_administrateur';
			}else{
				$view = 'menu_formateur';
			}

			$newPass = $this->input->post('newPass');
			$confirmPass = $this->input->post('confirmPass');
			$data["infoPerso"] = $this->db_model->getInfoPerso();

			if($newPass == NULL || $confirmPass == NULL){
				$data['result'] = "Champs de saisie vides !";
				$data['choix'] = "modifier";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view($view); 
				$this->load->view('compte_profil', $data); 
				$this->load->view('templates/bas');
			}else{
				if($this->db_model->modPassword($newPass,$confirmPass) == TRUE){
				$data['choix'] = "afficher";
				$data['resultType'] = "success";
				$data['result'] = "Mot de passe mis à jour!";
				$this->load->view('templates/hautBack'); 
				$this->load->view($view); 
				$this->load->view('compte_profil', $data); 
				$this->load->view('templates/bas');
				}else{
					$data['result'] = "Confirmation du mot de passe erronée, veuillez réessayer !";
					$data['choix'] = "modification";
					$data['resultType'] = "primary";
					$this->load->view('templates/hautBack'); 
					$this->load->view($view); 
					$this->load->view('compte_profil', $data); 
					$this->load->view('templates/bas');
				}
			}
		}
	}

	public function deconnecter(){
		session_destroy();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['titre'] = 'Liste des actualitées :';
		$data['actu'] = $this->db_model->get_all_actualite();
		$data['matchExist'] = $this->db_model->get_match_in_bdd();
		$data['erreur'] = '';
		
		$this->load->view('templates/haut'); 
		$this->load->view('menu_visiteur'); 
		$this->load->view('page_accueil', $data); 
		$this->load->view('templates/bas');
	}
}
?>