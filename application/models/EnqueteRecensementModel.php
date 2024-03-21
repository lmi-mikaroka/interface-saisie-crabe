<?php

	

	class  EnqueteRecensementModel extends CI_Model {

		

		public function __construct() {

			parent::__construct();

		}

		

		public function existe($enquete) {

			return $this->db->select('id')->from('enquete_recensement')->where($enquete)->get()->num_rows() > 0;

		}

		

		public function inserer($enquete) {

			return $this->db->set($enquete)->insert('enquete_recensement');

		}

        public function dernier_id() {

			return intval($this->db->select('id')->from('enquete_recensement')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}

		public function get_enquetes($id){
			$this->db->where('recensement', $id);
			return $this->db->select('enquete_recensement.*, pecheur.nom,pecheur.village_activite,pecheur.village_origine,pecheur.sexe,pecheur.datenais,vo.nom as village_origine_nom')->from('enquete_recensement')
			->join('pecheur', 'enquete_recensement.pecheur=pecheur.id', 'inner') 
			->join('village vo', 'pecheur.village_origine=vo.id', 'inner')
			->order_by('enquete_recensement.id')
			->get()->result_array();
		}

		public function selection_par_activite_recensement($fiche_recensement) {

			$this->db->select(array(

				"activite_enquete_recensement.id",

				"activite",

				"activite.nom"=>"activite_nom",

				"pourcentage"

			));

			return $this->db->from('activite_enquete_recensement')->join('activite', 'activite_enquete_recensement.activite=activite.id', 'inner')->order_by('id')->where('enquete_recensement', intval($fiche_recensement))->get()->result_array();

		}
		public function selection_par_engin_recensement($fiche_recensement) {

			$this->db->select(array(

				"engin_enquete_recensement.id",

				"engin",

				"engin.nom"=>"engin_nom",

				"annee"

			));

			return $this->db->from('engin_enquete_recensement')->join('engin', 'engin_enquete_recensement.engin=engin.id', 'inner')->order_by('id')->where('enquete_recensement', intval($fiche_recensement))->get()->result_array();

		}

		public function supprimer($enquete) {

			return $this->db->where('id', intval($enquete))->delete('enquete_recensement');

		}


		function selection_par_id($fiche) {

			$this->db->query("SET LC_TIME='French_France.1252'");

			return $this->db->select(array(
				'enquete_recensement.*',

                 
				'pecheur.nom'=>'nomPecheur',

				'pecheur.sexe',
				
				'pecheur.datenais',

				'pecheur.village_origine'=>'pecheur_village_origine',

				'pecheur.village_activite'=>'pecheur_village_activite',





			))

				->from('enquete_recensement')


				->join('pecheur', 'enquete_recensement.pecheur=pecheur.id', 'inner')

				->where('enquete_recensement.id', intval($fiche))->get()->result_array()[0];

		}

		public function mettre_a_jour($id,$enquete_recensement) {

			return $this->db->set($enquete_recensement)->where('id', intval($id))->update('enquete_recensement');

		}

		// public function ordonnes_resident(){
		// 	return $this->db->select('enquete_recensement.*,pecheur.village_origine,pecheur.village')->from('enquete_recensement')
		// 	->join('pecheur','enquete_recensement.pecheur=pecheur.id')
		// 	->where('pecheur.village_origine != pecheur.village')
		// 	->where('pecheur.village_origine is not  null')
		// 	->get()->result_array();
		// }



		




	}



		

