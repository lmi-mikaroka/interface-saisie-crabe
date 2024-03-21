<?php
class ImportModel extends CI_Model {

	public function __construct() {

		parent::__construct();

    }

    public function check_doublon_enqueteur($data_doublon){
        return $this->db->from('N_1_avec_residence')
        ->where($data_doublon)
        ->get()->result_array();
    }
    public function check_doublon_acheteur($data_doublon){
        return $this->db->from('N_3_avec_residence')
        ->where($data_doublon)
        ->get()->result_array();
    }

    public function creer_pecheur($data_pecheur){
        return $this->db->insert('pecheur',$data_pecheur);
    }

    public function insert_activite_recensement($data_act){
        return $this->db->insert('activite_enquete_recensement',$data_act);
    }
    public function insert_activite_recensement_mensuel($data_act){
        return $this->db->insert('activite_recensement_mensuel',$data_act);
    }
    public function insert_recensement_mensuel($recensement){
        return $this->db->insert('recensement_mensuel',$recensement);
    }

    public function get_id_act($act){
        return $this->db->from('activite')
        ->like('nom',$act)
        ->order_by('id')->limit(1)
        ->get()->result_array();
    }

    public function get_recensement_mensuel($recensement){
        return $this->db->from('recensement_mensuel')
        ->where($recensement)
        ->order_by('id')->limit(1)
        ->get()->result_array();
    }
    public function get_enquete_recensement_mensuel($recensement){
        return $this->db->from('enquete_recensement_mensuel')
        ->where($recensement)
        ->order_by('id')->limit(1)
        ->get()->result_array();
    }

    public function insert_engin_recensement($data_engin){
        return $this->db->insert('engin_enquete_recensement',$data_engin);
    }
    public function insert_enquete_recensement($data_enquete){
        return $this->db->insert('enquete_recensement',$data_enquete);
    }
    public function insert_enquete_recensement_mensuel($enquete){
        return $this->db->insert('enquete_recensement_mensuel',$enquete);
    }

    public function get_enquete_id($data_enquete){
        return $this->db->from('enquete_recensement')
        ->where($data_enquete)
        ->get()->result_array();
    }

    public function check_fiche_recensement($data_fiche){
	return $this->db->from('recensement')
		->where($data_fiche)
		->get()->result_array();
    }

    public function pecheur_existe($data){
	return $this->db->from('pecheur')
		->where($data)
		->get()->result_array();
}

    public function creer_fiche_recensement($data_fiche){
	return $this->db->insert('recensement',$data_fiche);
    }
    public function check_nombre_enquete_recensement($id){
	return $this->db->from('enquete_recensement')
		->where('recensement',$id)
		->get()->result_array();
    }
    public function get_village_id($nom){
        return $this->db->from('village')->where('nom', $nom)->get()->result_array()[0];
    }
    public function get_enqueteur_id($code,$village){
        return $this->db->from('enqueteur')->where('code', strval($code))->where('village',$village)->get()->result_array()[0];
    }
    public function get_sortie($data_sortie,$type){
        if($type == 'ENQ'){
            return $this->db->from('sortie_de_peche_enqueteur')
            ->where($data_sortie)
            ->get()->result_array();
        }else if($type == 'ACH'){
            return $this->db->from('sortie_de_peche_acheteur')
            ->where($data_sortie)
            ->get()->result_array();
        }
    }

    public function insert_engin($data,$type){
        if($type == 'ENQ'){
            return $this->db->insert('engin_sortie_de_peche_enqueteur', $data);
        }else if($type == 'ACH'){
            return $this->db->insert('engin_sortie_de_peche_acheteur', $data);
        }
    }

    public function get_engin_id($engin){
        return $this->db->from('engin')
        ->like('nom',$engin)
        ->order_by('id')->limit(1)
        ->get()->result_array();
    }
    public function check_village($nom){
        return $this->db->from('village')->where('nom', $nom)->get()->result_array();
    }
    public function check_enqueteur($code, $village){
        return $this->db->from('enqueteur')->where('code', strval($code))->where('village',$village)->get()->result_array();
    }

