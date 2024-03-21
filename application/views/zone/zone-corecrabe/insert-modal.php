<div class="modal fade" id="modal-insertion">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Zone corecrabe</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="off" id="formulaire-insertion">
          <input type="submit" hidden>
          <div class="form-group">
            <label for="js-nom-insertion">Nom de la Zone <span class="text text-red">*</span></label>
            <div class="input-group">
              <input type="text" id="js-nom-insertion" name="js-nom" class="form-control" maxlength="50">
            </div>
            <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
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
