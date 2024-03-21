<?php

	require_once 'FicheEnqueteurModel.php';

	

	class EchantillonModel extends CI_Model {

		

		public function __construct() {

			parent::__construct();

		}

		

		public function dernier_id() {

			return intval($this->db->select('id')->from('echantillon')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}



		public function selection_par_fiche_enqueteur($fiche_enqueteur) {

			return $this->db->from('echantillon')->where('fiche_enqueteur', intval($fiche_enqueteur))->get()->result_array()[0];

		}



		public function mettre_a_jour($fiche_enqueteur, $echantillon) {

			return $this->db->set($echantillon)->where('fiche_enqueteur', intval($fiche_enqueteur))->update('echantillon');

		}



		public function selection_id_par_fiche_enqueteur($fiche_enqueteur) {

			return $this->db->select('id')->from('echantillon')->where('fiche_enqueteur', intval($fiche_enqueteur))->get()->result_array()[0]['id'];

		}



		public function inserer($echantillon) {

			return $this->db->set($echantillon)->insert('echantillon');

		}

		public function lastEchantillon($echantillon){
			return intval($this->db->select('id')->from('echantillon')->where($echantillon)->limit(1)->get()->result_array()[0]['id']);
		}
	}
