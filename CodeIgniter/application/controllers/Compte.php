<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Compte extends CI_Controller { 

	public function __construct(){
		parent::__construct();
		$this->load->model('db_model');
		$this->load->helper('url_helper');
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
			if($_SESSION['role'] == 'A'){
				$data['titre'] = 'Liste des pseudos :';
				$data['profil'] = $this->db_model->get_all_compte();
				$data['nbRsp'] = $this->db_model->count_responsable();

				$this->load->view('templates/hautBack');
				$this->load->view('menu_administrateur');
				$this->load->view('compte_liste',$data);
				$this->load->view('templates/bas');
			}else{
				$data['result'] = "Vous n'avez pas accès à cet espace!";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_formateur'); 
				$this->load->view('compte_menu',$data); 
				$this->load->view('templates/bas');
			}
			
		}
	}
/*
	public function creer(){
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('id', 'id', 'required');
		$this->form_validation->set_rules('mdp', 'mdp', 'required');
		
       	if ($this->form_validation->run() == FALSE){
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur');
			$this->load->view('compte_creer');
			$this->load->view('templates/bas');
		} else{
			$this->db_model->set_compte();
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur');
			$this->load->view('compte_succes');
			$this->load->view('templates/bas');
			}
		}
*/
	public function acceder(){
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->load->view('templates/haut'); 
		$this->load->view('menu_visiteur'); 
		$this->load->view('compte_connecter'); 
		$this->load->view('templates/bas');
	}

	public function connecter(){
		$this->load->helper('form');
		$this->load->library('form_validation');

		if(isset($_SESSION['role'])){
			if($_SESSION['role'] == 'A'){
				$data['result'] = "Vous n'avez pas accès à cette espace !";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_administrateur'); 
				$this->load->view('compte_menu',$data); 
				$this->load->view('templates/bas');
			}else{
				$data['result'] = "Vous n'avez pas accès à cette espace !";
				$data['resultType'] = "primary";
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_formateur'); 
				$this->load->view('compte_menu',$data); 
				$this->load->view('templates/bas');
			}
		}else{
			$username = $this->input->post('pseudo');
			$password = $this->input->post('mdp');

     		if ($username == null || $password == null){
     			$data['erreur'] = "Veuillez saisir un identifiant et un mot de passe pour accéder à l'espace privé !";
				$this->load->view('templates/haut'); 
				$this->load->view('menu_visiteur');
				$this->load->view('compte_connecter',$data);
				$this->load->view('templates/bas');
			}else{
				if($this->db_model->connect_compte($username,$password)) {
					$_SESSION['username'] = $username;
					$_SESSION['role'] = $this->db_model->get_role($username);
					if($_SESSION['role'] == 'A'){
						$this->load->view('templates/hautBack'); 
						$this->load->view('menu_administrateur'); 
						$this->load->view('compte_menu'); 
						$this->load->view('templates/bas');
					}else{
						$this->load->view('templates/hautBack'); 
						$this->load->view('menu_formateur'); 
						$this->load->view('compte_menu'); 
						$this->load->view('templates/bas');
					}
				}else{
     				$data['erreur'] = "Identifiants erronés ou inexistants !";
					$this->load->view('templates/haut'); 
					$this->load->view('menu_visiteur'); 
					$this->load->view('compte_connecter', $data); 
					$this->load->view('templates/bas');
				}
			}
		}
	}

	public function afficher(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		if(!isset($_SESSION['username'])){
			$data['erreur'] = "Vous n'avez pas accès à cet espace!";
			$this->load->view('templates/haut'); 
			$this->load->view('menu_visiteur'); 
			$this->load->view('compte_connecter',$data); 
			$this->load->view('templates/bas');
		}else{
			if($_SESSION['role'] == 'A'){
				$this->load->view('templates/haut'); 
				$this->load->view('menu_administrateur'); 
				$this->load->view('compte_menu'); 
				$this->load->view('templates/bas');
			}else{
				$this->load->view('templates/hautBack'); 
				$this->load->view('menu_formateur'); 
				$this->load->view('compte_menu'); 
				$this->load->view('templates/bas');
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