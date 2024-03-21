<?php

	

	class  FicheSocieteModel extends CI_Model {

		

		public function __construct() {

			parent::__construct();

		}

		

		public function existe($fiche) {

			return $this->db->select('id')->from('cargaison')->where($fiche)->get()->num_rows() > 0;

		}
		public function verify_fiche_existe($data_fiche_existe) {

			return $this->db->select('id')->from('lot')->where($data_fiche_existe)->get()->num_rows() > 0;

		}
		public function get_last_lot($data_fiche) {

			return $this->db->select('id')->from('lot')->where($data_fiche)->get()->result_array()[0]['id'];

		}

		

		

		public function inserer($fiche) {

			return $this->db->set($fiche)->insert('cargaison');

		}
		public function insert_lot($data_fiche) {

			return $this->db->set($data_fiche)->insert('lot');

		}

		

		public function dernier_id() {

			return intval($this->db->select('id')->from('cargaison')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}

		

		// private function constructeur_de_requete($contraintes) {

		// 	$this->db->query("SET LC_TIME='fr_FR.UTF-8'");

		// 	$code = "CONCAT( societe.nom, '/', zone_corecrabe.nom, '/', cargaison.transport)";

		// 	$zone_corecrabe_id_nom = "CONCAT(zone_corecrabe.id, ' - ', zone_corecrabe.nom)";

		// 	// $date_expedition_literalle = "TO_CHAR(dateExpedition, 'DD TMMonth YYYY')";

		// 	$orderable_columns = array(

		// 		'cargaison.dateDebarquement, societe.nom, zone_corecrabe.nom, cargaison.transport',

		// 		'cargaison.dateDebarquement',

		// 		'cargaison.poidsTotalCargaison',

		// 		'cargaison.dateExpedition',

		// 		'cargaison.transport',
				
		// 		'cargaison.type',

		// 		'societe.nom',

		// 		'zone_corecrabe.id, zone_corecrabe.nom',

		// 		'enqueteur.nom'

		// 	);

		// 	// $this->db->where('fiche.type', $type_enquete);

		// 	$this->db

		// 		->select(array($code => 'code', $zone_corecrabe_id_nom => 'zone_corecrabe_id_nom'), false)

		// 		->select(array(

		// 			'cargaison.*',

		// 			'societe.nom' => 'nomSociete',

		// 			'zone_corecrabe.nom'  => 'nomZone',
					
		// 			'enqueteur.nom' => 'nomEnqueteur'

		// 		))

		// 		->from('cargaison')
				
		// 		->join('zone_corecrabe', 'cargaison.zone=zone_corecrabe.id', 'inner')

		// 		->join('enqueteur', 'cargaison.enqueteur=enqueteur.id', 'inner')

		// 		->join('societe', 'cargaison.societe=societe.id', 'inner');

		// 	if (isset($contraintes['search']['value']) && !empty($contraintes['search']['value'])) {

		// 		$this->db->ilike($code, $contraintes['search']['value'])

		// 			->or_ilike($date_expedition_literalle, $contraintes['search']['value'])

		// 			->or_ilike($zone_corecrabe_id_nom, $contraintes['search']['value'])

		// 			->or_ilike('societe.nom', $contraintes['search']['value'])

		// 			->or_ilike('cargaison.transport', $contraintes['search']['value'])

		// 			->or_ilike('enqueteur.nom', $contraintes['search']['value'])
		// 			->or_ilike('cargaison.type', $contraintes['search']['value'])
		// 			->or_ilike('zone_corecrabe.nom', $contraintes['search']['value']);

		// 	}

		// 	if ((isset($contraintes['order']) && !empty($contraintes['order']))) return $this->db->order_by($orderable_columns[$contraintes['order']['0']['column']], $contraintes['order']['0']['dir']);

		// 	else return $this->db->order_by($orderable_columns[0], 'asc');

		// }

		private function query_builder($constraints) {

			$orderable_columns = array(

				'cargaison.datedebarquement, societe.nom, zone_corecrabe.nom, cargaison.transport',
				'cargaison.id',
				'cargaison.poidstotalcargaison',
				'cargaison.dateexpedition',
				'enqueteur.nom'

			);
			$code = "CONCAT(cargaison.datedebarquement, '/', societe.nom, '/', zone_corecrabe.nom, '/', cargaison.transport)";
	
			$this->db->select(array($code=>'code',
				'cargaison.id',
				'cargaison.poidstotalcargaison' => 'poids',
				'cargaison.dateexpedition' => 'expedition',
				'enqueteur.nom' => 'enqueteur'

		), false)

				->from('cargaison')
				
				->join('zone_corecrabe', 'cargaison.zone=zone_corecrabe.id', 'inner')

				->join('enqueteur', 'cargaison.enqueteur=enqueteur.id', 'left')

				->join('societe', 'cargaison.societe=societe.id', 'inner');
	
			if (isset($constraints['search']['value']) && !empty($constraints['search']['value'])) {
	
				$this->db->ilike('societe.nom', $constraints['search']['value']);
				$this->db->or_ilike('zone_corecrabe.nom', $constraints['search']['value']);
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
	
			return $this->db->from('cargaison')->count_all_results();
	
		}
	
	
	
		public function records_filtered($constraints) {
	
			$query_builder = $this->query_builder($constraints);
	
			return $query_builder->get()->num_rows();
	
		}

		

		// function selection_par_enquete_et_type($fiche_enquete, $type_enquete) {

		// 	$type_enquetes = array(

		// 		'ENQ' => 'fiche_enqueteur',

		// 		'ACH' => 'fiche_acheteur',

		// 		'PEC' => 'fiche_pecheur',

		// 	);

		// 	$code = "CONCAT(zone_corecrabe.id, '/', village.nom, '/$type_enquete/', fiche.annee::varchar, '/', LPAD(fiche.mois::varchar, 2, '0'), '/', LPAD(fiche.numero_ordre::varchar, 3, '0'))";

		// 	$this->db->select(array($code => 'code'), false);

		// 	return $this->db->select(array(

		// 		'fiche.id',

		// 		'fiche.type',

		// 		'annee',

		// 		'mois',

		// 		'numero_ordre',

		// 		'date_expedition',

		// 		'village',

		// 		'enqueteur'

		// 	))

		// 		->from('fiche')

		// 		->join($type_enquetes[$type_enquete], $type_enquetes[$type_enquete].'.fiche=fiche.id', 'inner')

		// 		->join('village', 'fiche.village=village.id', 'inner')

		// 		->join('fokontany', 'village.fokontany=fokontany.id', 'inner')

		// 		->join('commune', 'fokontany.commune=commune.id', 'inner')

		// 		->join('district', 'commune.district=district.id', 'inner')

		// 		->join('region', 'district.region=region.id', 'inner')

		// 		->join('zone_corecrabe', 'region.zone_corecrabe=zone_corecrabe.id', 'inner')

		// 		->where($type_enquetes[$type_enquete].'.id', intval($fiche_enquete))->get()->result_array()[0];

		// }

		

		function selection_par_id($fiche) {

			$this->db->query("SET LC_TIME='fr_FR.UTF-8'");

			return $this->db->select(array(
				'cargaison.*',

				'societe.nom' => 'nomSociete',

				'zone_corecrabe.nom'  => 'nomZone',
				
				'enqueteur.nom' => 'nomEnqueteur'

			))

				->from('cargaison')
				
				->join('zone_corecrabe', 'cargaison.zone=zone_corecrabe.id', 'inner')

				->join('enqueteur', 'cargaison.enqueteur=enqueteur.id', 'left')

				->join('societe', 'cargaison.societe=societe.id', 'inner')

				->where('cargaison.id', intval($fiche))->get()->result_array()[0];

		}

		

		public function supprimer($fiche) {

			return $this->db->where('id', intval($fiche))->delete('cargaison');

		}



		// public function mettre_a_jour($fiche, $id) {

		// 	return $this->db->set($fiche)->where('id', intval($id))->update('fiche');

		// }
	// 	public function RemoteFicheAPI(){
	// 		return $this->db->select('zone_corecrabe.id as Zone, village.nom as Village,fiche.type as Type, fiche.annee as Annee
	// 		, fiche.mois as Mois, fiche.numero_ordre as Num_fiche')

	// 		->from('fiche')

	// 		->join('enqueteur', 'enqueteur=enqueteur.id', 'inner')

	// 		->join('village', 'fiche.village=village.id', 'inner')

	// 		->join('fokontany', 'fokontany=fokontany.id', 'inner')

	// 		->join('commune', 'commune=commune.id', 'inner')

	// 		->join('district', 'district=district.id', 'inner')

	// 		->join('region', 'region=region.id', 'inner')

	// 		->join('zone_corecrabe', 'region.zone_corecrabe=zone_corecrabe.id', 'inner')
			
	// 		->order_by('fiche.id')->get()->result_array();
	// }


	// public function LastFiche($fiche){
	// 	return intval($this->db->select('id')->from('fiche')->where($fiche)->limit(1)->get()->result_array()[0]['id']);
	// }
	


	public function get_last_bac(){
		return intval($this->db->select('id')->from('bac')->limit(1)->order_by('id','desc')->get()->result_array()[0]['id']);
	}

	public function add_provenance($data){
		$this->db->set($data);
		return $this->db->insert('provenance');
	}
	public function add_bac($data){
		$this->db->set($data);
		return $this->db->insert('bac');
	}
	public function add_crabe($dCrabe){
		$this->db->set($dCrabe);
		return $this->db->insert('crabeSociete');
	}


	public function get_lots($id){
		$this->db->where('cargaison', $id);
		return $this->db->select('lot.*, village.nom')->from('lot')
		->join('village', 'lot.village=village.id', 'left') 
		->order_by('lot.id')
		->get()->result_array();
	}
	public function get_bacs($id){
		$this->db->where('lot', $id);
		return $this->db->select('*')->from('bac')->get()->result_array();
	}
	public function get_crabes($id){
		$this->db->where('lot', $id);
		return $this->db->select('*')->from('crabeSociete')->get()->result_array();
	}
	public function get_provenances($id){
		$this->db->where('cargaison', $id);
		return $this->db->select('provenance.*, village.nom')->from('provenance')
		->join('village', 'provenance.village=village.id', 'inner')
		->get()->result_array();
	}





	// public function datatable($constraint) {

	// 	$request_builder = $this->constructeur_de_requete($constraint);

	// 	if ($constraint['length'] != null && $constraint['length'] != -1) $this->db->limit($constraint['length'], $constraint['start']);

	// 	return $request_builder->get()->result_array();

	// }


	}



		

