<div class="modal fade" id="modal-modification">

  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title">Utilisateur</h4>

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

        <form autocomplete="off" id="js-formulaire-modification">

        <div class="form-row">

            <input type="submit" hidden>
            <input type="hidden" class="form-control js-id">
            <div class="form-group col-md-6">

            <label for="insert-organisation">Organisation <span class="text text-red">*</span></label>

            <select class="custom-select js-organisation">

                <option value="" selected hidden></option>

                <?php if (isset($organisations) && is_array($organisations)) foreach ($organisations as $organisation) { ?>

                <option value="<?= $organisation['id'] ?>"><?= $organisation['label'] ?></option>

                <?php } ?>

            </select>

            <span class="form-text text-red" style="display: none;"></span>

            </div>

            <div class="form-group col-md-6">

                <label>Nom d'utilisateur <span class="text text-red">*</span></label>

                <input type="text" class="form-control js-nom">

                <span class="form-text text-red" style="display: none;"></span>

            </div>

            <div class="form-group col-md-6">

                <label>Pseudo <span class="text text-red">*</span></label>

                <input type="text" class="form-control js-email">

                <span class="form-text text-red" style="display: none;"></span>

            </div>

            <div class="form-group col-md-6">

            <label>Télephone <span class="text text-red">*</span></label>

            <input type="text" class="form-control js-tel">

            <span class="form-text text-red" style="display: none;"></span>

          </div>

          <div class="form-group col-md-12">

            <label>Mot de passe <span class="text text-red">*</span></label>

            <div class="input-group">

              <input type="text" class="form-control js-password">

              <span class="input-group-append">

                  <button type="button" class="btn btn-default js-afficher-cacher-password"><i class="fas fa-eye"></i></button>

                </span>

            </div>

            <span class="form-text text-red" style="display: none;"></span>

          </div>




        </div>

          <!-- <div class="form-group"></div> -->

        </form>

      </div>

      <div class="modal-footer justify-content-between">

        <button type="button" id="js-enregistrer-modification" class="btn btn-warning js-enregistrer-modification ">Enregistrer</button>

      </div>

    </div>

    <!-- /.modal-content -->

  </div>

  <!-- /.modal-dialog -->

</div>

<!-- /.modal -->
