<?php

	

	defined('BASEPATH') or exit('No direct script access allowed');

	

	/*

			| -------------------------------------------------------------------------

			| URI ROUTING

			| -------------------------------------------------------------------------

			| This file lets you re-map URI requests to specific controller functions.

			|

			| Typically there is a one-to-one relationship between a URL string

			| and its corresponding controller class/method. The segments in a

			| URL normally follow this pattern:

			|

			|	example.com/class/method/id/

			|

			| In some instances, however, you may want to remap this relationship

			| so that a different class/function is called than the one

			| corresponding to the URL.

			|q

			| Please see the user guide for complete details:

			|

			|	https://codeigniter.com/user_guide/general/routing.html

			|

			| -------------------------------------------------------------------------

			| RESERVED ROUTES

			| -------------------------------------------------------------------------

			|

			| There are three reserved routes:

			|

			|	$route['default_controller'] = 'welcome';

			|

			| This route indicates which controller class should be loaded if the

			| URI contains no data. In the above example, the "welcome" class

			| would be loaded.

			|

			|	$route['404_override'] = 'errors/page_missing';

			|

			| This route will tell the Router which controller/method to use if those

			| provided in the URL cannot be matched to a valid route.

			|

			|	$route['translate_uri_dashes'] = FALSE;

			|

			| This is not exactly a route, but allows you to automatically route

			| controller and method names that contain dashes. '-' isn't a valid

			| class or method name character, so it requires translation.

			| When you set this option to TRUE, it will replace ALL dashes in the

			| controller and method URI segments.

			|

			| Examples:	my-controller/index	-> my_controller/index

			|		my-controller/my-method	-> my_controller/my_method

		 */



