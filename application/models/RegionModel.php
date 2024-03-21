<?php
	
	class RegionModel extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function inserer($region) {
			return $this->db->set($region)->insert('region');
		}
		
		private function query_builder($constraints) {
			$orderable_columns = array('region.nom', 'zone_corecrabe.nom');
			$this->db->select(array(
				'region.id',
				'region.nom',
				'zone_corecrabe.nom' => 'zone_corecrabe'
			));
			$this->db->from('region')->join('zone_corecrabe', 'zone_corecrabe=zone_corecrabe.id', 'inner');
			if (isset($constraints['search']['value']) && !empty($constraints['search']['value'])) {
				$this->db->ilike('region.nom', $constraints['search']['value'])
					->or_ilike('zone_corecrabe.nom', $constraints['search']['value']);
			}
			if ((isset($constraints['order']) && !empty($constraints['order']))) return $this->db->order_by($orderable_columns[$constraints['order']['0']['column']], $constraints['order']['0']['dir']);
			else return $this->db->order_by($orderable_columns[0], 'asc');
		}
		
		public function datatable($constraints) {
			$query_builder = $this->query_builder($constraints);
			if ($constraints['length'] != null && $constraints['length'] != -1) $this->db->limit($constraints['length'], $constraints['start']);
			return $query_builder->get()->result_array();
		}
		
		public function records_total() {
			return $this->db->from('region')->count_all_results();
		}
		
		public function records_filtered($constraints) {
			$query_builder = $this->query_builder($constraints);
			return $query_builder->get()->num_rows();
		}
		
		public function liste() {
			return $this->db->from('region')->order_by('nom')->get()->result_array();
		}
		
		public function mettre_a_jour($region, $id) {
			return $this->db->where('id', intval($id))->set($region)->update('region');
		}
		
		public function selection_par_id($id) {
			return $this->db->from('region')->where('id', intval($id))->get()->result_array()[0];
		}
		
		public function supprimer($id) {
			return $this->db->where('id', intval($id))->delete('region');
		}
	}
