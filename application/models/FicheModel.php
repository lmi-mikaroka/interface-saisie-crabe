<?php

	

	class  FicheModel extends CI_Model {

		

		public function __construct() {

			parent::__construct();

		}

		

		public function existe($fiche) {

			return $this->db->select('id')->from('fiche')->where($fiche)->get()->num_rows() > 0;

		}

		

		public function inserer($fiche) {

			return $this->db->set($fiche)->insert('fiche');

		}

		

		public function dernier_id() {

			return intval($this->db->select('id')->from('fiche')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}

		

		private function constructeur_de_requete($contraintes, $type_enquete) {

			$this->db->query("SET LC_TIME='fr_FR.UTF-8'");

			$code = "CONCAT(zone_corecrabe.id, '/', village.nom, '/$type_enquete/', annee::varchar, '/', LPAD(mois::varchar, 2, '0'), '/', LPAD(numero_ordre::varchar, 3, '0'))";

			$zone_corecrabe_id_nom = "CONCAT(zone_corecrabe.id, ' - ', zone_corecrabe.nom)";

			$date_expedition_literalle = "TO_CHAR(date_expedition, 'DD TMMonth YYYY')";

			$orderable_columns = array(

				'zone_corecrabe.id, village.nom, fiche.type, annee, mois, numero_ordre',

				'zone_corecrabe.id',

				'region.nom',

				'date_expedition',

				'enqueteur.code'

			);

			$this->db->where('fiche.type', $type_enquete);

			$this->db

				->select(array($code => 'code', $date_expedition_literalle => 'date_expedition_literalle', $zone_corecrabe_id_nom => 'zone_corecrabe_id_nom'), false)

				->select(array(

					'fiche.id',

					'region.nom' => 'region',

					'enqueteur.code' => 'enqueteur',

					'enqueteur.id' => 'enqueteur_id'

				))

				->from('fiche')

				->join('enqueteur', 'enqueteur=enqueteur.id', 'inner')

				->join('village', 'fiche.village=village.id', 'inner')

				->join('fokontany', 'fokontany=fokontany.id', 'inner')

				->join('commune', 'commune=commune.id', 'inner')

				->join('district', 'district=district.id', 'inner')

				->join('region', 'region=region.id', 'inner')

				->join('zone_corecrabe', 'region.zone_corecrabe=zone_corecrabe.id', 'inner');

			if (isset($contraintes['search']['value']) && !empty($contraintes['search']['value'])) {

				$this->db->ilike($code, $contraintes['search']['value'])

					->or_ilike($date_expedition_literalle, $contraintes['search']['value'])

					->or_ilike($zone_corecrabe_id_nom, $contraintes['search']['value'])

					->or_ilike('zone_corecrabe.nom', $contraintes['search']['value'])

					->or_ilike('region.nom', $contraintes['search']['value'])

					->or_ilike('enqueteur.code', $contraintes['search']['value']);

			}

			if ((isset($contraintes['order']) && !empty($contraintes['order']))) return $this->db->order_by($orderable_columns[$contraintes['order']['0']['column']], $contraintes['order']['0']['dir']);

			else return $this->db->order_by($orderable_columns[0], 'asc');

		}

		

		public function datatable($constraint, $investigation_type) {

			$request_builder = $this->constructeur_de_requete($constraint, $investigation_type);

			if ($constraint['length'] != null && $constraint['length'] != -1) $this->db->limit($constraint['length'], $constraint['start']);

			return $request_builder->get()->result_array();

		}

		

		public function records_total($type_enquete) {

			return $this->db->from('fiche')->where(array('fiche.type' => $type_enquete))->count_all_results();

		}

		

		public function records_filtered($contrainte, $investigation_type) {

			$requete = $this->constructeur_de_requete($contrainte, $investigation_type);

			return $requete->get()->num_rows();

		}

		

		function selection_par_enquete_et_type($fiche_enquete, $type_enquete) {

			$type_enquetes = array(

				'ENQ' => 'fiche_enqueteur',

				'ACH' => 'fiche_acheteur',

				'PEC' => 'fiche_pecheur',

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

		

		function selection_par_id($fiche, $type_enquete = '') {

			$this->db->query("SET LC_TIME='fr_FR.UTF-8'");

			$specification_type_enquete = empty($type_enquete) ? "'/$type_enquete/'" : "'/', type, '/'";

			$code = "CONCAT(zone_corecrabe.id, '/', village.nom, $specification_type_enquete, fiche.annee::varchar, '/', LPAD(fiche.mois::varchar, 2, '0'), '/', LPAD(fiche.numero_ordre::varchar, 3, '0'))";

			$date_expedition_literalle = "TO_CHAR(date_expedition, 'DD TMMonth YYYY')";

			$this->db->select(array($code => 'code'), false);

			$this->db->select(array($date_expedition_literalle => 'date_expedition_literalle'), false);

			return $this->db->select(array(

				'fiche.id',

				'fiche.type',

				'annee',

				'mois',

				'numero_ordre',

				'date_expedition',

				'village',

				'enqueteur',

			))

				->from('fiche')

				->join('village', 'fiche.village=village.id', 'inner')

				->join('fokontany', 'village.fokontany=fokontany.id', 'inner')

				->join('commune', 'fokontany.commune=commune.id', 'inner')

				->join('district', 'commune.district=district.id', 'inner')

				->join('region', 'district.region=region.id', 'inner')

				->join('zone_corecrabe', 'region.zone_corecrabe=zone_corecrabe.id', 'inner')

				->where('fiche.id', intval($fiche))->get()->result_array()[0];

		}

		

		public function supprimer($fiche) {

			return $this->db->where('id', intval($fiche))->delete('fiche');

		}



		public function mettre_a_jour($fiche, $id) {

			return $this->db->set($fiche)->where('id', intval($id))->update('fiche');

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
	
	public function dernier_numero_ordre($fiche){

		return intval($this->db->select('numero_ordre')->from('fiche')->where($fiche)->order_by('numero_ordre', 'desc')->limit(1)->get()->result_array()[0]['numero_ordre']);
	}

	}



		

