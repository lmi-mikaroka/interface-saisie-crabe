<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Exporter la fiche d'Enquêteur</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- /.card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Critère de recherche</h3>
        </div>
        <!-- /.card-header -->
        <!-- /.card-header -->
        <div class="card-body">
          <form id="js-formulaire-fiche-enqueteur">
            <div class="form-group">
              <label>Villages</label>
              <select class="form-control select2" multiple="multiple" data-dropdown-css-class="select2-purple" style="width: 100%;" data-placeholder="Saisisez ou sélectionner les villages" name="js-villages[]">
                <?php foreach ($zone_corecrabes as $zone_corecrabe) { ?>
                  <optgroup label="<?= $zone_corecrabe['nom'] ?>">
                    <?php foreach ($zone_corecrabe['villages'] as $village) { ?>
                      <option value="<?= $village['id'] ?>"><?= $village['nom'] ?></option>
                    <?php } ?>
                  </optgroup>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Intervalle de temps</label>
              <div class="input-group">
                <input type="date" class="form-control" name="js-date-debut">
                <div class="input-group-append">
                  <span class="btn btn-default"> Jusqu'au </span>
                </div>
                <input type="date" class="form-control" name="js-date-fin">
                <div class="input-group-append">
                  <button name="js-effacer-date" type="button" class="btn btn-default">Effacer</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Champs à exporter</label>
              <div class="select2-purple">
                <select class="form-control select2" multiple="multiple" data-dropdown-css-class="select2-purple" style="width: 100%;" data-placeholder="Saisisez ou sélectionner les champs" name="js-champs[]">
                  <?php foreach ($champs_fiche_enqueteurs as $cle => $champs_fiche_enqueteur) { ?>
                    <option value="<?= $cle ?>"><?= $champs_fiche_enqueteur ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label>Séparateur</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="js-delimiteur" value="," id="virgule-enqueteur" checked>
                <label class="form-check-label" for="virgule-enqueteur">Virgule</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="js-delimiteur" value=";" id="point-virgule-enqueteur">
                <label class="form-check-label" for="point-virgule-enqueteur">Point virgule</label>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-warning" id="js-generer-fiche-enqueteur">Générer et télécharger</button>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