// Pour ne question de visibilitéet de homogeneité, on a changé chaque affectation en constructeor de tebleau

	$route = array(

		'default_controller' => 'BienvenueController/page_presentation',

		'404_override' => '',

		'translate_uri_dashes' => false,

		'activite/liste_tous' => 'ActiviteController/liste_tous',
         
		'connexion' => 'ConnexionController/page_connexion',

		'connexion/verification' => 'ConnexionController/operation_validation_login',

		'deconnexion' => 'ConnexionController/page_deconnexion',

		'fiche/datatable/(:any)' => 'FicheController/operation_datatable/$1',

		'edition-de-zone/village/selection-par-zone-corecrabe/(:num)' => 'VillageController/selection_par_zone_corecrabe/$1',

		'edition-de-zone/village/selection-par-zone-corecrabe01/(:num)' => 'VillageController/selection_par_zone_corecrabe01/$1',

		'fiche/supprimer/(:num)' => 'FicheController/operation_suppression/$1',

		

		'entite/enqueteur' => 'EnqueteurController/page_presentation',

		'entite/enqueteur/datatable' => 'EnqueteurController/operation_datatable',

		'entite/enqueteur/insertion' => 'EnqueteurController/operation_insertion',

		'entite/enqueteur/mise-a-jour' => 'EnqueteurController/operation_mise_a_jour',

		'entite/enqueteur/selection/(:num)' => 'EnqueteurController/operation_selection/$1',

		'entite/enqueteur/suppression/(:num)' => 'EnqueteurController/operation_suppression/$1',

		'entite/enqueteur/liste_non_utilisateur' => 'EnqueteurController/operation_selection_non_utilisateur',

		'enqueteur/selection_par_village' => 'EnqueteurController/operation_selection_par_village',

		

		'entite/pecheur' => 'PecheurController/page_presentation',

		'entite/pecheur/insertion' => 'PecheurController/operation_insertion',

		'entite/pecheur/datatable' => 'PecheurController/operation_datatable',

		'entite/pecheur/mise-a-jour' => 'PecheurController/operation_mise_a_jour',

		'entite/pecheur/selection/(:num)' => 'PecheurController/operation_selection/$1',

		'entite/pecheur/suppression/(:num)' => 'PecheurController/operation_suppression/$1',


		'entite/societe' => 'SocieteController/page_presentation',

		'entite/societe/insertion' => 'SocieteController/operation_insertion',

		'entite/societe/datatable' => 'SocieteController/operation_datatable',

		'entite/societe/mise-a-jour' => 'SocieteController/operation_mise_a_jour',

		'entite/societe/selection/(:num)' => 'SocieteController/operation_selection/$1',

		'entite/societe/suppression/(:num)' => 'SocieteController/operation_suppression/$1',

		'enqueteur/selection_par_village' => 'EnqueteurController/operation_selection_par_village',

		'enqueteur/selection_par_village_seulement' => 'EnqueteurController/operation_selection_par_village_seulement',
		

		'saisie-fiche/fiche/insertion' => 'FicheController/operation_insertion',

		'saisie-fiche/suivi-societe/insertion' => 'SuiviSocieteController/operation_insertion',

		

		'utilisateur/gestion-utilisateur' => 'GestionUtilisateurController',

		'utilisateur/datatable' => 'GestionUtilisateurController/operation_datatable',

		'utilisateur/nouvel-utilisateur/insertion' => 'GestionUtilisateurController/operation_insertion',

		'utilisateur/nouvel-utilisateur/modification' => 'GestionUtilisateurController/operation_modification',

		'utilisateur/nouvel-utilisateur/selectionner/(:num)' => 'GestionUtilisateurController/operation_selection/$1',

		'utilisateur/nouvel-utilisateur/suppression/(:num)' => 'GestionUtilisateurController/operaton_supprimer/$1',

		

		'operation/gestion-operation' => 'OperationController',

		'operation/datatable' => 'OperationController/operation_datatable',

		'operation/nouvelle-operation/insertion' => 'OperationController/operation_insertion',

		'operation/nouvelle-operation/modification' => 'OperationController/operation_modification',

		'operation/nouvelle-operation/selectionner/(:num)' => 'OperationController/operation_selection/$1',

		'operation/nouvelle-operation/suppression/(:num)' => 'OperationController/operaton_supprimer/$1',

		

		'groupe/gestion-groupe' => 'GroupeController',

		'groupe/datatable' => 'GroupeController/operation_datatable',

		'groupe/nouveau-groupe/insertion' => 'GroupeController/operation_insertion',

		'groupe/nouveau-groupe/modification' => 'GroupeController/operation_modification',

		'groupe/nouveau-groupe/selectionner/(:num)' => 'GroupeController/operation_selection/$1',

		'groupe/nouveau-groupe/suppression/(:num)' => 'GroupeController/operaton_suppression/$1',

		

		'export-csv' => 'ExportImportCSVController/page_presentation',

		'export-csv/fiche-enquete' => 'ExportImportCSVController/operation_csv_fiche_enquete',

		

		"historique" => "HistoriqueController/page_presentation",

		"historique/nettoyer" => "HistoriqueController/operation_nettoyer"

	);

	

	$edition_de_zones = array(

		'zone-corecrabe' => 'ZoneCorecrabe',

		'region' => 'Region',

		'district' => 'District',

		'commune' => 'Commune',

		'fokontany' => 'Fokontany',

		'village' => 'Village'

	);

	

	$fiche_enquetes = array(

		'fiche-enqueteur' => 'FicheEnqueteur',

		'fiche-pecheur' => 'FichePecheur',

		'fiche-acheteur' => 'FicheAcheteur',

		'fiche-recensement-mensuel' => 'FicheRecensementMensuel',

		'fiche-recensement' => 'FicheRecensement'


	);

	

	foreach ($edition_de_zones as $lien => $controller) {

		$route["edition-de-zone/$lien"] = $controller . 'Controller/page_presentation';

		$route["edition-de-zone/$lien/datatable"] = $controller . 'Controller/operation_datatable';

		$route["edition-de-zone/$lien/insertion"] = $controller . 'Controller/operation_insertion';

		$route["edition-de-zone/$lien/mise-a-jour"] = $controller . 'Controller/operation_mise_a_jour';

		$route["edition-de-zone/$lien/selection/(:num)"] = $controller . 'Controller/operation_selection/$1';

		$route["edition-de-zone/$lien/suppression/(:num)"] = $controller . 'Controller/operation_suppression/$1';

	}

	

	foreach ($fiche_enquetes as $lien => $controller) {

		$lien_tronque = substr($lien, strpos($lien, "-") + 1, strlen($lien));

		$route["exporter-csv/$lien_tronque"] = "ExportCSVController/page_presentation_$lien_tronque";

		$route["exporter-csv/$lien_tronque/generer"] = "ExportCSVController/operation_csv_fiche_$lien_tronque";

		$route["saisie-de-$lien"] = $controller . 'Controller/page_saisie_de_fiche';

		$route["saisie-de-$lien/saisie-enquete/(:num)"] = $controller . 'Controller/page_insertion_enquete/$1';

		$route["saisie-de-$lien/saisie-enquete/insertion"] = $controller . 'Controller/operation_insertion';

		$route["saisie-de-$lien/insertion"] = 'FicheController/operation_insertion';

		$route["saisie-de-$lien/modification"] = 'FicheController/operation_modification';

		$route["consultation-de-$lien"] = $controller . 'Controller/page_consultation';

		$route["consultation-de-$lien/detail-et-action/(:num)"] = $controller . 'Controller/page_detail_enquete/$1';

		$route["consultation-de-$lien/modification/(:num)"] = $controller . 'Controller/page_modification_de_fiche/$1';

		$route["modification-de-$lien/page-de-saisie/(:num)"] = $controller . 'Controller/page_de_modification/$1';

		$route["modification-de-$lien/enregistrer"] = $controller . 'Controller/operation_mise_a_jour';

		$route["consultation-de-$lien/detail-et-action/supprimer-enquete/(:num)"] = $controller . 'Controller/operation_suppression/$1';

	}

