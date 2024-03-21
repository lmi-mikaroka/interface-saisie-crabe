<?php

	

	class  RecensementMensuelModel extends CI_Model {

		

		public function __construct() {

			parent::__construct();

		}

		

		public function existe($fiche) {

			return $this->db->select('id')->from('recensement_mensuel')->where($fiche)->get()->num_rows() > 0;

		}
		public function existe_id($fiche){

			return intval($this->db->select('id')->from('recensement_mensuel')->where($fiche)->get()->result_array()[0]['id']);
		}


		public function inserer($fiche) {

			return $this->db->set($fiche)->insert('recensement_mensuel');

		}	

		public function dernier_id() {

			return intval($this->db->select('id')->from('recensement_mensuel')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}

		public function inserer_enquete($enquete) {

			return $this->db->set($enquete)->insert('enquete_recensement_mensuel');

		}
		public function dernier_id_enquete() {

			return intval($this->db->select('id')->from('enquete_recensement_mensuel')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}

		public function inserer_activite_enquete($activite) {

			return $this->db->set($activite)->insert('activite_recensement_mensuel');

		}


        public function liste_fiche_existe($village,$idfiche){
            $this->db->select('id, nom,sexe');
            $this->db->from('pecheur')->where('village',intval($village));
            $query1 = $this->db->get_compiled_select();
            
            $this->db->select('pecheur.id, pecheur.nom, pecheur.sexe');
            $this->db->from('enquete_recensement_mensuel')->join("pecheur", "pecheur=pecheur.id")->where('recensement_mensuel',intval($idfiche));
            $query2 = $this->db->get_compiled_select();
            
            $query = $this->db->query($query1 . ' EXCEPT ' . $query2);
			return $query->result_array();

        }
        public function liste_fiche_non_existe($village){
            $this->db_pecheur->where('village',$village);
        }


	

		private function query_builder($constraints) {

           

			$orderable_columns = array(

				'recensement_mensuel.date, commune.nom,fokontany.nom, village.nom,recensement_mensuel.annee,recensement_mensuel.mois,recensement_mensuel.id',
				'recensement_mensuel.id',
				'enqueteur.nom'

			);
			$code = "CONCAT( fokontany.nom,'/',village.nom,'/',recensement_mensuel.annee,'/',LPAD(recensement_mensuel.mois::varchar, 2, '0'))";
			$date_frs = "TO_CHAR(date, 'DD/MM/YYYY')";
			$this->db->select(array($code=>'code',
				'recensement_mensuel.id',
				$date_frs=>'date',
				'enqueteur.nom' => 'enqueteur'


		), false)

				->from('recensement_mensuel')
				
				->join("village", "village.id=recensement_mensuel.village")

				->join("fokontany", "fokontany.id=village.fokontany")

				->join("commune", "commune.id=fokontany.commune")

				->join('enqueteur', 'recensement_mensuel.enqueteur=enqueteur.id', 'left');
	
			if (isset($constraints['search']['value']) && !empty($constraints['search']['value'])) {
	
				$this->db->ilike('village.nom', $constraints['search']['value']);
				$this->db->or_ilike('fokontany.nom', $constraints['search']['value']);
				$this->db->or_ilike($code, $constraints['search']['value']);
	
			}
	
			if ((isset($constraints['order']) && !empty($constraints['order']))) return $this->db->order_by($orderable_columns[$constraints['order']['0']['column']], $constraints['order']['0']['dir']);
	
			else return $this->db->order_by($orderable_columns[0], 'asc');
	
		}

		public function datatable($constraints) {

			$query_builder = $this->query_builder($constraints);
	
			if ($constraints['length'] != null && $constraints['length'] != -1) $query_builder->limit($constraints['length'], $constraints['start']);
	
			return $query_builder->get()->result_array();
	
		}
	
	
	
		public function records_total() {
	
			return $this->db->from('recensement_mensuel')->count_all_results();
	
		}
	
	
	
		public function records_filtered($constraints) {
	     
			$query_builder = $this->query_builder($constraints);
	
			return $query_builder->get()->num_rows();
	
		}

		

		function selection_par_enquete_et_type($fiche_enquete, $type_enquete) {

			$type_enquetes = array(

				'ENQ' => 'fiche_enqueteur',

				'ACH' => 'fiche_acheteur',

				'PEC' => 'fiche_pecheur',

				'RC5' => 'fiche_recensement',

			);

			$code = "CONCAT(zone_corecrabe.id, '/', village.nom, '/$type_enquete/', fiche.annee::varchar, '/', LPAD(fiche.mois::varchar, 2, '0'), '/', LPAD(fiche.numero_ordre::varchar, 3, '0'))";

			$this->db->select(array($code => 'code'), false);

			return $this->db->select(array(

				'fiche.id',

				'fiche.type',

				'annee',

				'mois',

				'numero_ordre',

				'date_expedition',

				'village',

				'enqueteur'

			))

				->from('fiche')

				->join($type_enquetes[$type_enquete], $type_enquetes[$type_enquete].'.fiche=fiche.id', 'inner')

				->join('village', 'fiche.village=village.id', 'inner')

				->join('fokontany', 'village.fokontany=fokontany.id', 'inner')

				->join('commune', 'fokontany.commune=commune.id', 'inner')

				->join('district', 'commune.district=district.id', 'inner')

				->join('region', 'district.region=region.id', 'inner')

				->join('zone_corecrabe', 'region.zone_corecrabe=zone_corecrabe.id', 'inner')

				->where($type_enquetes[$type_enquete].'.id', intval($fiche_enquete))->get()->result_array()[0];

		}

		

		function selection_par_id($fiche) {

			// $this->db->query("SET LC_TIME='French_France.1252'");
			$code = "CONCAT( fokontany.nom,'/',village.nom,'/',recensement_mensuel.annee,'/',LPAD(recensement_mensuel.mois::varchar, 2, '0'))";
            $mois = "LPAD(recensement_mensuel.mois::varchar, 2, '0')";
			return $this->db->select(array(
				'recensement_mensuel.*',
				
				$code=>'code',

				$mois =>'moisfiche',

				'zone_corecrabe.nom'=>'nomZone',

				'village.nom'  => 'nomVillage',

				'fokontany.nom'=>'nomFokontany',

				'commune.nom' =>'nomCommune',
				
				'enqueteur.nom' => 'nomEnqueteur',
				
				'district.nom'=>'nomDistrict'

			))

				->from('recensement_mensuel')
				
				->join('village', 'recensement_mensuel.village=village.id', 'inner')

				->join('fokontany', 'village.fokontany=fokontany.id', 'inner')

				->join('commune', 'fokontany.commune=commune.id', 'inner')

				->join('district', 'commune.district=district.id', 'left')

				->join('region', 'district.region=region.id', 'left')

				->join('zone_corecrabe', 'region.zone_corecrabe=zone_corecrabe.id', 'left')

				->join('enqueteur', 'recensement_mensuel.enqueteur=enqueteur.id', 'left')

				->where('recensement_mensuel.id', intval($fiche))->get()->result_array()[0];

		}

		public function selection_par_id_enquete($enquete){

			return $this->db->select(array(
				'enquete_recensement_mensuel.*',

				'pecheur.nom'=>'nomPecheur',

				'pecheur.sexe'  => 'sexe',


			))

				->from('enquete_recensement_mensuel')
				
				->join('pecheur', 'enquete_recensement_mensuel.pecheur=pecheur.id', 'inner')

				->where('enquete_recensement_mensuel.id', intval($enquete))->get()->result_array()[0];

		}

		function selection_enquete_par_fiche($fiche) {


			return $this->db->select(array(
				'enquete_recensement_mensuel.*',

				'pecheur.nom'  => 'nomPecheur',

				'pecheur.sexe'=>'sexe',

				'crabe' 

			))

				->from('enquete_recensement_mensuel')
				
				->join('pecheur', 'enquete_recensement_mensuel.pecheur=pecheur.id', 'inner')

				->where('recensement_mensuel', intval($fiche))->get()->result_array();

		}

		public function selection_par_activite_recensement($enquete_recensement) {

			$this->db->select(array(

				"activite_recensement_mensuel.id",

				"activite",

				"activite.nom"=>"nomActivite",

				"pourcentage"

			));

			return $this->db->from('activite_recensement_mensuel')->join('activite', 'activite_recensement_mensuel.activite=activite.id', 'inner')->order_by('id')->where('enquete_recensement_mensuel', intval($enquete_recensement))->get()->result_array();

		}
		

		

		public function supprimer($fiche) {

			return $this->db->where('id', intval($fiche))->delete('recensement_mensuel');

		}

		public function supprimer_enquete($enquete) {

			return $this->db->where('id', intval($enquete))->delete('enquete_recensement_mensuel');

		}
		public function supprimer_activite_recensement_mensuel($id_enquete) {
			return $this->db->where('enquete_recensement_mensuel', intval($id_enquete))->delete('activite_recensement_mensuel');
		}

		public function mettre_a_jour($fiche, $id) {

			return $this->db->set($fiche)->where('id', intval($id))->update('recensement');

		}
		public function RemoteFicheAPI(){
			return $this->db->select('zone_corecrabe.id as Zone, village.nom as Village,fiche.type as Type, fiche.annee as Annee
			, fiche.mois as Mois, fiche.numero_ordre as Num_fiche')

			->from('fiche')

			->join('enqueteur', 'enqueteur=enqueteur.id', 'inner')

			->join('village', 'fiche.village=village.id', 'inner')

			->join('fokontany', 'fokontany=fokontany.id', 'inner')

			->join('commune', 'commune=commune.id', 'inner')

			->join('district', 'district=district.id', 'inner')

			->join('region', 'region=region.id', 'inner')

			->join('zone_corecrabe', 'region.zone_corecrabe=zone_corecrabe.id', 'inner')
			
			->order_by('fiche.id')->get()->result_array();
	}


	public function LastFiche($fiche){
		return intval($this->db->select('id')->from('fiche')->where($fiche)->limit(1)->get()->result_array()[0]['id']);
	}

	function selection_par_id_zone($fiche) {

		return  $this->db->select('zone_corecrabe')->from('fiche')

		->join('enqueteur', 'enqueteur=enqueteur.id', 'inner')

		->join('village', 'fiche.village=village.id', 'inner')

		->join('fokontany', 'fokontany=fokontany.id', 'inner')

		->join('commune', 'commune=commune.id', 'inner')

		->join('district', 'district=district.id', 'inner')

		->join('region', 'region=region.id', 'inner')

		->join('zone_corecrabe', 'region.zone_corecrabe=zone_corecrabe.id', 'inner')

		->where('fiche.id',intval($fiche))
		
		->get()->result_array()[0];

	}

	function update($recensement,$id){
		return $this->db->set($recensement)->where('id', intval($id))->update('recensement');
	}
	public function mettre_a_jour_enquete($enquete, $id) {

		return $this->db->set($enquete)->where('id', intval($id))->update('enquete_recensement_mensuel');

	}


	}



		

