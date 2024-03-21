<?php
	
	class FokontanyModel extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function inserer($district) {
			return $this->db->set($district)->insert('fokontany');
		}
		
		private function query_builder($constraints) {
			$orderable_columns = array('fokontany.nom', 'commune.nom');
			$this->db->select(array('fokontany.id', 'fokontany.nom', 'commune.nom' => 'commune'))->from('fokontany')
				->join('commune', 'commune=commune.id', 'inner');
			if (isset($constraints['search']['value']) && !empty($constraints['search']['value'])) {
				$this->db->ilike('fokontany.nom', $constraints['search']['value'])
					->or_ilike('commune.nom', $constraints['search']['value']);
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
			return $this->db->from('fokontany')->count_all_results();
		}
		
		public function records_filtered($constraints) {
			$query_builder = $this->query_builder($constraints);
			return $query_builder->get()->num_rows();
		}
		
		public function liste() {
			return $this->db->from('fokontany')->get()->result_array();
		}
		
		public function selection_par_id($id) {
			return $this->db->from('fokontany')->where('id', intval($id))->get()->result_array()[0];
		}
		
		public function supprimer($id) {
			return $this->db->where('id', intval($id))->delete('fokontany');
		}
		
		public function mettre_a_jour($fokontany, $id) {
			return $this->db->set($fokontany)->where('id', intval($id))->update('fokontany');
		}

		public function liste_par_commune($commune) {

			return $this->db->select(array('fokontany.id', 'fokontany.nom'))

			->from('fokontany')

			->where('commune', intval($commune))

			->order_by('fokontany.nom')

			->get()->result_array();

		}

		public function dernier_id() {

			return intval($this->db->select('id')->from('fokontany')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}
		public function existe( $commune, $fokontany) {

			return $this->db->select('fokontany.id')->from('fokontany')
			->join('commune', 'commune=commune.id', 'inner')
			->where('commune', intval($commune))
			->where('fokontany.nom',$fokontany)->get()->num_rows() > 0;

		}
		public function recupere_par_nom( $commune, $fokontany) {

			return intval($this->db->select('fokontany.id')->from('fokontany')
			->join('commune', 'commune=commune.id', 'inner')
			->where('commune', intval($commune))
			->where('fokontany.nom',$fokontany)->get()->result_array()[0]['id']);

		}

		public function liste_par_zone($zone) {

			return $this->db->select(array('fokontany.id', 'fokontany.nom'))

			->from('fokontany')

			->join('commune', 'commune=commune.id', 'inner')

			->join('district', 'district=district.id')

			->join('region', 'region=region.id')

			->where('zone_corecrabe', intval($zone))

			->order_by('fokontany.nom')

			->get()->result_array();

		}
	}
