<?php

	

	class FicheRecensementModel extends CI_Model {

		

		public function __construct() {

			parent::__construct();

		}

		

		public function inserer_fiche_recensement($fiche_recensement) {

			return $this->db->set($fiche_recensement)->insert('fiche_recensement');

		}

		public function lastFicheRec($ficheRec){
			return intval($this->db->select('id')->from('fiche_recensement')->where($ficheEnq)->limit(1)->get()->result_array()[0]['id']);
		}

		

		public function dernier_id() {

			return intval($this->db->select('id')->from('fiche_recensement')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}


		

		public function records_total() {

			return $this->db->from('fiche_recensement')->count_all_results();

		}

		

		

		public function selection_par_fiche($fiche) {

			$date_literalle = "TO_CHAR(fiche_recensement.date,'DD TMMonth YYYY')";

			$this->db->select(array($date_literalle => 'date_literalle'), false);

			$this->db->select(array(

				'fiche_recensement.id',

				'date' => 'date_bd',

				'datedebut',

				'datefin',

				'pirogue',

				'toute_annee',

				'pecheur.village'=> "pecheur_village",

				'pecheur.village_origine'=> "pecheur_village_origine",

				'pecheur.village_activite'=> "pecheur_village_activite",

				'v.nom'=> "village_nom",

				'vo.nom'=>'village_origine_nom',

				'pecheur.nom' => "pecheur_nom",

				'pecheur.sexe'=> "pecheur_sexe",

				'pecheur.datenais'=>"pecheur_datenais",

				'fiche',

			))->from('fiche_recensement');

			$this->db->join('pecheur', 'pecheur=pecheur.id', 'inner');
			
			$this->db->join('village  v', 'pecheur.village=v.id', 'inner');

			$this->db->join('village vo', 'pecheur.village_origine=vo.id', 'inner');

			$this->db->order_by('fiche_recensement.id');

			$this->db->where('fiche', intval($fiche));

			return $this->db->get()->result_array();

		}

		

		public function selection_par_id($id) {

			$date_literalle = "TO_CHAR(fiche_recensement.date,'DD TMMonth YYYY')";

			$this->db->select(array($date_literalle => 'date_literalle'), false);

			return $this->db->select(array(

				'fiche_recensement.id',

				'date' => 'date_originale',

				'fiche',

				'pirogue',

				'toute_annee',

				'datedebut',

				'datefin',

				'pecheur',

				'village_origine'=>'pecheur_village_origine',

				'village_activite'=>'pecheur_village_activite',

				

			))->from('fiche_recensement')->join('pecheur', 'pecheur=pecheur.id', 'inner')->where('fiche_recensement.id', intval($id))->get()->result_array()[0];

		}


		public function enquete_totale_par_fiche($fiche) {

			return $this->db->select('id')->from('fiche_recensement')->where('fiche', intval($fiche))->get()->num_rows();

		}

		

		public function mettre_a_jour($fiche_recensement, $id) {

			return $this->db->set($fiche_recensement)->where('id', intval($id))->update('fiche_recensement');

		}

		

		

		public function supprimer($fiche_recensement) {

			return $this->db->where('id', $fiche_recensement)->delete('fiche_recensement');

		}

		

		public function inserer($fiche_recensement) {

			return $this->db->set($fiche_recensement)->insert('fiche_recensement');

		}

	

		public function selection_par_activite_recensement($fiche_recensement) {

			$this->db->select(array(

				"activite_recensement.id",

				"activite",

				"activite.nom"=>"activite_nom",

				"pourcentage"

			));

			return $this->db->from('activite_recensement')->join('activite', 'activite_recensement.activite=activite.id', 'inner')->order_by('id')->where('fiche_recensement', intval($fiche_recensement))->get()->result_array();

		}
		public function selection_par_engin_recensement($fiche_recensement) {

			$this->db->select(array(

				"engin_fiche_recensement.id",

				"engin",

				"engin.nom"=>"engin_nom",

				"annee"

			));

			return $this->db->from('engin_fiche_recensement')->join('engin', 'engin_fiche_recensement.engin=engin.id', 'inner')->order_by('id')->where('fiche_recensement', intval($fiche_recensement))->get()->result_array();

		}

		

	}

