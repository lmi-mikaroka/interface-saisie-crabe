<div class="modal fade" id="modal-modification">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Région</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="text-center" id="chargeur-information-modification">
					<div class="spinner-border" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<p><strong>Réquisition des données...</strong></p>
				</div>
				<form autocomplete="off" id="formulaire-modification">
					<input type="submit" hidden>
					<input type="text" hidden name="js-id">
					<div class="form-group">
            <label for="js-zone-corecrabe-modification">Zone CORECRABE <span class="text text-red">*</span></label>
            <select name="js-zone-corecrabe" id="js-zone-corecrabe-modification" class="custom-select">
              <option value="" hidden selected></option>
              <?php if (isset($zone_corecrabes) && is_array($zone_corecrabes)) foreach ($zone_corecrabes as $zone_corecrabe) { ?>
                <option value="<?= $zone_corecrabe['id'] ?>"><?= $zone_corecrabe['nom'] ?></option>
              <?php } ?>
            </select>
            <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
          </div>
          <div class="form-group">
            <label for="js-nom-modification">Nom de la Région <span class="text text-red">*</span></label>
            <input type="text" class="form-control" id="js-nom-modification" name="js-nom" maxlength="50">
            <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
          </div>
				</form>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-warning" id="enregistrer-modification">Enregistrer</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
