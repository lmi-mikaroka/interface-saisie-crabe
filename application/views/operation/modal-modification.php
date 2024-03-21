<div class="modal fade" id="modal-modification">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Operation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="off" id="js-formulaire-modification">
          <input type="submit" hidden>
          <input type="text" hidden name="js-id">
          <div class="form-group">
            <label for="js-nom-modification">Nom de l'opération <span class="text text-red">*</span></label>
            <input type="text" class="form-control" name="js-nom" id="js-nom-modification">
            <span class="form-text text-red" style="display: none;"></span>
          </div>
          <label>Actions possibles</label>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
              <input type="checkbox" class="custom-control-input" name="js-creation" id="js-creation-modification">
              <label class="custom-control-label" for="js-creation-modification">Création</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
              <input type="checkbox" class="custom-control-input" name="js-modification" id="js-modification-modification">
              <label class="custom-control-label" for="js-modification-modification">Modification</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
              <input type="checkbox" class="custom-control-input" name="js-visualisation" id="js-visualisation-modification">
              <label class="custom-control-label" for="js-visualisation-modification">Visualisation</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
              <input type="checkbox" class="custom-control-input" name="js-suppression" id="js-suppression-modification">
              <label class="custom-control-label" for="js-suppression-modification">Suppression</label>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-warning" id="js-modifier">Enregistrer</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
