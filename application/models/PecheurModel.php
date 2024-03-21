<?php



class PecheurModel extends CI_Model {



	public function __construct() {

		parent::__construct();

	}



	public function inserer($pecheur) {

		return $this->db->set($pecheur)->insert('pecheur');

	}

	public function lastPecheur($pecheur) {
		return intval($this->db->select('id')->from('pecheur')->where($pecheur)->limit(1)->get()->result_array()[0]['id']);
	}



	private function query_builder($constraints) {

		$orderable_columns = array('pecheur.nom', 'village.nom');

		$this->db->select(array('pecheur.id', 'pecheur.nom', 'village.nom' => 'village'))->from('pecheur')

			->join('village', 'village=village.id', 'inner');

		if (isset($constraints['search']['value']) && !empty($constraints['search']['value'])) {

			$this->db->ilike('pecheur.nom', $constraints['search']['value'])

				->or_ilike('village.nom', $constraints['search']['value']);

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

		return $this->db->from('pecheur')->count_all_results();

	}



	public function records_filtered($constraints) {

		$query_builder = $this->query_builder($constraints);

		return $query_builder->get()->num_rows();

	}



	public function selection_par_id($id) {

		return $this->db->from('pecheur')->where('id', intval($id))->get()->result_array()[0];

	}



	public function supprimer($id) {

		return $this->db->where('id', intval($id))->delete('pecheur');

	}



	public function mettre_a_jour($pecheur, $id) {

		return $this->db->set($pecheur)->where('id', intval($id))->update('pecheur');

	}



	public function liste() {

		return $this->db->from('pecheur')->order_by('nom', 'asc')->get()->result_array();

	}

	public function liste_pecheur(){
		return $this->db->select('zone_corecrabe.nom as Zone, zone_corecrabe.id as idZone,
			region.nom as Region,region.id as idRegion,
			district.nom as District, district.id as idDistrict,
			commune.nom as Commune, commune.id as idCommune,
			fokontany.nom as Fokontany, fokontany.id as idFokontany,
			village.nom as Village, village.id as idVillage,
			pecheur.nom as Pecheur, pecheur.id as idPecheur,
			pecheur.sexe,
			pecheur.datenais')

			->from('pecheur')

			->join("village", "village.id=pecheur.village")

			->join("fokontany", "fokontany.id=village.fokontany")

			->join("commune", "commune.id=fokontany.commune")

			->join("district", "district.id=commune.district")

			->join("region", "region.id=district.region")

			->join("zone_corecrabe", "zone_corecrabe.id=region.zone_corecrabe")

			->order_by("Pecheur","asc")

			->get()->result_array();
	}

	public function liste_par_village($village) {

		return $this->db->from('pecheur')->where('village', intval($village))->order_by('nom')->get()->result_array();

	}

	public function liste_par_village_origine($village) {

		return $this->db->from('pecheur')->where('village', intval($village))->group_start()->or_where('village_origine',$village)->or_where('village_origine',Null)->group_end()->order_by('nom')->get()->result_array();

	}
	public function dernier_id() {

		return intval($this->db->select('id')->from('pecheur')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

	}
	public function existe_nom( $nom,$village) {

		return $this->db->select('pecheur.id')->from('pecheur')
		->where('pecheur.village',$village)
		->where('pecheur.nom',$nom)->get()->num_rows() > 0;
		
	}
	public function recupere_par_nom( $nom , $village) {
		return intval($this->db->select('pecheur.id')->from('pecheur')
		->where('pecheur.village',$village)
		->where('pecheur.nom',$nom)->get()->result_array()[0]['id']);

	}

	public function existe_nom_origine( $nom,$village,$origine) {

		return $this->db->select('pecheur.id')->from('pecheur')
		// ->where('pecheur.village',$village)
		->where('pecheur.nom',$nom)
		->group_start()
		->or_where('village',$village)
		->or_where('village',$origine)
		->group_end()
		->get()->num_rows() > 0;
		
	}
	public function recupere_par_nom_origine( $nom , $village,$origine) {
		return intval($this->db->select('pecheur.id')->from('pecheur')
		// ->where('pecheur.village',$village)
		->where('pecheur.nom',$nom)
		->group_start()
		->or_where('village',$village)
		->or_where('village',$origine)
		->group_end()
		->get()->result_array()[0]['id']);

	}

	public function liste_par_village_origine_non_recenser($village) {
		$this->db->select('id,pecheur.nom,pecheur.datenais,pecheur.sexe');
		$this->db->from('pecheur')->where('village', intval($village))->group_start()->or_where('village_origine',intval($village))->or_where('village_origine',Null)->group_end();
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select('pecheur.id,pecheur.nom,pecheur.datenais,pecheur.sexe');
		$this->db->from('enquete_recensement')->join("pecheur", "pecheur=pecheur.id");
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1 . ' EXCEPT ' . $query2 .'order by nom asc');
		return $query->result_array();

	}

	public function liste_par_village_origine_non_recenser_origine($village,$origine) {

		$this->db->select('id,pecheur.nom,pecheur.datenais,pecheur.sexe');
		$this->db->from('pecheur')->where('village', intval($village))->group_start()->or_where('village_origine',intval($village))->or_where('village_origine',Null)->group_end();

		$query = $this->db->get_compiled_select();
		$this->db->select('id,pecheur.nom,pecheur.datenais,pecheur.sexe');
		$this->db->from('pecheur')->where('village', intval($origine))->group_start()->or_where('village_origine',intval($origine))->or_where('village_origine',Null)->group_end();
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select('pecheur.id,pecheur.nom,pecheur.datenais,pecheur.sexe');
		$this->db->from('enquete_recensement')->join("pecheur", "pecheur=pecheur.id");
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query .'UNION '.$query1 . ' EXCEPT ' . $query2 .'order by nom asc');
		return $query->result_array();

	}

}

