<?php
	
	
	class EchantillonController extends CorecrabeController {
		public function __construct() {
			parent::__construct();
			
			// chargement des models à utiliser
			$this->load->model('EchantillonModel', 'db_echantillon');
		}
		
		public function insertion() {
			$echantillon = array(
				'fiche_enquete' => $this->input->post('ficheEnquete'),
				'echantillon_trie' => $this->input->post('echantillonTrie'),
				'echantillon_certaine_taille_absente' => $this->input->post('echantillonCertaineTailleAbsente'),
				'echantillon_certaine_taille_absente_precision' => $this->input->post('echantillonCertaineTailleAbsentePrecision'),
				'echantillon_poids_total' => $this->input->post('echantillonPoidsTotal'),
			);
			$insertion = $this->db_echantillon->insertion_echantillon($echantillon);
			echo json_encode(array('success' => $insertion, 'message' => $insertion ? $this->db_echantillon->dernier_id() : 'erreur'));
		}
	}
