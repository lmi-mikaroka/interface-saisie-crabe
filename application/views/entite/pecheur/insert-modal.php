<div class="modal fade" id="insert-modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pêcheur</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="off" id="formulaire-insertion">
          <input type="submit" hidden>
          <div class="form-group">
            <label for="js-village-insertion">Village <span class="text text-red">*</span></label>
            <select name="js-village" id="js-village-insertion" class="custom-select">
              <option value="" hidden selected></option>
              <?php if (isset($villages) && is_array($villages)) foreach ($villages as $village) { ?>
                <option value="<?= $village['id'] ?>"><?= $village['nom'] ?></option>
              <?php } ?>
            </select>
            <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
          </div>
          <label>Nom du Pêcheur <span class="text text-red">*</span></label>
          <div id="js-noms-insertion">
            <div class="form-group">
              <input type="text" class="form-control" name="js-nom0" maxlength="100">
              <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
            </div>
          </div>
          <div class="btn-group">
            <button class="btn btn-default" type="button" id="js-ajouter-pecheur">ajouter une ligne</button>
            <button class="btn btn-default" type="button" id="js-supprimer-pecheur">supprimer la dernière ligne</button>
          </div>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-warning" id="enregistrer-insertion">Enregistrer</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
