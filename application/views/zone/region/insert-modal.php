<div class="modal fade" id="modal-insertion">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Région</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="off" id="formulaire-insertion">
          <input type="submit" hidden>
          <div class="form-group">
            <label for="js-zone-corecrabe-insertion">Zone CORECRABE <span class="text text-red">*</span></label>
            <select name="js-zone-corecrabe" id="js-zone-corecrabe-insertion" class="custom-select">
              <option value="" hidden selected></option>
              <?php if (isset($zone_corecrabes) && is_array($zone_corecrabes)) foreach ($zone_corecrabes as $zone_corecrabe) { ?>
                <option value="<?= $zone_corecrabe['id'] ?>"><?= $zone_corecrabe['nom'] ?></option>
              <?php } ?>
            </select>
            <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
          </div>
          <div class="form-group">
            <label for="js-nom-insertion">Nom de la Région <span class="text text-red">*</span></label>
            <input type="text" class="form-control" id="js-nom-insertion" name="js-nom" maxlength="50">
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
