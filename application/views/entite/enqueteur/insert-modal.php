<div class="modal fade" id="insert-modal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Enquêteur</h4>
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
							<option value="" selected hidden></option>
							<?php foreach ($villages as $village) { ?>
								<option value="<?= $village['id'] ?>"><?= $village['nom'] ?></option>
							<?php } ?>
						</select>
            <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
					</div>
					<div class="form-group">
						<label for="js-type-insertion">Type de l'Enquêteur <span class="text text-red">*</span></label>
						<select name="js-type" id="js-type-insertion" class="custom-select">
							<option value="Enquêteur">Enquêteur</option>
							<option value="Acheteur">Acheteur</option>
							<option value="Pêcheur">Pêcheur</option>
						</select>
					</div>
					<div class="form-group">
						<label for="js-structure-insertion">Structure de l'Enqueteur <span class="text text-red">*</span></label>
						<select name="js-structure" id="js-structure-insertion" class="custom-select">
							<option value="" selected hidden></option>
							<?php if (isset($structure_enqueteurs) && is_array($structure_enqueteurs)) foreach ($structure_enqueteurs as $structure_enqueteur) { ?>
								<option value="<?= $structure_enqueteur['id'] ?>"><?= $structure_enqueteur['valeur'] ?></option>
							<?php } ?>
						</select>
						<span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
					</div>
					<div class="form-group">
						<label for="js-code-insertion">Code de l'Enquêteur <span class="text text-red">*</span></label>
						<input type="text" name="js-code" id="js-code-insertion" class="form-control" maxlength="3">
						<span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
					</div>
					<div class="form-group">
						<label for="js-nom-insertion">Nom de l'Enquêteur</label>
						<input type="text" name="js-nom" id="js-nom-insertion" class="form-control" maxlength="100">
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
