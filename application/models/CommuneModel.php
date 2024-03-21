<?php
	
	class CommuneModel extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function inserer($commune) {
			return $this->db->set($commune)->insert('commune');
		}
		
		private function constructeur_de_requete($contraintes) {
			$orderable_columns = array('commune.id', 'district.nom');
			$this->db->select(array('commune.id', 'commune.nom', 'district.nom' => 'district'))->from('commune')
				->join('district', 'district=district.id', 'left');
			if (isset($contraintes['search']['value']) && !empty($contraintes['search']['value'])) {
				$this->db->ilike('district.nom', $contraintes['search']['value'])
					->or_ilike('commune.nom', $contraintes['search']['value']);
			}
			$order_active = isset($contraintes['order']) && !empty($contraintes['order']);
			if ($order_active) return $this->db->order_by($orderable_columns[$contraintes['order']['0']['column']], $contraintes['order']['0']['dir']);
			else return $this->db->order_by($orderable_columns[0], 'asc');
		}
		
		public function datatable($constraints) {
			$query_builder = $this->constructeur_de_requete($constraints);
			if ($constraints['length'] != null && $constraints['length'] != -1) $query_builder->limit($constraints['length'], $constraints['start']);
			return $query_builder->get()->result_array();
		}
		
		public function records_total() {
			return $this->db->from('commune')->count_all_results();
		}
		
		public function records_filtered($constraints) {
			$query_builder = $this->constructeur_de_requete($constraints);
			return $query_builder->get()->num_rows();
		}
		
		public function selection_par_id($id) {
			return $this->db->from('commune')->where('id', intval($id))->get()->result_array()[0];
		}
		
		public function supprimer($id) {
			return $this->db->where('id', intval($id))->delete('commune');
		}
		
		public function mettre_a_jour($commune, $id) {
			return $this->db->set($commune)->where('id', intval($id))->update('commune');
		}
		
		public function liste() {
			return $this->db->from('commune')->order_by('nom')->get()->result_array();
		}

		public function liste_par_zone($zone_corecrabe) {
			$this->db->select('commune.id, commune.nom, commune.district')
			->join('district', 'district=district.id', 'inner')
			->join('region', 'region=region.id');
			$this->db->where('zone_corecrabe', intval($zone_corecrabe));
			$query1= $this->db->get_compiled_select("commune");

			$this->db->select('commune.id, commune.nom, commune.district');
			$this->db->where('district is null');
			$query2= $this->db->get_compiled_select("commune");

			$query = $this->db->query($query1 . ' UNION ' . $query2.' ORDER BY nom');

			return $query->result_array();

			// return $this->db->select(array('commune.id', 'commune.nom'))

			// ->from('commune')
			
			// ->join('district', 'district=district.id', 'inner')
            
			// ->join('region', 'region=region.id')

			// ->where('zone_corecrabe', intval($zone_corecrabe))

			// ->order_by('commune.nom')

			// ->get()->result_array();

		}

		//nouveau 
		public function dernier_id() {

			return intval($this->db->select('id')->from('commune')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}
		public function existe($commune) {

			return $this->db->select('commune.id')->from('commune')
			->where('district is null')
			->where('commune.nom',$commune)->get()->num_rows() > 0;

		}
		public function recupere_par_nom( $zone_corecrabe, $commune) {

			return intval($this->db->select('commune.id')->from('commune')
			->where('district is null')
			->where('commune.nom',$commune)->get()->result_array()[0]['id']);

		}
	}
