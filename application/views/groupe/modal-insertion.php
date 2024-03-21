<div class="modal fade" id="modal-insertion">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Groupe</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="off" id="js-formulaire-insertion">
          <input type="submit" hidden>
          <div class="form-group">
            <label for="js-nom-insertion">Nom du groupe <span class="text text-red">*</span></label>
            <input type="text" class="form-control" name="js-nom" id="js-nom-insertion">
            <span class="form-text text-red" style="display: none;"></span>
          </div>
          <label>Permissions</label>
          <table class="table">
            <thead>
              <tr>
                <th>Opération</th>
                <th>Création</th>
                <th>Modification</th>
                <th>Visualisation</th>
                <th>Suppression</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($operations as $iteration => $operation) { ?>
                <tr class="js-operation">
                  <td>
                    <?= $operation['nom'] ?>
                    <input type="text" name="js-permission<?= $iteration ?>" value="<?= $operation['id'] ?>" hidden>
                  </td>
                  <td>
                    <?php if ($operation['creation'] === 'true') { ?>
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
                        <input type="checkbox" class="custom-control-input" name="js-creation<?= $iteration ?>" id="js-creation-insertion<?= $iteration ?>">
                        <label class="custom-control-label" for="js-creation-insertion<?= $iteration ?>"></label>
                      </div>
                    <?php } else { ?>
                      -
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($operation['modification'] === 'true') { ?>
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
                        <input type="checkbox" class="custom-control-input" name="js-modification<?= $iteration ?>" id="js-modification-insertion<?= $iteration ?>">
                        <label class="custom-control-label" for="js-modification-insertion<?= $iteration ?>"></label>
                      </div>
                    <?php } else { ?>
                      -
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($operation['visualisation'] === 'true') { ?>
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
                        <input type="checkbox" class="custom-control-input" name="js-visualisation<?= $iteration ?>" id="js-visualisation-insertion<?= $iteration ?>">
                        <label class="custom-control-label" for="js-visualisation-insertion<?= $iteration ?>"></label>
                      </div>
                    <?php } else { ?>
                      -
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($operation['suppression'] === 'true') { ?>
                      <div class="custom-control custom-switch custom-switch-off-default custom-switch-on-primary">
                        <input type="checkbox" class="custom-control-input" name="js-suppression<?= $iteration ?>" id="js-suppression-insertion<?= $iteration ?>">
                        <label class="custom-control-label" for="js-suppression-insertion<?= $iteration ?>"></label>
                      </div>
                    <?php } else { ?>
                      -
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-warning" id="js-enregistrer">Enregistrer</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
