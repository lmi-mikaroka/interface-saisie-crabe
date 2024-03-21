<?php



class EnqueteurModel extends CI_Model {



  public function __construct() {

    parent::__construct();

  }



  public function inserer($enqueteur) {

    return $this->db->set($enqueteur)->insert('enqueteur');

  }



  private function constructeur_de_requete($contraintes) {

    $orderable_columns = array('enqueteur.code', 'enqueteur.nom', 'enqueteur.type', 'structure_enqueteur.valeur', 'village.id');

    $this->db->select(array('enqueteur.id', 'enqueteur.code', 'enqueteur.nom', 'enqueteur.type', 'structure_enqueteur.valeur', 'village.nom' => 'village'))->from('enqueteur')

      ->join('enqueteur_structure_enqueteur', 'enqueteur.id=enqueteur_structure_enqueteur.enqueteur', 'left')

      ->join('structure_enqueteur', 'structure_enqueteur.id=enqueteur_structure_enqueteur.structure_enqueteur', 'left')

      ->join('village', 'enqueteur.village=village.id', 'left');

    if (isset($contraintes['search']['value']) && !empty($contraintes['search']['value'])) {

      $this->db->ilike('enqueteur.code', $contraintes['search']['value'])

        ->or_ilike('enqueteur.nom', $contraintes['search']['value'])

        ->or_ilike('enqueteur.type', $contraintes['search']['value'])

        ->or_ilike('structure_enqueteur.valeur', $contraintes['search']['value']);

    }

    $order_active = isset($contraintes['order']) && !empty($contraintes['order']);

    if ($order_active) return $this->db->order_by($orderable_columns[$contraintes['order']['0']['column']], $contraintes['order']['0']['dir']);

    else return $this->db->order_by($orderable_columns[0], 'asc');

  }



  public function datatable($constraints) {

    $query_builder = $this->constructeur_de_requete($constraints);

    if ($constraints['length'] != null && $constraints['length'] != -1)

      $query_builder->limit($constraints['length'], $constraints['start']);

    return $query_builder->get()->result_array();

  }



  public function records_total() {

    return $this->db->from('enqueteur')->count_all_results();

  }



  public function records_filtered($constraints) {

    $query_builder = $this->constructeur_de_requete($constraints);

    return $query_builder->get()->num_rows();

  }



  public function liste_par_type($type) {

    return $this->db->from('enqueteur')->where('type', $type)->order_by('code')->get()->result_array();

  }


  public function liste_par_village_enqueteur($village) {
    
    return $this->db->from('enqueteur')->where('village', $village)->order_by('code')->get()->result_array();

  }
  public function liste_par_tous() {

    return $this->db->from('enqueteur')->order_by('code')->get()->result_array();

  }

  public function liste_par_tous_village($village) {

    return $this->db->from('enqueteur')->where('village',$village)->order_by('code')->get()->result_array();

  }



  public function selection_par_id($id) {

    return $this->db->from('enqueteur')->where('id', intval($id))->get()->result_array()[0];

  }



  public function selection_structure_par_enqueteur($enqueteur) {

    $resultat = $this->db->select('structure_enqueteur')->from('enqueteur_structure_enqueteur')->where('enqueteur', intval($enqueteur))->get()->result_array();

    return count($resultat) > 0 ? $resultat[0]['structure_enqueteur'] : null;

  }



  public function supprimer($id) {

    return $this->db->where('id', intval($id))->delete('enqueteur');

  }



  public function mettre_a_jour($enqueteur, $id) {

    return $this->db->set($enqueteur)->where('id', intval($id))->update('enqueteur');

  }



  public function dernier_id() {

    return intval($this->db->select('id')->from('enqueteur')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

  }



  public function inserer_stucture_enqueteur($enqueteur, $structure) {

    return $this->db->set(array('enqueteur' => intval($enqueteur), 'structure_enqueteur' => intval($structure)))->insert('enqueteur_structure_enqueteur');

  }



  public function supprimer_structure_enqueteur($id) {

    return $this->db->where('enqueteur', intval($id))->delete('enqueteur_structure_enqueteur');

  }



  public function liste_non_utilisateurs() {

    return $this->db->from('enqueteur')

      ->where("login ISNULL", null, false)

      ->order_by('code')

      ->get()

      ->result_array();

  }



  public function selection_nom_par_id($id) {

    return $this->db->select('nom')->where('id', intval($id))->get('enqueteur')->result_array()[0]['nom'];

  }



  public function attribuer_login($enqueteur, $login) {

    return $this->db->set(array('login' => intval($login)))->where('id', intval($enqueteur))->update('enqueteur');

  }



  public function desassigner_login($enqueteur) {

    return $this->db->set('login', null)->where('id', intval($enqueteur))->update('enqueteur');

  }



  public function selectionner_par_login($id) {

    return $this->db->from('enqueteur')->where(array('login' => intval($id)))->get()->result_array();

  }



  public function liste_structure_enqueteur() {

    return $this->db->order_by('id')->get('structure_enqueteur')->result_array();

  }



  public function selection_par_village($village, $type) {

    $this->db->select(array('enqueteur.id', 'enqueteur.code', 'enqueteur.nom'));;

    $this->db->from('enqueteur')->where(array('type' => $type, 'village' => $village));

    return $this->db->get()->result_array();

  }

  public function liste_enqueteur(){
		return $this->db->select('zone_corecrabe.nom as Zone, zone_corecrabe.id as idZone,
			region.nom as Region,region.id as idRegion,
			district.nom as District, district.id as idDistrict,
			commune.nom as Commune, commune.id as idCommune,
			fokontany.nom as Fokontany, fokontany.id as idFokontany,
			village.nom as Village, village.id as idVillage,
      enqueteur.nom as Enqueteur, enqueteur.id as idEnqueteur,
      enqueteur.code as CodeEnqueteur, enqueteur.type as TypeEnqueteur')

			->from('enqueteur')

			->join("village", "village.id=enqueteur.village")

			->join("fokontany", "fokontany.id=village.fokontany")

			->join("commune", "commune.id=fokontany.commune")

			->join("district", "district.id=commune.district")

			->join("region", "region.id=district.region")

			->join("zone_corecrabe", "zone_corecrabe.id=region.zone_corecrabe")

			->order_by("enqueteur","asc")

			->get()->result_array();
	}


}

