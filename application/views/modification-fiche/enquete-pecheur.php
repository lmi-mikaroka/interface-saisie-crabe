<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <h1>Enquête de la fiche numéro "<?= $enquete['fiche']['code'] ?>"</h1>
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
            <input type="text" name="js-enquete" hidden value="<?= $enquete['id'] ?>">
            <input type="text" name="js-fiche" hidden value="<?= $enquete['fiche']['id'] ?>">
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
                          <?php for ($jours = 1; $jours <= $jours_max_du_mois; $jours++) { ?>
                            <option value="<?= $jours ?>" <?= intval($jours_enquete) === $jours ? 'selected' : '' ?>><?= $jours ?></option>
                          <?php } ?>
                        </select>
                        <div class="input-group-append"><span class="btn btn-default"><?= $mois_francais[intval($enquete['fiche']['mois']) - 1] ?> <?= $enquete['fiche']['annee'] ?></span></div>
                      </div>
                      <input type="date" name="js-date" class="form-control js-date" value="<?= $enquete['date_originale'] ?>" hidden>
                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                    </div>
                    <div class="form-group">
                      <label>Pêcheur(s) <span class="text text-red">*</span></label>
                      <div class="input-group">
                        <select class="custom-select" name="js-pecheur-partenaire">
                          <option value="seul" <?= $enquete['partenaire_peche_individu'] == 'seul' ? 'selected' : '' ?>>seul</option>
                          <option value="partenaire" <?= $enquete['partenaire_peche_individu'] == 'partenaire' ? 'selected' : '' ?>>Epoux(se)</option>
                          <option value="enfant" <?= $enquete['partenaire_peche_individu'] == 'enfant' ? 'selected' : '' ?>>enfant(s)</option>
                          <option value="amis" <?= $enquete['partenaire_peche_individu'] == 'amis' ? 'selected' : '' ?>>amis</option>
                        </select>
                        <?php
                          $champ_partenaire_pecheur_nombre = array(
                              array('valeur' => 'seul', 'min' => 1, 'max' => 1, 'lectureSeul' => true),
                              array('valeur' => 'partenaire', 'min' => 2, 'max' => 2, 'lectureSeul' => true),
                              array('valeur' => 'enfant', 'min' => 2, 'max' => 6, 'lectureSeul' => false),
                              array('valeur' => 'amis', 'min' => 2, 'max' => 11, 'lectureSeul' => false),
                          );
                          
                          $min = 0;
                          $max = 0;
                          $readonly = '';
                          
                          foreach ($champ_partenaire_pecheur_nombre as $champ) {
                            if ($champ['valeur'] === $enquete['partenaire_peche_individu']) {
                              $min = $champ['min'];
                              $max = $champ['max'];
                              $readonly = $champ['lectureSeul'] ? 'readonly' : '';
                            }
                          }
                        ?>
                        <input min="<?= $min ?>" max="<?= $max ?>" type="number" style="text-align: right;" value="<?= $enquete['partenaire_peche_nombre'] ?>"
                               class="form-control js-nombre-partenaire-de-peche" <?= $readonly ?> name="js-pecheur-nombre">
                      </div>
                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-warning">
                        <input type="checkbox" class="custom-control-input" name="js-pirogue" id="js-sortie-avec-une-pirogue" <?= intval($enquete['avec_pirogue']) ? 'checked' : '' ?>>
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
                              <option value="<?= $engin['id'] ?>" <?= $engin['id'] == $enquete['engins'][0]['engin'] ? 'selected' : '' ?>><?= $engin['nom'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <?php
                        $ENGINS = array();
                        foreach ($engins as $engin) {
                          $ENGINS[strval($engin['id'])] = array(
                              'min' => intval($engin['min']),
                              'max' => intval($engin['max'])
                          );
                        }
                      ?>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <label>Nombre <span class="text-danger">*</span></label>
                          <input min="<?= $ENGINS[strval($enquete['engins'][0]['engin'])]['min'] ?>" max="<?= $ENGINS[strval($enquete['engins'][0]['engin'])]['max'] ?>" type="number"
                                 class="form-control"
                                 name="js-engin-de-peche-nombre1" <?= intval($ENGINS[strval($enquete['engins'][0]['engin'])]['max']) === intval($ENGINS[strval($enquete['engins'][0]['engin'])]['min']) ? 'readonly' : '' ?>
                                 value="<?= $enquete['engins'][0]['nombre'] ?>">
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
                              <option value="<?= $engin['id'] ?>" <?= $engin['id'] == $enquete['engins'][1]['engin'] ? 'selected' : '' ?>><?= $engin['nom'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <label>Nombre <span class="text-danger">*</span></label>
                          <input min="<?= $ENGINS[strval($enquete['engins'][1]['engin'])]['min'] ?>" max="<?= $ENGINS[strval($enquete['engins'][1]['engin'])]['max'] ?>" type="number"
                                 class="form-control"
                                 name="js-engin-de-peche-nombre2" <?= intval($ENGINS[strval($enquete['engins'][1]['engin'])]['max']) === intval($ENGINS[strval($enquete['engins'][1]['engin'])]['min']) ? 'readonly' : '' ?>
                                 value="<?= $enquete['engins'][1]['nombre'] ?>">
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
                      <input type="number" class="form-control" name="js-consommation-crabe-poids" value="<?= $enquete['consommation_crabe_poids'] ?>">
                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                    </div>
                    <div class="form-group">
                      <label for="js-nombre-crabe-consomme">Nombre <span class="text-danger">*</span></label>
                      <input type="number" class="form-control" name="js-consommation-crabe-nombre" value="<?= $enquete['consommation_crabe_nombre'] ?>">
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
                          <input type="number" class="form-control" name="js-collecte-poids" value="<?= $enquete['collecte_poids'] ?>">
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                        </div>
                        <div class="form-group">
                          <label for="js-collecte-prix">Prix <span class="text-danger">*</span><small>(Ariary/Kg)</small></label>
                          <input type="number" class="form-control" name="js-collecte-prix" value="<?= $enquete['collecte_prix'] ?>">
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
                          <input type="number" class="form-control" name="js-marche-local-poids" value="<?= $enquete['marche_local_poids'] ?>">
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                        </div>
                        <div class="form-group">
                          <label for="js-marche-local-prix">Prix <span class="text-danger">*</span><small>(Ariary/Kg)</small></label>
                          <input type="number" class="form-control" name="js-marche-local-prix" value="<?= $enquete['marche_local_prix'] ?>">
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
          <button type="button" class="btn btn-warning float-right" id="js-bouton-enregistrer">
            Enregistrer et revenir à la liste
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
