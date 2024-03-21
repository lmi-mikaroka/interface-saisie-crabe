<div class="modal fade" id="modal-insertion">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Operation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="off" id="js-formulaire-insertion">
          <input type="submit" hidden>
          <div class="form-group">
            <label for="js-nom-insertion">Nom de l'opération <span class="text text-red">*</span></label>
            <input type="text" class="form-control" name="js-nom" id="js-nom-insertion">
            <span class="form-text text-red" style="display: none;"></span>
          </div>
          <label>Actions possibles</label>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
              <input type="checkbox" class="custom-control-input" name="js-creation" id="js-creation-insertion">
              <label class="custom-control-label" for="js-creation-insertion">Création</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
              <input type="checkbox" class="custom-control-input" name="js-modification" id="js-modification-insertion">
              <label class="custom-control-label" for="js-modification-insertion">Modification</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
              <input type="checkbox" class="custom-control-input" name="js-visualisation" id="js-visualisation-insertion">
              <label class="custom-control-label" for="js-visualisation-insertion">Visualisation</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
              <input type="checkbox" class="custom-control-input" name="js-suppression" id="js-suppression-insertion">
              <label class="custom-control-label" for="js-suppression-insertion">Suppression</label>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-warning" id="js-enregistrer">Enregistrer</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
