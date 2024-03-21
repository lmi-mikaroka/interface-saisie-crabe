<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Fiche d'Enquêteur</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container">
      <!-- /.card -->
      <div class="row">
        <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4 col-sm-12">
          <div class="card card-default mb-3" id="information-sur-la-fiche">
            <div class="card-header card-enqueteur">
              <h3 class="card-title">
                <i class="fas fa-info-circle"></i>
                Information sur la fiche
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form autocomplete="off" id="js-formulaire">
                <input type="submit" hidden>
                <input type="submit" name="js-fiche" value="<?= $fiche['id'] ?>" hidden>
                <div class="form-group">
                  <label for="js-zone-corecrabe">Zone CORECRABE <span class="text text-red">*</span></label>
                  <select name="js-zone-corecrabe-affichage" id="js-zone-corecrabe-affichage" class="custom-select" disabled="">
                    <option value="<?= $zone_corecrabe['id'] ?>" hidden selected><?= $zone_corecrabe['nom'] ?></option>
                  </select>
                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                  <input type="text" name="js-zone-corecrabe" hidden value="<?= $zone_corecrabe['id'] ?>">
                </div>
                <div class="form-group">
                  <label for="js-village">Village <span class="text text-red">*</span></label>
                  <select name="js-village-affichage" id="js-village-affichage" class="custom-select" disabled>
                    <option value="<?= $village['id'] ?>" hidden selected><?= $village['nom'] ?></option>
                  </select>
                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                  <input type="text" name="js-village" value="<?= $village['id'] ?>" hidden>
                </div>
                <div class="form-group">
                  <label for="js-annee">Année <span class="text text-red">*</span> <small>(de 2020 à 2021)</small></label>
                  <input name="js-annee" type="number" class="form-control" min="2020" max="<?= $annee_courante ?>" id="js-annee" value="<?= $fiche['annee'] ?>">
                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                </div>
                <div class="form-group">
                  <label for="js-mois">Mois <span class="text text-red">*</span></label>
                  <select name="js-mois" id="js-mois" class="custom-select">
                    <?php if (!isset($mois_courant)) { ?>
                      <option value="" hidden disabled selected></option> <?php } ?>
                    <?php if (isset($mois) && is_array($mois)) foreach ($mois as $indexe => $valeur) { ?>
                      <option value="<?= $indexe + 1 ?>" <?= intval($fiche['mois']) == ($indexe + 1) ? 'selected' : '' ?>><?= $valeur ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="js-numero">Numéro de fiche <span class="text text-red">*</span> <small>(de 1 à 999)</small></label>
                  <input name="js-numero" type="number" class="form-control" id="input-js-numero" min="1" max="999" value="<?= $fiche['numero_ordre'] ?>">
                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                </div>
                <div class="form-group">
                  <label for="js-enqueteur">Code de l'Enquêteur <span class="text text-red">*</span></label>
                  <select name="js-enqueteur" id="js-enqueteur" class="custom-select">
                    <?php if (isset($enqueteurs) && is_array($enqueteurs)) foreach ($enqueteurs as $enqueteur) { ?>
                      <option value="<?= $enqueteur['id'] ?>" <?= intval($fiche['enqueteur']) === intval($enqueteur['id']) ? 'selected' : '' ?>><?= $enqueteur['code'] ?></option>
                    <?php } ?>
                  </select>
                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                </div>
                <div class="form-group">
                  <label for="js-date-expedition">Date d'expédition</label>
                  <input name="js-date-expedition" type="date" id="js-date-expedition" class="form-control" value="<?= $fiche['date_expedition'] ?>">
                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                </div>
              </form>
            </div>
            <?php if ($droit_de_modification) { ?>
              <div class="card-footer clearfix">
                <button type="button" class="btn btn-warning btn-block" id="js-bouton-enregistrer">
                  Enregistrer
                </button>
              </div>
            <?php } ?>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
      <!-- /.card -->
      <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
