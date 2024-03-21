<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1>
                        Saisie de données suivi société de collecte
                        <span><button type="button" class="btn btn-warning" id="enregistrer">Enregistrer et terminer</button></span>
                        <span><button type="button" class="btn btn-warning" id="enregistrer-nouvelle">Enregistrer et nouvelle enquête</button></span>
                    </h1>    
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container">
            <div class="card">
                <div class="card-header  align-middle">
                    <h1 class="card-title">Informations sur la cargaison</h1>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6" style="border-right: 1px solid">
                                <div class="row" style="display:flex; align-items: center">
                                    <div class="col-md-6"><h6 style="font-weight: bold">Date de débarquement</h6></div>
                                    <div class="col-md-6 mb-1">
                                        <input name="debarquement" type="date" id="debarquement" class="form-control" required>
                                    </div>
                                    <div class="col-md-6"><h6 style="font-weight: bold">Date d'expédition</h6></div>
                                    <div class="col-md-6 mb-1">
                                        <input name="expedition" type="date" id="expedition" class="form-control" required>
                                    </div>
                                    <div class="col-md-6"><h6 style="font-weight: bold">Zone biogéographique</h6></div>
                                    <div class="col-md-6 mb-1">
                                        <select name="zone" id="zone" class="selectpicker form-control" data-live-search="true" required>
                                            <option value="">-- Sélectionner une zone --</option>
                                            <?php if (isset($zone_corecrabes) && is_array($zone_corecrabes)) foreach ($zone_corecrabes as $zone) { ?>

                                            <option value="<?= $zone['id'];?>"><?=$zone['id'];?> - <?=$zone['nom'];?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="col-md-6"><h6 style="font-weight: bold">Société</h6></div>
                                    <div class="col-md-6 mb-1">
                                        <select name="societe" id="societe" class="selectpicker form-control" data-live-search="true" required  style="width: 100%">
                                        <option value="">-- Sélectionner la société --</option>
                                        <?php if (isset($societes) && is_array($societes)) foreach ($societes as $societe) { ?>

                                            <option value="<?= $societe['id'];?>"><?=$societe['nom'];?></option>

                                        <?php } ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="border-right: 1px solid">
                                <div class="row" style="display:flex; align-items: center">
                                    <div class="col-md-6"><h6 style="font-weight: bold">Type de transport</h6></div>
                                    <div class="col-md-6 mb-1">
                                        <select name="transport" id="transport" class="selectpicker form-control" data-live-search="true" required>
                                            <option value="bateau" selected>Par Bateau</option>
                                            <option value="camion">Par Camion</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6"><h6 style="font-weight: bold">Enquêteur</h6></div>
                                    <div class="col-md-6 mb-1">
                                        <select name="enqueteur" id="enqueteur" class="selectpicker form-control" data-live-search="true" required>
                                        <option value="">-- Sélectionner l'enqueteur --</option>
                                        <?php if (isset($enqueteurs) && is_array($enqueteurs)) foreach ($enqueteurs as $enqueteur) { ?>

                                            <option value="<?= $enqueteur['id'];?>"><?=$enqueteur['code'];?> - <?=$enqueteur['nom'];?></option>

                                        <?php } ?>

                                        </select>
                                    </div>
				    <div class="col-md-6"><h6 style="font-weight: bold">Triage?</h6></div>
                                    <div class="col-md-6 mb-1">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
  					   <label class="btn btn-outline-secondary active">
    						<input type="radio" name="triage" value="false" id="nontrie" checked> Avant
  					   </label>
  					   <label class="btn btn-outline-secondary">
    						<input type="radio" name="triage" value="true" id="trie"> Après
  					   </label>
					</div>
                                    </div>
                                    <div class="col-md-6"><h6 style="font-weight: bold">Poids de la cargaison</h6></div>
                                    <div class="col-md-6 mb-1">
                                        <input name="poids" type="number" min="18" max="20000" step="0.1" class="form-control" id="poids" placeholder="en kg, [100,20000]" required>
					<small id="message" class="badge badge-sm badge-warning">****AVANT triage****</small>
                                    </div>
                                    <div class="col-md-6"><h6 style="font-weight: bold">Villages de provenance</h6></div>
                                    <div class="text-center" style="display: none;" id="actualisation-village">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <p><strong>Actualisation des villages...</strong></p>
                                    </div>
                                    <div class="col-md-6 mb-1" id="champ-insertion-village">
                                        <div class="select2-purple">

                                            <select class="form-control select2" multiple="multiple" data-dropdown-css-class="select2-purple" id="villages"  data-placeholder="Saisisez ou sélectionner les champs" name="villages[]" required>

                                            <?php foreach ($villages as $village) { ?>

                                            <option value="<?= $village['id'] ?>"><?= $village['nom'] ?></option>

                                            <?php } ?>

                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex align-items-stretch flex-column" id="ajouter-fiche">
                    <div type="button" class="card d-flex flex-fill">
                        <button type="button" class="btn btn-default btn-block" id="ajouter_fiche" style="height: 100%;" disabled>
                            <i class="fa fa-plus"></i><br>
                            <span>Nouvelle fiche</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row" id="conteneur_lot">
                
            </div>
        </div>
    </section>

</div>
