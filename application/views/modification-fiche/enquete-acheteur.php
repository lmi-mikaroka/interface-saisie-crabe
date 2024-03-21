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
          <form autocomplete="off" class="js-formulaire">
            <input type="text" name="js-enquete" hidden value="<?= $enquete['id'] ?>">
            <input type="text" name="js-fiche" hidden value="<?= $enquete['fiche']['id'] ?>">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="js-date">Date de l'enquête <span class="text text-red">*</span></label>
                  <div class="input-group">
                    <select name="js-jour" id="js-jour" class="custom-select">
                      <option value="" hidden selected></option>
                      <?php for ($jours = 1; $jours <= $jours_max_du_mois; $jours++) { ?>
                        <option value="<?= $jours ?>" <?= intval($jours_enquete) === $jours ? 'selected' : '' ?>><?= $jours ?></option>
                      <?php } ?>
                    </select>
                    <div class="input-group-append"><span class="btn btn-default"><?= $mois_francais[intval($enquete['fiche']['mois']) - 1] ?> <?= $enquete['fiche']['annee'] ?></span></div>
                  </div>
                  <input type="date" name="js-date" class="form-control js-date" value="<?= $enquete['date'] ?>" hidden>
                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Pêcheur et leur nombre <span class="text text-red">*</span></label>
                  <div class="input-group">
                    <select class="custom-select" name="js-pecheur">
                      <option value="" selected hidden></option>
                      <?php foreach ($pecheurs as $pecheur) { ?>
                        <option value="<?= $pecheur['id'] ?>" <?= $enquete['pecheur'] === $pecheur['id'] ? 'selected' : '' ?>><?= $pecheur['nom'] ?></option>
                      <?php } ?>
                    </select>
                    <input min="1" max="10" value="1" type="number" class="form-control" name="js-nombre-pecheur">
                  </div>
                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                </div>
              </div>
            </div>
            <label class="text">Dernières sorties de pêches</label>
            <p>
              Le champ "<b>Sortie</b>" correspond au nombre de sorties effectuées au jour indiqué au-dessus.<br>
              Le champ "<b>pirogue</b>" corréspond au nombre de sorties où une pirogue a été utilisée.<br>
            </p>
            <div class="row">
              <?php foreach ($enquete["derniere_sortie_acheteur"] as $iteration => $sortie_de_peche) { ?>
                <div class="col-md-6 col-sm-12">
                  <div class="card">
                    <div class="card-header">
                      <label class="js-date-literalle"><?= $date_de_sortie[$iteration] ?></label>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="js-derniere-sortie-de-peche-nombre">Sortie <span class="text text-red">*</span></label><br>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                          <label class="btn btn-outline-secondary">
                            <input type="radio" value="0" <?= $sortie_de_peche['nombre'] == '0' ? 'checked' : '' ?> name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off">
                            0
                          </label>
                          <label class="btn btn-outline-secondary">
                            <input type="radio" value="1" <?= $sortie_de_peche['nombre'] == '1' ? 'checked' : '' ?> name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off">
                            1
                          </label>
                          <label class="btn btn-outline-secondary">
                            <input type="radio" value="2" <?= $sortie_de_peche['nombre'] == '2' ? 'checked' : '' ?> name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off">
                            2
                          </label>
                          <label class="btn btn-outline-secondary">
                            <input type="radio" value="3" <?= $sortie_de_peche['nombre'] == '3' ? 'checked' : '' ?> name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off">
                            3
                          </label>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="js-derniere-sortie-de-peche-pirogue">Pirogue <span class="text text-red">*</span></label><br>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                          <label class="btn btn-outline-secondary">
                            <input
                                type="radio"
                                value="0"
                                <?= $sortie_de_peche['pirogue'] == '0' ? 'checked' : '' ?>
                                name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>"
                                autocomplete="off"
                            > 0
                          </label>
                          <label class="btn btn-outline-secondary">
                            <input
                                type="radio"
                                value="1"
                                <?= $sortie_de_peche['pirogue'] == '1' ? 'checked' : '' ?>
                                name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>"
                                autocomplete="off"
                            > 1
                          </label>
                          <label class="btn btn-outline-secondary">
                            <input
                                type="radio"
                                value="2"
                                <?= $sortie_de_peche['pirogue'] == '2' ? 'checked' : '' ?>
                                name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>"
                                autocomplete="off"
                            > 2
                          </label>
                          <label class="btn btn-outline-secondary">
                            <input
                                type="radio"
                                value="3"
                                <?= $sortie_de_peche['pirogue'] == '3' ? 'checked' : '' ?>
                                name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>"
                                autocomplete="off"
                            > 3
                          </label>
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
                      <div class="row">
                        <div class="col-sm-6 col-xs-12">
                          <div class="card">
                            <div class="card-header">
                              <h3 class="card-title">
                                <label>Engin n°1</label>
                              </h3>
                            </div>
                            <div class="card-body">
                              <div class="form-group">
                                <label>Nom <span class="text-danger">*</span></label>
                                <select class="custom-select table-cell-form" name="js-derniere-sortie-de-peche-premier-engin-nom<?= $iteration ?>">
                                  <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>
                                    <option value="<?= $engin['id'] ?>" <?= $engin['id'] === $sortie_de_peche['engins'][0]['engin'] ? 'selected' : '' ?>><?= $engin['nom'] ?></option>
                                  <?php } ?>
                                </select>
                                <span class="form-text text-red" style="display: none;"></span>
                              </div>
                              <div class="form-group">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input
                                    min="<?= $ENGINS[strval($sortie_de_peche['engins'][0]['engin'])]['min'] ?>"
                                    max="<?= $ENGINS[strval($sortie_de_peche['engins'][0]['engin'])]['max'] ?>"
                                    type="number"
                                    class="form-control"
                                    name="js-derniere-sortie-de-peche-premier-engin-nombre<?= $iteration ?>"
                                    <?= $sortie_de_peche['engins'][0]['engin'] == $engins[0]['id'] ? 'readonly' : '' ?>
                                    value="<?= $sortie_de_peche['engins'][0]['nombre'] ?>">
                                <span class="form-text text-red" style="display: none;"></span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                          <div class="card">
                            <div class="card-header">
                              <h3 class="card-title">
                                <label>Engin n°2</label>
                              </h3>
                            </div>
                            <div class="card-body">
                              <div class="form-group">
                                <label>Nom <span class="text-danger">*</span></label>
                                <select class="custom-select table-cell-form" name="js-derniere-sortie-de-peche-deuxieme-engin-nom<?= $iteration ?>">
                                  <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>
                                    <option value="<?= $engin['id'] ?>" <?= $engin['id'] === $sortie_de_peche['engins'][1]['engin'] ? 'selected' : '' ?>><?= $engin['nom'] ?></option>
                                  <?php } ?>
                                </select>
                                <span class="form-text text-red" style="display: none;"></span>
                              </div>
                              <div class="form-group">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input
                                    min="<?= $ENGINS[strval($sortie_de_peche['engins'][1]['engin'])]['min'] ?>"
                                    max="<?= $ENGINS[strval($sortie_de_peche['engins'][1]['engin'])]['max'] ?>"
                                    type="number"
                                    class="form-control"
                                    name="js-derniere-sortie-de-peche-deuxieme-engin-nombre<?= $iteration ?>"
                                    <?= $sortie_de_peche['engins'][1]['engin'] == $engins[0]['id'] ? 'readonly' : '' ?>
                                    value="<?= $sortie_de_peche['engins'][1]['nombre'] ?>">
                                <span class="form-text text-red" style="display: none;"></span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
            <div class="form-group">
              <label for="js-nombre-sortie-vente">Nombre de sorties de vente de crabe <span class="text-danger">*</span></label>
              <input type="number" min="0" max="12" name="js-nombre-sortie-vente" id="js-nombre-sortie-vente" value="<?= $enquete["nombre_sortie_vente"] ?>" class="form-control">
              <span class="form-text text-red" style="display: none;"></span>
            </div>
            <label>Crabes vendus</label>
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="card card-default">
                  <div class="card-header">
                    <h3 class="card-title">Destiné à la Collecte</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label for="js-collecte-poids">Poids 1 <span class="text-danger">*</span><small>(Kg)</small></label>
                          <input type="number" class="form-control" name="js-collecte-poids1" value="<?= $enquete["collecte_poids1"] ?>">
                          <span class="form-text text-red" style="display: none;"></span>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label for="js-collecte-prix">Prix 1 <span class="text-danger">*</span><small>(Ariary/Kg)</small></label>
                          <input type="number" class="form-control" name="js-collecte-prix1" min="1000" max="20000" step="50" value="<?= $enquete["collecte_prix1"] ?>">
                          <span class="form-text text-red" style="display: none;"></span>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label for="js-collecte-poids">Poids 2 <small>(Kg)</small></label>
                          <input type="number" class="form-control" name="js-collecte-poids2" value="<?= $enquete["collecte_poids2"] ?>">
                          <span class="form-text text-red" style="display: none;"></span>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label for="js-collecte-prix">Prix 2 <small>(Ariary/Kg)</small></label>
                          <input type="number" class="form-control" name="js-collecte-prix2" min="0" max="20000" step="50" value="<?= $enquete["collecte_prix2"] ?>">
                          <span class="form-text text-red" style="display: none;"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="card card-default">
                  <div class="card-header">
                    <h3 class="card-title">Destiné au Marché local</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="js-marche-local-poids">Poids <span class="text-danger">*</span><small>(Kg)</small></label>
                      <input type="number" class="form-control" name="js-marche-local-poids" value="<?= $enquete["marche_local_poids"] ?>">
                      <span class="form-text text-red" style="display: none;"></span>
                    </div>
                    <div class="form-group">
                      <label for="js-marche-local-prix">Prix <span class="text-danger" id="js-marche-local-prix-obligatoire">*</span><small>(Ariary/Kg)</small></label>
                      <input type="number" class="form-control" name="js-marche-local-prix" step="50" value="<?= $enquete["marche_local_prix"] ?>">
                      <span class="form-text text-red" style="display: none;"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="js-nombre-de-crabe-non-vendu">Nombre de crabes non vendus <span class="text text-red">*</span></label>
              <input type="number" class="form-control" min="0" name="js-nombre-de-crabe-non-vendu" value="<?= $enquete['crabe_non_vendu_nombre'] ?>">
              <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
            </div>
            <div class="form-group">
              <label for="js-poids-de-crabe-non-vendu">Poids de crabes non vendus <span class="text text-red">*</span> (Kg)</label>
              <input type="number" class="form-control" min="0" name="js-poids-de-crabe-non-vendu" value="<?= $enquete['crabe_non_vendu_poids'] ?>">
              <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
            </div>
          </form>
          <div class="alert alert-danger alert-dismissible js-alerte-information-incorrecte" style="display: none;">
            <h5><i class="icon fas fa-ban"></i> Information incorrecte!</h5>
            <ul class="js-alerte-information-incorrecte-conteneur">
            </ul>
          </div>
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
