<?php
	
	class CrabeController extends CI_Controller {
		public function __construct() {
			parent::__construct();
			
			// chargement des models à utiliser
			$this->load->model('CrabeModel', 'db_crabe');
		}
		
		public function index() {
		
		}
		
		public function insertion() {
			$crabe = array(
				'echantillon' => $this->input->post('sample'),
				'crabe_sexe' => $this->input->post('sex'),
				'crabe_taille' => $this->input->post('size'),
				'crabe_destination' => $this->input->post('destination'),
			);
			$insertion = $this->db_crabe->insertion($crabe);
			echo json_encode(array('success' => $insertion));
		}
	}
