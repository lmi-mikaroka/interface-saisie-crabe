<div class="modal fade" id="modal-insertion">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">District</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form autocomplete="off" id="formulaire-insertion">
          <input type="submit" hidden>
					<div class="form-group">
						<label for="js-region-insertion">Région <span class="text text-red">*</span></label>
						<select name="js-region" id="js-region-insertion" class="custom-select">
							<option value="" hidden selected></option>
							<?php if (isset($regions) && is_array($regions)) foreach ($regions as $region) { ?>
								<option value="<?= $region['id'] ?>"><?= $region['nom'] ?></option>
							<?php } ?>
						</select>
            <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
					</div>
					<div class="form-group">
						<label for="js-nom-insertion">Nom du District <span class="text text-red">*</span></label>
						<input type="text" name="js-nom" id="js-nom-insertion" class="form-control" maxlength="50">
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