$route["suivi-societe-ajout"] = 'Societe/page_ajout_cargaison/';

// $route["suivi-societe/saisie-enquete/(:num)"] = 'Societe/page_ajout_enquete/$1';

$route["suivi-societe/saisie-enquete/insertion"] = 'Societe/insertion';

$route["suivi-societe/saisie-enquete/insertion_separe"] = 'Societe/insertion_separe';

$route["consultation-suivi-societe/detail-et-action/(:num)"] = 'Societe/page_detail_enquete/$1';

$route["consultation-de-fiche-societe"] = 'Societe/page_consultation';

$route["consultation-de-fiche-societe/liste"] = 'Societe/operation_datatable';
$route["operation-suivi-societe/suppression/(:num)"] = 'Societe/operation_suppression/$1';

$route["pecheur/detail-pecheur"] = 'PecheurController/pecheur_detail';

$route["pecheur/liste-pecheur-village-origine"] = 'PecheurController/operation_affiche_ville_origine';

//recensement 

$route["commune/liste-par-zone-corecrabe"] = 'CommuneController/liste_par_zone_corecrabe';

$route["fokontany/liste-par-commune"] = 'FokontanyController/liste_par_commune';

$route["fokontany/liste-par-zone"] = 'FokontanyController/liste_par_zone';

$route["village/liste-par-fokontany"] = 'VillageController/liste_par_fokontany';

$route["engin/liste-engin"] = 'FicheRecensementController/liste_engin';

$route["village/liste-par-commune"] = 'FicheRecensementController/liste_village_par_commune';

//controller Recensement Controller

$route["recensement-ajout"] = 'RecensementController/page_ajout_fiche/';

$route["recensement/saisie-enquete/insertion"] = 'RecensementController/insertion';

$route["recensement/saisie-enquete/insertion-manquant"] = 'RecensementController/insertion_manquant';

$route["consultation-de-recensement"] = 'RecensementController/page_consultation';

$route["consultation-de-recensement/liste"] = 'RecensementController/operation_datatable';

$route["consultation-de-recensement/detail-et-action/(:num)"] = 'RecensementController/page_detail_enquete/$1';

$route["consultation-de-recensement/modification/(:num)"] = 'RecensementController/page_modification_fiche/$1';

$route["consultation-de-recensement/modification-enquete/(:num)"] = 'RecensementController/page_modification_enquete/$1';

$route["recensement/saisie-manquant/(:num)"] = 'RecensementController/page_ajout_fiche_manquant/$1';

$route["recensement/suppression/(:num)"] = 'RecensementController/operation_suppression/$1';

$route["recensement/suppression-enquete/(:num)"] = 'RecensementController/operation_suppression_enquete/$1';

$route["recensement/modification-enquete"] = 'RecensementController/operation_mise_a_jour';

$route["recensement/modification-recensement"] = 'RecensementController/operation_mise_a_jour_fiche';

//fiche n° 6



$route["recensement-mensuel/fiche-existe"] = 'FicheRecensementMensuelController/existe_fiche';

$route["recensement-mensuel/insertion-enquete"] = 'FicheRecensementMensuelController/insertion_enquete';

$route["consultation-de-recensement-mensuel"] = 'FicheRecensementMensuelController/page_consultation';

$route["consultation-de-recensement-mensuel/liste"] = 'FicheRecensementMensuelController/operation_datatable';

