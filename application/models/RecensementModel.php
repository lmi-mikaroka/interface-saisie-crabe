<?php

	

	class  RecensementModel extends CI_Model {

		

		public function __construct() {

			parent::__construct();

		}

		

		public function existe($fiche) {

			return $this->db->select('id')->from('recensement')->where($fiche)->get()->num_rows() > 0;

		}
		public function dernier_numero_ordre($fiche){

			return intval($this->db->select('numero_ordre')->from('recensement')->where($fiche)->order_by('numero_ordre', 'desc')->limit(1)->get()->result_array()[0]['numero_ordre']);
		}

		

		public function inserer($fiche) {

			return $this->db->set($fiche)->insert('recensement');

		}

		

		public function dernier_id() {

			return intval($this->db->select('id')->from('recensement')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}

		

		private function query_builder($constraints) {

			$orderable_columns = array(

				'village.nom,recensement.date, commune.nom,fokontany.nom,recensement.numero_ordre,recensement.id',
				'recensement.id',
				'enqueteur.nom'

			);
			$code = "CONCAT( village.nom,'/',recensement.date,'/',recensement.numero_ordre)";
	
			$this->db->select(array($code=>'code',
				'recensement.id',
				'enqueteur.nom' => 'enqueteur'

		), false)

				->from('recensement')
				
				->join("village", "village.id=recensement.village")

				->join("fokontany", "fokontany.id=village.fokontany")

				->join("commune", "commune.id=fokontany.commune")

				->join('enqueteur', 'recensement.enqueteur=enqueteur.id', 'left');
	
			if (isset($constraints['search']['value']) && !empty($constraints['search']['value'])) {
	
				$this->db->ilike('village.nom', $constraints['search']['value']);
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
	
			return $this->db->from('recensement')->count_all_results();
	
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

			

			return $this->db->select(array(
				'recensement.*',

				'village.nom'  => 'nomVillage',

				'fokontany.nom'=>'nomFokontany',

				'commune.nom' =>'nomCommune',
				
				'enqueteur.nom' => 'nomEnqueteur',
				
				'district.nom'=>'nomDistrict'

			))

				->from('recensement')
				
				->join('village', 'recensement.village=village.id', 'inner')

				->join('fokontany', 'village.fokontany=fokontany.id', 'inner')

				->join('commune', 'fokontany.commune=commune.id', 'inner')

				->join('district', 'commune.district=district.id', 'left')

				->join('enqueteur', 'recensement.enqueteur=enqueteur.id', 'left')

				->where('recensement.id', intval($fiche))->get()->result_array()[0];

		}
		

		

		public function supprimer($fiche) {

			return $this->db->where('id', intval($fiche))->delete('recensement');

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


	}



		

