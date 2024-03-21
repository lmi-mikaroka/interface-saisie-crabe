<?php

	

	class Societe extends ApplicationController {

		public function __construct() {

            parent::__construct();

			
            // chargement des models à utiliser

		    $this->load->model('FicheSocieteModel', 'db_fiche_societe');
		    $this->load->model('SocieteModel', 'db_societe');
			// Chargement des composants statiques de bases (header, footer)

			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);

			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
        }


    public function page_ajout_cargaison(){
        // chargement de la vue d'insertion et modification dans une variable

            $this->root_states['title'] = 'Fiches Suivi Société';
            
            // redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
		'pages/saisie-fiche/societe.js',
		'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js'
            );
            
            $current_context_state = array(

                'zone_corecrabes' => $this->db_zone_corecrabe->liste(),
                'villages' => $this->db_village->liste(),
				'societes' => $this->db_societe->liste(),
                'enqueteurs' => $this->db_enqueteur->liste_par_type('Enquêteur'),
				'droit_de_creation' => $this->lib_autorisation->creation_autorise(8)

			);
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif

            $etat_menu = array(

                'active_route' => 'saisie-de-fiche-societe'

            );
            // rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

            $this->application_component['context_component'] = $this->load->view('saisie-fiche/societe.php', $current_context_state, true);
            // affichage du composant dans la vue de base

            $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
            if ($this->lib_autorisation->visualisation_autorise(37))

				$this->load->view('index.php', $this->root_states, false);
    }


    public function insertion(){
        $enqueteur = null;
        if($this->input->post('enqueteur')!=""){
            $enqueteur = $this->input->post('enqueteur');
        }
            $data = array(
                'datedebarquement'=> $this->input->post('datedebarquement'),
                'dateexpedition'=> $this->input->post('dateexpedition'),
                'zone'=> $this->input->post('zone'),
                'societe'=> $this->input->post('societe'),
                'transport'=> $this->input->post('transport'),
                'enqueteur'=> $enqueteur,
		'trie'=> $this->input->post('trie'),
                'poidstotalcargaison'=> $this->input->post('poidstotalcargaison'),
                'provenance'=> $this->input->post('provenance'),
                'lots'=> $this->input->post('lots')
            );


            // requisition des données du navigateur en le mettant dans leur conteneur respectifs

		$fiche_existe = $this->db_fiche_societe->existe(array(

			'societe' => $data['societe'],

			'datedebarquement' => $data['datedebarquement'],

			'zone' => $data['zone'],

			'transport' => $data['transport']

		));

		if (false) {

			echo json_encode(array('result' => false,'title'=>'Erreur de fiche en double', 'message' => 'Une autre cargaison de cette société, dans la même zone, même type de transport et avec la même date de débarquement est déjà dans la base de données. Veuillez revérifier votre formulaire'));

		} else {
            

			$fiche = array(
				

				'societe' => $data['societe'],

                'datedebarquement' => $data['datedebarquement'],

                'zone' => $data['zone'],

                'poidstotalcargaison' => $data['poidstotalcargaison'],

                'transport' => $data['transport'],

                'enqueteur' => $data['enqueteur'],
		'trie' => $data['trie'],

				'dateexpedition' => empty($data['dateexpedition']) ? null : $data['dateexpedition']

			);

            $insertion = $this->db_fiche_societe->inserer($fiche);

            if($insertion){
                $cargaison = $this->db_fiche_societe->dernier_id();
                $data2 = array(
                    'cargaison'=> $cargaison,
                    'provenance'=> $data['provenance'],
                    'lots'=> $data['lots']
                );
                foreach($data2['lots'] as $key => $lot){
                    $village_id = null;
                    if($lot['village']['id']!=""){
                        $village_id = $lot['village']['id'];
                    }
                    $data_fiche = array(
                        'cargaison'=>$data2['cargaison'],
                        'village'=>$village_id,
                        'poidstotal'=>$lot['poids'],
                        'numfiche'=>$key+1,
                    );
                    $insert_lot = $this->db_fiche_societe->insert_lot($data_fiche);
                    if($insert_lot){
                        $id_last_lot = $this->db_fiche_societe->get_last_lot($data_fiche);
                        if($lot['bacs']){
                            foreach($lot['bacs'] as $bacs){
                                $d = array(
                                    'lot'=>$id_last_lot,
                                    'type'=>$bacs['type'],
                                    'poidsbac'=>$bacs['poidsbac'],
                                );
                                $this->db_fiche_societe->add_bac($d);
                            }
                        }
                        if($lot['crabes']){
                            foreach($lot['crabes'] as $crabe){
                                $taille = null;
                                if($crabe['checked']!="checked"){
                                    $taille = $crabe['taille'];
                                }
                                $dCrabe = array(
                                    'lot'=>$id_last_lot,
                                    'taille'=>$taille,
                                    'sexe'=>$crabe['sexe'],
                                );
                                $this->db_fiche_societe->add_crabe($dCrabe);
                            }
                        }
                    }else echo json_encode(array('result' => false,'title'=>'Erreur non identifié', 'message' => 'Une erreur de serveur a été observée, veuillez vous réferrer à l\'administrateur de la base'));
                }
                foreach($data['provenance'] as $provenance){
                    $d = array(
                        'cargaison'=>$cargaison,
                        'village'=>$provenance['id']
                    );
                    $this->db_fiche_societe->add_provenance($d);
                }
                $archive = $this->db_fiche_societe->selection_par_id($cargaison);
                $numCargaison = $archive['datedebarquement'].'/'.$archive['nomSociete'].'/'.$archive['nomZone'].'/'.$archive['transport'];
                $this->db_historique->archiver("Insertion", "Insertion d'une nouvelle fiche suivi Société: ".$numCargaison);
                echo json_encode(array('result' => TRUE, 'message' => 'Les données sont ajoutées avec succès', 'title' => 'Succès', 'cargaison' => $cargaison));
            }else echo json_encode(array('result' => false,'title'=>'Erreur non identifié', 'message' => 'Une erreur de serveur a été observée, veuillez vous réferrer à l\'administrateur de la base'));

        }
        
    }

    // public function insertion_separe(){


            // 
            // 
            
    //     }
    // }

    public function page_detail_enquete($fiche){
        $cargaison = $this->db_fiche_societe->selection_par_id($fiche);
        $lots = $this->db_fiche_societe->get_lots($fiche);
        $numCargaison = $cargaison['datedebarquement'].'/'.$cargaison['nomSociete'].'/'.$cargaison['nomZone'].'/'.$cargaison['transport'];
        $pro = $this->db_fiche_societe->get_provenances($fiche);

        foreach($lots as $iteration_lot => $lot){
            $lots[$iteration_lot]["bacs"] = $this->db_fiche_societe->get_bacs($lot["id"]);
            $lots[$iteration_lot]["crabes"] = $this->db_fiche_societe->get_crabes($lot["id"]);
        }

			$this->root_states['title'] = 'Fiche Suivi Société N°:' . $cargaison['datedebarquement'].'/'.$cargaison['nomSociete'].'/'.$cargaison['nomZone'].'/'.$cargaison['transport'];

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				// 'pages/consultation-fiche/enquete-detail.js'

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-societe'

			);

			

			// $session_enqueteur = $this->session->userdata('enqueteur');

			$context_state = array(

				'cargaison' => $cargaison,

                'lots' => $lots,
                
                'num' => $numCargaison,

                'pro' => $pro,

				// 'max_enquete' => self::FICHE_MAX,

				'autorisation_creation' => $this->lib_autorisation->creation_autorise(39),

				'autorisation_modification' => $this->lib_autorisation->modification_autorise(39),

				'autorisation_suppression' => $this->lib_autorisation->suppression_autorise(39),

				// 'enqueteur_responsable' => ($session_enqueteur == null || intval($session_enqueteur['id']) === intval($fiche_bd['enqueteur']))

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('consultation-fiche/societe-detail.php', $context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

			$this->db_historique->archiver("Visite", "Consultation de la fiche de suivi société de code: ".$numCargaison);
    }

    public function page_consultation(){
        $this->root_states['title'] = 'Consultation des enquetes';

        // redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/consultation-fiche/societe.js'

            );
            // précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-societe'

            );
            
            // rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

            $this->application_component['context_component'] = $this->load->view('consultation-fiche/societe.php', null, true);
            
            // affichage du composant dans la vue de base

            $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
            // importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);
    }


    public function operation_datatable() {
        // requisition des données à afficher avec les contraintes

			$data_query = $this->db_fiche_societe->datatable($_POST);

			// chargement des données formatées

			$data = array();

			foreach ($data_query as $query_result) {

                $bouton_details = $this->lib_autorisation->modification_autorise(21) ? '<a class="btn btn-default update-button" href="'.base_url("consultation-suivi-societe/detail-et-action/").$query_result['id'].'">Details</a>' : '';

                $bouton_modification = $this->lib_autorisation->modification_autorise(21) ? '<button class="btn btn-default update-button" data-target="#update-modal" id="update-' . $query_result['id'] . '">Modifier</button>' : '';

				$bouton_suppression = $this->lib_autorisation->suppression_autorise(21) ? '<button class="btn btn-default delete-button"  data-target="' . $query_result['id'] . '">Supprimer</button>' : '';

				$data[] = array(

					$query_result['code'],

					$query_result['poids'],
					$query_result['expedition'],
					$query_result['enqueteur'],

                    '<div class="btn-group">
                        ' . $bouton_details . '

						' . $bouton_modification . '

						' . $bouton_suppression . '

					</div>',

				);

			}

			echo json_encode(array(

				'draw' => intval($this->input->post('draw')),

				'recordsTotal' => $this->db_fiche_societe->records_total(),

				'recordsFiltered' => $this->db_fiche_societe->records_filtered($_POST),

				'data' => $data

			));
		
    }
    
    public function operation_suppression($id){
        echo json_encode($this->db_fiche_societe->supprimer($id));
    }

}