$route["consultation-de-recensement-mensuel/detail-et-action/(:num)"] = 'FicheRecensementMensuelController/page_detail_enquete/$1';

$route["consultation-de-recensement-mensuel/modification/(:num)"] = 'FicheRecensementMensuelController/page_modification_fiche/$1';

$route["consultation-de-recensement-mensuel/modification-enquete/(:any)"] = 'FicheRecensementMensuelController/page_modification_enquete/$1';

$route["recensement-mensuel/suppression/(:num)"] = 'FicheRecensementMensuelController/operation_suppression/$1';

$route["recensement-mensuel/suppression-enquete/(:num)"] = 'FicheRecensementMensuelController/operation_suppression_enquete/$1';

$route["recensement-mensuel/datatable-pecheur"] = 'FicheRecensementMensuelController/datatable_insertion';

$route["recensement-mensuel/modification-recensement-mensuel"] = 'FicheRecensementMensuelController/operation_mise_a_jour_enquete';


//fin fiche n° 6


$route["import-donnees-enqueteur"] = 'ImportController/enqueteur';
$route["import-donnees-enqueteur-2"] = 'ImportController/enqueteur_2';
$route["import-donnees-acheteur"] = 'ImportController/acheteur';
$route["import-donnees-acheteur-2"] = 'ImportController/acheteur_2';
$route["import-donnees-recensement-5"] = 'ImportController/recensement_5';
$route["import-donnees-recensement-6"] = 'ImportController/recensement_6';

$route["importation-donnees-enqueteur"] = 'ImportController/import_enqueteur';
$route["importation-donnees-enqueteur-2"] = 'ImportController/import_enqueteur_2';

$route["importation-donnees-acheteur"] = 'ImportController/import_acheteur';
$route["importation-donnees-acheteur-2"] = 'ImportController/import_acheteur_2';

$route["importation-donnees-recensement-5"] = 'ImportController/import_recensement_5';
$route["importation-donnees-recensement-6"] = 'ImportController/import_recensement_6';

$route["pecheur/liste-pecheur-non-recenser"] = 'PecheurController/operation_affiche_non_recenser';

$route["pecheur/liste-pecheur-non-recenser-origine"] = 'PecheurController/operation_affiche_non_recenser_origine';

$route["recovery"] = 'ImportController/recovery';
$route["importation-recovery"] = 'ImportController/do_recovery';

$route["date-recovery"] = 'ImportController/date_recovery';
$route["importation-date-recovery"] = 'ImportController/do_date_recovery';

// $route["recensement/resident"] = 'RecensementController/ordonnes_resident';

$route["import-donnees-cordonnes"] = 'ImportController/cordonnees';
$route["importation-recovery-cordonnes"] = 'ImportController/import_cordonnes';

//fiche de presence

$route["fiche-presence/saisie_enquete"] = 'FichePresenceController/page_saisie_de_fiche';
$route["fiche-presence/pecheur-existe-presence"] = 'FichePresenceController/pecheur_existe_presence';
$route["fiche-presence/insertion-enquete"] = 'FichePresenceController/insertion';

$route["fiche-presence/consultation_fiche"] = 'FichePresenceController/consultation';
$route["fiche-presence/existe_json"] = 'FichePresenceController/enquete_existe_presence';

$route["edition-de-zone/village/selection-par-zone-corecrabe_suivi/(:num)"] = 'VillageController/selection_par_zone_corecrabe_suivi/$1';


//route organisation
$route["organisation"] = 'OrganisationController/index';
$route["organisation/datatable"] = 'OrganisationController/operation_datatable';
$route["organisation/insertion"] = 'OrganisationController/operation_insertion';
$route["organisation/selection/(:num)"] = 'OrganisationController/operation_selection/$1';
$route["organisation/modification"] = 'OrganisationController/operation_modification';
$route["organisation/suppression/(:num)"] = 'OrganisationController/operation_supprimer/$1';

//route organisation
$route["login_shiny"] = 'LoginShinyController/index';
$route["login_shiny/datatable"] = 'LoginShinyController/operation_datatable';
$route["login_shiny/insertion"] = 'LoginShinyController/operation_insertion';
$route["login_shiny/selection/(:num)"] = 'LoginShinyController/operation_selection/$1';
$route["login_shiny/modification"] = 'LoginShinyController/operation_modification';
$route["login_shiny/suppression/(:num)"] = 'LoginShinyController/operation_supprimer/$1';
