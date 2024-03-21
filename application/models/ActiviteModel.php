<?php

	class ActiviteModel extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function insertion($activite) {
			return $this->db->set($activite)->insert('activite');
		}

		public function inserer_activite_fiche_recensement($activite_fiche_recensement) {
			return $this->db->set($activite_fiche_recensement)->insert('activite_recensement');
		}

		public function liste() {
			$selections = array(
				'id',
				'nom',
			);
			return $this->db->select($selections)->from('activite')->get()->result_array();
		}
		

		public function supprimer_activite($id) {
			return $this->db->where('id', intval($id))->delete('activite');
		}

		public function supprimer_activite_recensement($id_fiche) {
			return $this->db->where('fiche_recensement', intval($id_fiche))->delete('activite_recensement');
		}

		public function inserer_activite_enquete_recensement($activite_enquete_recensement) {
			return $this->db->set($activite_enquete_recensement)->insert('activite_enquete_recensement');
		}

		public function supprimer_enquete_activite_recensement($id_enquete) {
			return $this->db->where('enquete_recensement', intval($id_enquete))->delete('activite_enquete_recensement');
		}
	}
