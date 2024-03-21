<div class="modal fade" id="insert-modal">

  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title">Société</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <form autocomplete="off" id="formulaire-insertion">

          <input type="submit" hidden>

          <label>Nom de la Société <span class="text text-red">*</span></label>

          <div id="js-nom-insertion">

            <div class="form-group">

              <input type="text" class="form-control" name="js-nom" maxlength="100">

              <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

            </div>

          </div>
          
          <label>Adresse de la Société <span class="text text-red">*</span></label>

          <div id="js-adresse-insertion">

            <div class="form-group">

              <input type="text" class="form-control" name="js-adresse" maxlength="100">

              <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

            </div>

          </div>

          <label>Numéro de Téléphone <span class="text text-red">*</span></label>

          <div id="js-num-insertion">

            <div class="form-group">

              <input type="text" class="form-control" name="js-num" maxlength="100">

              <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

            </div>

          </div>

          <label>Non d'une Personne de Contact <span class="text text-red">*</span></label>

          <div id="js-nomPersonneContact-insertion">

            <div class="form-group">

              <input type="text" class="form-control" name="js-nomPersonneContact" maxlength="100">

              <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

            </div>

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
