<div class="modal fade" id="modal-modification">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Village</h4>
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
						<label for="js-fokontany-insertion">Fokontany <span class="text text-red">*</span></label>
						<select name="js-fokontany" id="js-fokontany-insertion" class="custom-select">
							<option value="" hidden selected></option>
							<?php if (isset($fokontanys) && is_array($fokontanys)) foreach ($fokontanys as $fokontany) { ?>
								<option value="<?= $fokontany['id'] ?>"><?= $fokontany['nom'] ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="js-nom-insertion">Nom du Village <span class="text text-red">*</span></label>
						<input type="text" id="js-nom-insertion" name="js-nom" class="form-control" maxlength="50">
						<span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
					</div>
					<div class="form-group">
						<label for="js-sous-zone">Sous-zone<span class="text text-red">*</span></label>
						<select name="js-sous-zone" id="js-sous-zone" class="custom-select">
							<option value="" hidden selected></option>
							<option value="Ambaro">Ambaro</option>
							<option value="Belo-Tsiribihina">Belo-Tsiribihina</option>
							<option value="Mahajamba">Mahajamba</option>
							<option value="Mangoky">Mangoky</option>
							<option value="Nord-Morondava">Nord-Morondava</option>
							<option value="Sud-Mahajanga">Sud-Mahajanga</option>
							<option value="Sud-Morombe">Sud-Morombe</option>
							<option value="Tsimipaika">Tsimipaika</option>
						</select>
					</div>
					<div class="form-group">
						<label for="js-longitude-insertion">longitude </label>
						<input type="text" id="js-longitude-insertion" name="js-longitude" class="form-control" maxlength="30">
					</div>
					<div class="form-group">
						<label for="js-latitude-insertion">Latitude </label>
						<input type="text" id="js-latitude-insertion" name="js-latitude" class="form-control" maxlength="30">
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