    public function check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$num_fiche){
        return $this->db->from('fiche')
        ->where('type', $type)
        ->where('annee',$annee)
        ->where('mois',$mois)
        ->where('numero_ordre',$num_fiche)
        ->where('village',$village_id)
        ->where('enqueteur',$enqueteur_id)
        ->get()->result_array();
    }
    public function get_id_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$num_fiche){
        return $this->db->from('fiche')
        ->where('type', $type)
        ->where('annee',$annee)
        ->where('mois',$mois)
        ->where('numero_ordre',$num_fiche)
        ->where('village',$village_id)
        ->where('enqueteur',$enqueteur_id)
        ->get()->result_array()[0];
    }

    public function get_id_enquete($data,$type){
        if($type == 'ENQ'){
            return $this->db->from('fiche_enqueteur')
            ->where($data)
            ->get()->result_array();
        }else if($type == 'ACH'){
            return $this->db->from('fiche_acheteur')
            ->where($data)
            ->get()->result_array();
        }
        
    }
    public function creer_fiche($data){
        return $this->db->insert('fiche', $data);
    }

    public function inserer_sortie($data,$type){
        if($type == 'ENQ'){
            return $this->db->insert('sortie_de_peche_enqueteur', $data);
        }else if($type == 'ACH'){
            return $this->db->insert('sortie_de_peche_acheteur', $data);
        }
    }
    public function inserer_echantillon($data_echantillon){
        return $this->db->insert('echantillon', $data_echantillon);
    }
    public function insert_crabe($data_crabe){
        return $this->db->insert('crabe', $data_crabe);
    }

    public function creer_village($village_origine){
        return $this->db->insert('village', $village_origine);
    }

    public function get_id_echantillon($fiche_enqueteur){
        return $this->db->from('echantillon')
        ->where('fiche_enqueteur',$fiche_enqueteur)
        ->get()->result_array();
    }
    public function add_enquete($data,$type){
        if($type == 'ENQ'){
            return $this->db->insert('fiche_enqueteur', $data);
        }else if($type == 'ACH'){
            return $this->db->insert('fiche_acheteur', $data);
        }
    }

    public function check_enquete($id,$type){
        if($type == 'ENQ'){
            return $this->db->from('fiche_enqueteur')->where('fiche', $id)->get()->result_array();
        }else if($type == 'ACH'){
            return $this->db->from('fiche_acheteur')->where('fiche', $id)->get()->result_array();
        }
    }

    public function check_pecheur($pecheur,$village){
        return $this->db->from('pecheur')->where('nom', $pecheur)->where('village',$village)->get()->result_array();
    }

    public function get_enquete($id,$date_enquete,$capture_poids,$pecheur_id){
        return $this->db->from('fiche_enqueteur')
        ->where('pecheur',$pecheur_id)
        ->where('date',$date_enquete)
        ->where('fiche',$id)
        ->where('capture_poids',$capture_poids)
        ->get()->result_array();
    }
    public function get_enquete_ach($id,$date_enquete,$pecheur_id){
        return $this->db->from('fiche_acheteur')
        ->where('pecheur',$pecheur_id)
        ->where('date',$date_enquete)
        ->where('fiche',$id)
        ->get()->result_array();
    }

public function update_pecheur($data_pecheur, $pecheur_id){
    return $this->db
        ->set($data_pecheur)
        ->where('id', $pecheur_id)
        ->update('pecheur');
}

public function check($id,$date){
        return $this->db->from('sortie_de_peche_acheteur')
        ->where('date', $date)
        ->where('fiche_acheteur', $id)
        ->get()->result_array();
    }
    public function do_recovery($id,$date,$nb,$prg){
        return $this->db->set('nombre',$nb)
        ->set('pirogue',$prg)
        ->where('date', $date)
        ->where('fiche_acheteur', $id)
        ->update('sortie_de_peche_acheteur');
    }


public function check_fiche_acheteur($id){
        return $this->db->from('fiche_acheteur')
        ->where('id', $id)
        ->get()->result_array();
    }

public function get_fiche_date($id){
        return $this->db->from('fiche_acheteur')
        ->where('id', $id)
        ->get()->result_array()[0];
    }
public function get_sortie_acheteur($id){
        return $this->db->from('sortie_de_peche_acheteur')
        ->where('fiche_acheteur', $id)
        ->order_by('id')
        ->get()->result_array();
    }
public function update_date($id, $date_updated){
        return $this->db->set('date', $date_updated)
        ->where('id', $id)
        ->update('sortie_de_peche_acheteur');
    }
}

