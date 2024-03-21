<div class="modal fade" id="modal-modification">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Fokontany</h4>
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
					<input type="text" name="js-id" hidden>
					<div class="form-group">
						<label for="js-commune-modification">Commune <span class="text text-red">*</span></label>
						<select name="js-commune" id="js-commune-modification" class="custom-select">
							<option value="" hidden selected></option>
							<?php if (isset($communes) && is_array($communes)) foreach ($communes as $commune) { ?>
								<option value="<?= $commune['id'] ?>"><?= $commune['nom'] ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="js-nom-modification">Nom du Fokontany <span class="text text-red">*</span></label>
						<input type="text" id="js-nom-modification" name="js-nom" class="form-control" maxlength="50">
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
