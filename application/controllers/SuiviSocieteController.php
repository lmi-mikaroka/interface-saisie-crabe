<?php



class SuiviSocieteController extends ApplicationController {

	public function __construct() {

		parent::__construct();



		// chargement des models à utiliser

		$this->load->model('FicheSocieteModel', 'db_fiche_societe');

	}



	// public function operation_datatable($type_enquete) {

	// 	$session_enqueteur = $this->session->userdata('enqueteur');

	// 	$fiches = $this->db_fiche->datatable($_POST, $type_enquete);

	// 	$type_enquetes = array('ENQ' => array('detail' => 12, 'fiche' => 11), 'ACH' => array('detail' => 18, 'fiche' => 17), 'PEC' => array('detail' => 15, 'fiche' => 14));

	// 	$affichage = array();

	// 	foreach ($fiches as $fiche) {

	// 		$lien_detail = '';

	// 		$lien_modification = '';

	// 		$bouton_suppression = '';

	// 		foreach ($type_enquetes as $type => $identifiant) {

	// 			if ($type === $type_enquete) {

	// 				$enqueteur_proprietaire = $session_enqueteur == null || intval($session_enqueteur['id']) === intval($fiche['enqueteur_id']);

	// 				$lien_detail = $this->lib_autorisation->visualisation_autorise($identifiant['detail']) ? '<a class="btn btn-default" href="' . $this->lien_detail($type_enquete, $fiche['id']) . '">Détail </a>' : '';

	// 				$lien_modification = $this->lib_autorisation->modification_autorise($identifiant['fiche']) && $enqueteur_proprietaire ? '<a class="btn btn-default" href="' . $this->lien_modification($type_enquete, $fiche['id']) . '">Modifier </a>' : '';

	// 				$bouton_suppression = $this->lib_autorisation->suppression_autorise($identifiant['fiche']) && $enqueteur_proprietaire ? '<button class="btn btn-default delete-button"  data-target="' . $fiche['id'] . '">Supprimer</button>' : '';

	// 			}

	// 		}

	// 		$affichage[] = array(

	// 			$fiche['code'],

	// 			$fiche['zone_corecrabe_id_nom'],

	// 			$fiche['region'],

	// 			$fiche['date_expedition_literalle'] != null ? $fiche['date_expedition_literalle'] : '<i class="text">La fiche n\'est pas encore enregistrée</i>',

	// 			$fiche['enqueteur'],

	// 			'<div class="btn-group">

	// 					' . $lien_detail . '

	// 					' . $lien_modification . '

	// 					' . $bouton_suppression . '

	// 				</div>',

	// 		);

	// 	}

	// 	echo json_encode(array(

	// 		'draw' => intval($this->input->post('draw')),

	// 		'recordsTotal' => $this->db_fiche->records_total($type_enquete),

	// 		'recordsFiltered' => $this->db_fiche->records_filtered($_POST, $type_enquete),

	// 		'data' => $affichage

	// 	));

	// }



	public function operation_insertion() {

		// requisition des données du navigateur en le mettant dans leur conteneur respectifs

		$fiche_existe = $this->db_fiche_societe->existe(array(

			'societe' => $this->input->post('societe'),

			'datedebarquement' => $this->input->post('dateDebarquement'),

			'zone' => $this->input->post('zone'),

			'transport' => $this->input->post('transport')

		));

		if ($fiche_existe) {

			echo json_encode(array('success' => false, 'raison' => 'Une autre cargaison de cette société, dans la même zone, même type de transport et avec la même date de débarquement est déjà dans la base de données. Veuillez revérifier votre formulaire'));

		} else {

			$fiche = array(
				

				'societe' => $this->input->post('societe'),

                'datedebarquement' => $this->input->post('dateDebarquement'),

                'zone' => $this->input->post('zone'),

                'poidstotalcargaison' => $this->input->post('poidsTotalCargaison'),

                'transport' => $this->input->post('transport'),

                'type' => $this->input->post('type'),

                'enqueteur' => $this->input->post('enqueteur'),

				'dateexpedition' => empty($this->input->post('ficheDateExpedition')) ? null : $this->input->post('ficheDateExpedition')

			);

			$this->db->trans_begin();

            $insertion = $this->db_fiche_societe->inserer($fiche);
            
            $this->db->trans_commit();

			echo json_encode(array('success' => $insertion, 'message' => $insertion ? $this->db_fiche_societe->dernier_id() : 'erreur'));

		}

	}



	// public function operation_modification() {

	// 	// requisition des données du navigateur en le mettant dans leur conteneur respectifs

	// 	$fiche_existe = $this->db_fiche->existe(array(

	// 		'id != ' => $this->input->post('id'),

	// 		'village' => $this->input->post('village'),

	// 		'type' => $this->input->post('ficheType'),

	// 		'annee' => $this->input->post('ficheAnnee'),

	// 		'mois' => $this->input->post('ficheMois'),

	// 		'numero_ordre' => intval($this->input->post('ficheNumeroOrdre'))

	// 	));

	// 	if ($fiche_existe) {

	// 		echo json_encode(array('success' => false, 'raison' => $this->db->last_query() . '<br>Une autre fiche inscrit dans ce village et de cette période porte déjà le même numéro. Veuillez revérifier votre formulaire'));

	// 	} else {

	// 		$fiche = array(

	// 			'village' => $this->input->post('village'),

	// 			'enqueteur' => $this->input->post('enqueteur'),

	// 			'type' => $this->input->post('ficheType'),

	// 			'annee' => $this->input->post('ficheAnnee'),

	// 			'mois' => $this->input->post('ficheMois'),

	// 			'numero_ordre' => intval($this->input->post('ficheNumeroOrdre')),

	// 			'date_expedition' => empty($this->input->post('ficheDateExpedition')) ? null : $this->input->post('ficheDateExpedition')

	// 		);

	// 		$this->db->trans_begin();

	// 		$insertion = $this->db_fiche->mettre_a_jour($fiche, $this->input->post('id'));

	// 		if ($insertion) $this->db->trans_commit();

	// 		else $this->db->trans_rollback();

	// 		echo json_encode(array('success' => $insertion, 'message' => $insertion ? $this->db->last_query() : 'erreur'));

	// 	}

	// }



	// public function operation_suppression($fiche) {

	// 	$suppression = $this->db_fiche->supprimer($fiche);

	// 	echo json_encode(array('succes' => $suppression));

	// }



	// private function lien_detail($type_fiche, $cle) {

	// 	$type_enquetes_url = array(

	// 		'ENQ' => 'consultation-de-fiche-enqueteur/detail-et-action/',

	// 		'ACH' => 'consultation-de-fiche-acheteur/detail-et-action/',

	// 		'PEC' => 'consultation-de-fiche-pecheur/detail-et-action/',

	// 	);

	// 	return site_url($type_enquetes_url[strtoupper($type_fiche)] . $cle);

	// }



	// private function lien_modification($type_fiche, $cle) {

	// 	$type_enquetes_url = array(

	// 		'ENQ' => 'consultation-de-fiche-enqueteur/modification/',

	// 		'ACH' => 'consultation-de-fiche-acheteur/modification/',

	// 		'PEC' => 'consultation-de-fiche-pecheur/modification/',

	// 	);

	// 	return site_url($type_enquetes_url[strtoupper($type_fiche)] . $cle);

	// }

}

