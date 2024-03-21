<?php
	
	class DistrictModel extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function inserer($district) {
			return $this->db->set($district)->insert('district');
		}
		
		private function constructeur_de_requete($contraintes) {
			$orderable_columns = array('district.nom', 'region.nom');
			$this->db->select(array('district.id', 'district.nom', 'region.nom' => 'region'))->from('district')
				->join('region', 'region=region.id', 'inner');
			if (isset($contraintes['search']['value']) && !empty($contraintes['search']['value'])) {
				$this->db->ilike('region.nom', $contraintes['search']['value'])
					->or_ilike('district.nom', $contraintes['search']['value']);
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
			return $this->db->from('district')->count_all_results();
		}
		
		public function records_filtered($constraints) {
			$query_builder = $this->constructeur_de_requete($constraints);
			return $query_builder->get()->num_rows();
		}
		
		public function liste() {
			return $this->db->from('district')->get()->result_array();
		}
		
		public function selection_par_id($id) {
			return $this->db->from('district')->where('id', intval($id))->get()->result_array()[0];
		}
		
		public function supprimer($id) {
			return $this->db->where('id', intval($id))->delete('district');
		}
		
		public function mettre_a_jour($district, $id) {
			return $this->db->set($district)->where('id', intval($id))->update('district');
		}
	}
