<div class="modal fade" id="modal-insertion">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Utilisateur</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="off" id="js-formulaire-insertion">
          <input type="submit" hidden>
          <div class="form-group">
            <label for="insert-district">Groupe <span class="text text-red">*</span></label>
            <select class="custom-select js-groupe">
              <option value="" selected hidden></option>
              <?php if (isset($groupes) && is_array($groupes)) foreach ($groupes as $groupe) { ?>
                <option value="<?= $groupe['id'] ?>"><?= $groupe['nom'] ?></option>
              <?php } ?>
            </select>
            <span class="form-text text-red" style="display: none;"></span>
          </div>
          <div class="icheck-warning">
            <input type="checkbox" id="js-selection-enqueteur-insertion" class="js-selection-enqueteur">
            <label for="js-selection-enqueteur-insertion">
              Sélectionner à partir des enquêteurs
            </label>
          </div>
          <div class="form-group">
            <label for="insert-district">Enquêteur <span class="text text-red">*</span></label>
            <select class="custom-select js-enqueteur">
              <?php if (isset($enqueteurs) && is_array($enqueteurs)) foreach ($enqueteurs as $enqueteur) { ?>
                <option value="<?= $enqueteur['id'] ?>"><?= $enqueteur['code'] ?> - <?= $enqueteur['nom'] ?></option>
              <?php } ?>
            </select>
            <span class="form-text text-red" style="display: none;"></span>
          </div>
          <div class="form-group">
            <label>Nom d'utilisateur <span class="text text-red">*</span></label>
            <input type="text" class="form-control js-nom-utilisateur">
            <span class="form-text text-red" style="display: none;"></span>
          </div>
          <div class="form-group">
            <label>Identifiant <span class="text text-red">*</span></label>
            <input type="text" class="form-control js-identifiant">
            <span class="form-text text-red" style="display: none;"></span>
          </div>
          <div class="form-group">
            <label>Mot de passe <span class="text text-red">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control js-mot-de-passe">
              <span class="input-group-append">
                  <button type="button" class="btn btn-default js-afficher-cacher-mot-de-passe"><i class="fas fa-eye"></i></button>
                </span>
            </div>
            <span class="form-text text-red" style="display: none;"></span>
          </div>
          <div class="form-group"></div>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-warning js-enregistrer">Enregistrer</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
