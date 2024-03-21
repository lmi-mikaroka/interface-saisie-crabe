<?php

	

	class VillageModel extends CI_Model {

		

		public function __construct() {

			parent::__construct();

		}

		

		public function insert($district) {

			return $this->db->set($district)->insert('village');

		}

		

		private function query_builder($constraints) {

			$orderable_columns = array('village.nom', 'fokontany.nom','sous_zone','longitude','latitude');

			$this->db->select(array('village.id', 'village.nom', 'fokontany.nom' => 'fokontany','sous_zone','longitude','latitude'))->from('village')

				->join('fokontany', 'fokontany=fokontany.id', 'inner');

			if (isset($constraints['search']['value']) && !empty($constraints['search']['value'])) {

				$this->db->ilike('village.nom', $constraints['search']['value'])

					->or_ilike('sous_zone', $constraints['search']['value'])

					->or_ilike('fokontany.nom', $constraints['search']['value']);

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

			return $this->db->from('village')->count_all_results();

		}

		

		public function records_filtered($constraints) {

			$query_builder = $this->query_builder($constraints);

			return $query_builder->get()->num_rows();

		}

		

		public function liste() {

			return $this->db->from('village')->order_by('nom')->get()->result_array();

		}

		

		public function selection_par_zone_corecrabe($zone_corecrabe) {
			$type = null;
			if(isset($_GET['type'])){
				$type = $_GET['type'];
			}
			
				return $this->db->select(array('village.id', 'village.nom'))

				->from('village')

				->join('fokontany', 'fokontany=fokontany.id', 'inner')

				->join('commune', 'commune=commune.id', 'inner')

				->join('district', 'district=district.id', 'inner')

				->join('region', 'region=region.id')

				->join('enqueteur',"village.id=enqueteur.village","inner")

				->where('enqueteur.type', $type)

				->where('zone_corecrabe', intval($zone_corecrabe))

				->order_by('village.nom')
				
				->group_by('village.id')

				->get()->result_array();
			

		}

		public function selection_par_zone_corecrabe01($zone_corecrabe) {
			
				return $this->db->select(array('village.id', 'village.nom'))

				->from('village')

				->join('fokontany', 'fokontany=fokontany.id', 'inner')

				->join('commune', 'commune=commune.id', 'inner')

				->join('district', 'district=district.id', 'inner')

				->join('region', 'region=region.id')

				->where('zone_corecrabe', intval($zone_corecrabe))

				->order_by('village.nom')

				->get()->result_array();
			

		}

		public function selection_par_zone_corecrabe02($zone_corecrabe,$id_village) {
			
			return $this->db->select(array('village.id', 'village.nom'))

			->from('village')

			->join('fokontany', 'fokontany=fokontany.id', 'inner')

			->join('commune', 'commune=commune.id', 'inner')

			->join('district', 'district=district.id', 'inner')

			->join('region', 'region=region.id')

			->where('zone_corecrabe', intval($zone_corecrabe))
			->where('village.id !=',$id_village)

			->order_by('village.nom')

			->get()->result_array();
		

	}

		public function selection_par_id($id) {

			return $this->db->from('village')->where('id', intval($id))->get()->result_array()[0];

		}

		public function selection_par_id_index($id) {

			return $this->db->from('village')->where('id', intval($id))->get()->result_array();

		}

		

		public function supprimer($id) {

			return $this->db->where('id', intval($id))->delete('village');

		}

		

		public function mettre_a_jour($village, $id) {

			return $this->db->set($village)->where('id', intval($id))->update('village');

		}


		public function selection_api() {
			
			return $this->db->select('zone_corecrabe.nom as Zone, zone_corecrabe.id as idZone,
			region.nom as Region,region.id as idRegion,
			district.nom as District, district.id as idDistrict,
			commune.nom as Commune, commune.id as idCommune,
			fokontany.nom as Fokontany, fokontany.id as idFokontany,
			village.nom as Village, village.id as idVillage')

			->from('village')

			->join("fokontany", "fokontany.id=village.fokontany")

			->join("commune", "commune.id=fokontany.commune")

			->join("district", "district.id=commune.district")

			->join("region", "region.id=district.region")

			->join("zone_corecrabe", "zone_corecrabe.id=region.zone_corecrabe")

			->order_by("Village","asc")

			->get()->result_array();
		

	}

	public function liste_par_fokontany($fokontany) {

		return $this->db->select(array('village.id', 'village.nom'))

		->from('village')

		->where('fokontany', intval($fokontany))

		->order_by('village.nom')

		->get()->result_array();

	}

	public function liste_par_commune($commune) {

		return $this->db->select(array('village.id', 'village.nom'))

		->from('village')

		->join("fokontany", "fokontany.id=village.fokontany")

		->join("commune", "commune.id=fokontany.commune")

		->where('commune', intval($commune))

		->order_by('village.nom')

		->get()->result_array();

	}

	public function dernier_id() {

		return intval($this->db->select('id')->from('village')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

	}
	public function existe( $village) {

		return $this->db->select('village.id')->from('village')

		->where('fokontany is null')

		->where('village.nom',$village)->get()->num_rows() > 0;

	}
	public function recupere_par_nom( $village) {

		return intval($this->db->select('village.id')->from('village')

		->where('fokontany is null')
		
		->where('village.nom',$village)->get()->result_array()[0]['id']);

	}
	public function existe_village($fokontany, $village) {

		return $this->db->select('village.id')->from('village')

		->where('fokontany',$fokontany)

		->where('village.nom',$village)->get()->num_rows() > 0;

	}
	public function recupere_par_nom_village($fokontany, $village) {

		return intval($this->db->select('village.id')->from('village')

		->where('fokontany',$fokontany)
		
		->where('village.nom',$village)->get()->result_array()[0]['id']);

	}

	public function selection_par_zone_corecrabe_suivi($zone_corecrabe) {

		
		return $this->db->select(array('village.id', 'village.nom'))

		->from('village')

		->join('fokontany', 'fokontany=fokontany.id', 'inner')

		->join('commune', 'commune=commune.id', 'inner')

		->join('district', 'district=district.id', 'inner')

		->join('region', 'region=region.id')

		->join('enqueteur',"village.id=enqueteur.village","inner")

		->where('zone_corecrabe', intval($zone_corecrabe))

		->group_start()

		->or_where('enqueteur.type', "Acheteur")

		->or_where('enqueteur.type', "Enquêteur")

		->group_end()

		->order_by('village.nom')
		
		->group_by('village.id')

		->get()->result_array();
	

}

	}
