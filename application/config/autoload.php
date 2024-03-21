<?php

defined('BASEPATH') or exit('No direct script access allowed');



/*

| -------------------------------------------------------------------

| AUTO-LOADER

| -------------------------------------------------------------------

| This file specifies which systems should be loaded by default.

|

| In order to keep the framework as light-weight as possible only the

| absolute minimal resources are loaded by default. For example,

| the database is not connected to automatically since no assumption

| is made regarding whether you intend to use it.  This file lets

| you globally define which systems you would like loaded with every

| request.

|

| -------------------------------------------------------------------

| Instructions

| -------------------------------------------------------------------

|

| These are the things you can load automatically:

|

| 1. Packages

| 2. Libraries

| 3. Drivers

| 4. Helper files

| 5. Custom config files

| 6. Language files

| 7. Models

|

*/



/*

| -------------------------------------------------------------------

|  Auto-load Packages

| -------------------------------------------------------------------

| Prototype:

|

|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');

|

*/

$autoload['packages'] = array();



/*

| -------------------------------------------------------------------

|  Auto-load Libraries

| -------------------------------------------------------------------

| These are the classes located in system/libraries/ or your

| application/libraries/ directory, with the addition of the

| 'database' library, which is somewhat of a special case.

|

| Prototype:

|

|	$autoload['libraries'] = array('database', 'email', 'session');

|

| You can also supply an alternative library name to be assigned

| in the controller:

|

|	$autoload['libraries'] = array('user_agent' => 'ua');

*/

$autoload['libraries'] = array('session', 'database', 'tables');



/*

| -------------------------------------------------------------------

|  Auto-load Drivers

| -------------------------------------------------------------------

| These classes are located in system/libraries/ or in your

| application/libraries/ directory, but are also placed inside their

| own subdirectory and they extend the CI_Driver_Library class. They

| offer multiple interchangeable driver options.

|

| Prototype:

|

|	$autoload['drivers'] = array('cache');

|

| You can also supply an alternative property name to be assigned in

| the controller:

|

|	$autoload['drivers'] = array('cache' => 'cch');

|

*/

$autoload['drivers'] = array();



/*

| -------------------------------------------------------------------

|  Auto-load Helper Files

| -------------------------------------------------------------------

| Prototype:

|

|	$autoload['helper'] = array('url', 'file');

*/

$autoload['helper'] = array('url');



/*

| -------------------------------------------------------------------

|  Auto-load Config files

| -------------------------------------------------------------------

| Prototype:

|

|	$autoload['config'] = array('config1', 'config2');

|

| NOTE: This item is intended for use ONLY if you have created custom

| config files.  Otherwise, leave it blank.

|

*/

$autoload['config'] = array();



/*

| -------------------------------------------------------------------

|  Auto-load Language files

| -------------------------------------------------------------------

| Prototype:

|

|	$autoload['language'] = array('lang1', 'lang2');

|

| NOTE: Do not include the "_lang" part of your file.  For example

| "codeigniter_lang.php" would be referenced as array('codeigniter');

|

*/

$autoload['language'] = array();



/*

| -------------------------------------------------------------------

|  Auto-load Models

| -------------------------------------------------------------------

| Prototype:

|

|	$autoload['model'] = array('first_model', 'second_model');

|

| You can also supply an alternative model name to be assigned

| in the controller:

|

|	$autoload['model'] = array('first_model' => 'first');

*/

$autoload['model'] = array(

	'ZoneCorecrabeModel' => 'db_zone_corecrabe',

	'RegionModel' => 'db_region',

	'UtilisateurModel' => 'db_utilisateur',

	'DistrictModel' => 'db_district',

	'PecheurModel' => 'db_pecheur',

	'EnqueteurModel' => 'db_enqueteur',

	'EnginModel' => 'db_engin',

	'FicheEnqueteurModel' => 'db_fiche_enqueteur',

	'EchantillonModel' => 'db_echantillon',

	'CrabeModel' => 'db_crabe',

	'FicheModel' => 'db_fiche',

	'FicheAcheteurModel' => 'db_fiche_acheteur',

	'FichePecheurModel' => 'db_fiche_pecheur',

	'OperationModel' => 'db_operation',

	'GroupeModel' => 'db_groupe',

	'FokontanyModel' => 'db_fokontany',

	'VillageModel' => 'db_village',

	'CommuneModel' => 'db_commune',

	"HistoriqueModel" => "db_historique",

	'SocieteModel' => 'db_societe',
	
	'ActiviteModel'=> 'db_activite',

	'FicheRecensementModel'=>'db_fiche_recensement',

	'RecensementModel'=>'db_recensement',
	
	'EnqueteRecensementModel'=>'db_enquete_recensement',

	'RecensementMensuelModel'=>'db_recensement_mensuel',

	"SuiviPrimeModel" => "db_suivi_prime",

	"FichePresenceModel" => "db_fiche_presence",

	"OrganisationModel" => "db_organisation",

	"LoginShinyModel" => "db_login_shiny",

);

	/*

	| -------------------------------------------------------------------

	| Native Auto-load

	| -------------------------------------------------------------------

	|

	| Nothing to do with cnfig/autoload.php, this allows PHP autoload to work

	| for base controllers and some third-party libraries.

	|

	*/
