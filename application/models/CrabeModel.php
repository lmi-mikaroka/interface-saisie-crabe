<?php

	class CrabeModel extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function insertion($crabe) {
			return $this->db->set($crabe)->insert('crabe');
		}

		public function selection_par_echantillon($echantillon) {
			$selections = array(
				'id',
				'destination',
				'sexe',
				'taille',
				'echantillon' => 'echantillon_reference',
			);
			return $this->db->select($selections)->from('crabe')->where('echantillon', intval($echantillon))->get()->result_array();
		}

		public function supprimer_crabe_par_echantillon($echantillon) {
			return $this->db->where('echantillon', intval($echantillon))->delete('crabe');
		}
	}
