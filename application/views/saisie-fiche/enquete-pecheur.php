<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col">
          <h1>Enquête de la fiche numéro "<?= $fiche['code'] ?>"</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container">

      <!-- /.card -->
      <div class="card card-default js-formulaire-card">
        <!-- /.card-header -->
        <div class="card-body">
          <form autocomplete="off" id="js-formulaire">
            <input type="text" name="js-fiche" hidden value="<?= $fiche['id'] ?>">
            <div class="row">
              <div class="col-sm-4 d-flex align-items-stretch flex-column">
                <div class="card card-default d-flex flex-fill">
                  <div class="card-header">
                    <h3 class="card-title">
                      Dernière sortie de pêche
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="js-date">Date <span class="text text-red">*</span></label>
                      <div class="input-group">
                        <select name="js-jour" id="js-jour" class="custom-select">
                          <option value="" hidden selected></option>
                          <?php for ($jours = 1; $jours <= $jours_max_du_mois; $jours++) { ?>
                            <option value="<?= $jours ?>"><?= $jours ?></option>
                          <?php } ?>
                        </select>
                        <div class="input-group-append"><span class="btn btn-default"><?= $mois_francais[intval($fiche['mois']) - 1] ?> <?= $fiche['annee'] ?></span></div>
                      </div>
                      <input type="date" name="js-date" class="form-control js-date" value="<?= $fiche['annee'] . '-' . (substr('0' . $fiche['mois'], -2)) . '-01' ?>" hidden>
                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                    </div>
                    <div class="form-group">
                      <label>Pêcheur(s) <span class="text text-red">*</span></label>
                      <div class="input-group">
                        <select class="custom-select" name="js-pecheur-partenaire">
                          <option value="seul" selected>seul</option>
                          <option value="partenaire">Epoux(se)</option>
                          <option value="enfant">enfant(s)</option>
                          <option value="amis">amis</option>
                        </select>
                        <input min="0" type="number" style="text-align: right;" value="1" class="form-control js-nombre-partenaire-de-peche" readonly name="js-pecheur-nombre">
                      </div>
                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-warning">
                        <input type="checkbox" class="custom-control-input" name="js-pirogue" id="js-sortie-avec-une-pirogue">
                        <label class="custom-control-label" for="js-sortie-avec-une-pirogue">Pirogue</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 d-flex align-items-stretch flex-column">
                <div class="card card-default d-flex flex-fill">
                  <div class="card-header">
                    <h3 class="card-title">
                      Engins de pêche
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-7">
                        <div class="form-group">
                          <label>Premier engin <span class="text-danger">*</span></label>
                          <select class="custom-select table-cell-form material-selection" name="js-engin-de-peche-nom1">
                            <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>
                              <option value="<?= $engin['id'] ?>"><?= $engin['nom'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <label>Nombre <span class="text-danger">*</span></label>
                          <input type="number" class="form-control" name="js-engin-de-peche-nombre1" readonly="readonly" value="0">
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-7">
                        <div class="form-group">
                          <label>Deuxième engin <span class="text-danger">*</span></label>
                          <select class="custom-select table-cell-form material-selection" name="js-engin-de-peche-nom2">
                            <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>
                              <option value="<?= $engin['id'] ?>"><?= $engin['nom'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <label>Nombre <span class="text-danger">*</span></label>
                          <input type="number" class="form-control" name="js-engin-de-peche-nombre2" readonly="readonly" value="0">
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 d-flex align-items-stretch flex-column">
                <div class="card card-default d-flex flex-fill">
                  <div class="card-header">
                    <h3 class="card-title">
                      Crabes consommés <small>(Kg/nombre)</small>
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="js-poids-crabe-consomme">Poids <span class="text-danger">*</span></label>
                      <input type="number" class="form-control" name="js-consommation-crabe-poids">
                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                    </div>
                    <div class="form-group">
                      <label for="js-nombre-crabe-consomme">Nombre <span class="text-danger">*</span></label>
                      <input type="number" class="form-control" name="js-consommation-crabe-nombre">
                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8 offset-sm-2">
                <h4 class="text">Crabes vendus</h4>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="card card-default">
                      <div class="card-header">
                        <h3 class="card-title">Destiné à la Collecte</h3>
                      </div>
                      <div class="card-body">
                        <div class="form-group">
                          <label for="js-collecte-poids">Poids <span class="text-danger">*</span><small>(Kg)</small></label>
                          <input type="number" class="form-control" name="js-collecte-poids">
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                        </div>
                        <div class="form-group">
                          <label for="js-collecte-prix">Prix <span class="text-danger">*</span><small>(Ariary/Kg)</small></label>
                          <input type="number" class="form-control" name="js-collecte-prix">
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card card-default">
                      <div class="card-header">
                        <h3 class="card-title">Destiné au Marché local</h3>
                      </div>
                      <div class="card-body">
                        <div class="form-group">
                          <label for="js-marche-local-poids">Poids <span class="text-danger">*</span><small>(Kg)</small></label>
                          <input type="number" class="form-control" name="js-marche-local-poids">
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                        </div>
                        <div class="form-group">
                          <label for="js-marche-local-prix">Prix <span class="text-danger">*</span><small>(Ariary/Kg)</small></label>
                          <input type="number" class="form-control" name="js-marche-local-prix">
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="alert alert-danger alert-dismissible js-alerte-information-incorrecte" style="display: none;">
                  <h5><i class="icon fas fa-ban"></i> Information incorrecte!</h5>
                  <ul class="js-alerte-information-incorrecte-conteneur">
                  </ul>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="card-footer clearfix">
          <?php if (intval($max_enquete) > intval($enquete_enregistrees) + 1) { ?>
            <button type="button" class="btn btn-warning" id="js-bouton-enregistrer-et-nouveau">
              Enregistrer et nouvelle Enquête
            </button>
          <?php } ?>
          <button type="button" class="btn btn-warning float-right" id="js-bouton-enregistrer">
            Enregistrer et cloturer la fiche
          </button>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
