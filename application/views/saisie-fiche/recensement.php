<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Fiche de recensement N° 5</h1>

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>



  <!-- Main content -->

  <section class="content">

    <div class="container">

      <!-- /.card -->

      <div class="row">

        <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4 col-sm-12">

          <div class="card card-magnirike" id="information-sur-la-fiche">

            <div class="card-header card-recensement">

              <h3 class="card-title">

                <i class="fas fa-info-circle"></i>

                Information sur la fiche

              </h3>

            </div>

            <!-- /.card-header -->

            <div class="card-body">

              <form autocomplete="off" id="js-formulaire">

                <div class="form-group">

                  <label for="js-zone-corecrabe">Zone CORECRABE <span class="text text-red">*</span></label>

                  <select name="js-zone-corecrabe" id="js-zone-corecrabe" class="custom-select">

                    <option value="" hidden selected></option>

                    <?php if (isset($zone_corecrabes) && is_array($zone_corecrabes)) foreach ($zone_corecrabes as $zone_corecrabe) { ?>

                      <option value="<?= $zone_corecrabe['id'] ?>"><?= $zone_corecrabe['id'] . ' - ' . $zone_corecrabe['nom'] ?></option>

                    <?php } ?>

                  </select>

                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                </div>

                <div class="text-center" style="display: none;" id="actualisation-village">

                  <div class="spinner-border" role="status">

                    <span class="sr-only">Loading...</span>

                  </div>

                  <p><strong>Actualisation des villages...</strong></p>

                </div>

                <div class="form-group" id="champ-insertion-village">

                  <label for="js-village">Village <span class="text text-red">*</span></label>

                  <select name="js-village" id="js-village" class="custom-select"></select>

                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                </div>

                <div class="form-group">

                  <label for="js-annee">Année <span class="text text-red">*</span> <small>(de 2020 à 2023)</small></label>

                  <!--<input name="js-annee" type="number" class="form-control" min="2020" max="2023" id="js-annee" <?= isset($annee_courante) ? 'value="' . $annee_courante . '"' : '' ?>>-->
                  <select name="js-annee" type="number" class="form-control" id="js-annee">
                      <?php
                        $max = 2023;
                        for($min=2020;$min<=$max;$min++){
                          if(isset($annee_courante)){
                            if($annee_courante == $min){
                              echo '<option value="'.$min.'" selected>'.$min.'</option>';
                            }else{
                              echo '<option value="'.$min.'">'.$min.'</option>';
                            }
                          }else{
                            echo '<option value="'.$min.'">'.$min.'</option>';
                          }
                        }
                        
                      ?>
                  </select>

                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                </div>

                <div class="form-group">

                  <label for="js-mois">Mois <span class="text text-red">*</span></label>

                  <select name="js-mois" id="js-mois" class="custom-select">

                    <?php if (!isset($mois_courant)) { ?>

                      <option value="" hidden disabled selected></option> <?php } ?>

                    <?php if (isset($mois) && is_array($mois)) foreach ($mois as $indexe => $valeur) { ?>

                      <option value="<?= $indexe + 1 ?>" <?= isset($mois_courant) && intval($mois_courant) == ($indexe + 1) ? 'selected' : '' ?>><?= $valeur ?></option>

                    <?php } ?>

                  </select>

                </div>

                <div class="form-group">

                  <label for="js-numero">Numéro de fiche <span class="text text-red">*</span> <small>(de 1 à 999)</small></label>

                  <input name="js-numero" type="number" class="form-control" id="input-js-numero" min="1" max="999">

                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                </div>

                <div class="text-center" style="display: none;" id="actualisation-enqueteur">

                  <div class="spinner-border" role="status">

                    <span class="sr-only">Loading...</span>

                  </div>

                  <p><strong>Actualisation des enquêteurs...</strong></p>

                </div>

                <div class="form-group" id="champ-insertion-enqueteur">

                  <label for="js-enqueteur">Code d'Enquêteur <span class="text text-red">*</span></label>

                  <select name="js-enqueteur" id="js-enqueteur" class="custom-select">

                    <option value="" hidden selected></option>

                    <?php if (isset($enqueteurs) && is_array($enqueteurs)) foreach ($enqueteurs as $enqueteur) { ?>

                      <option value="<?= $enqueteur['id'] ?>"><?= $enqueteur['code'] ?></option>

                    <?php } ?>

                  </select>

                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                </div>

                <div class="form-group">

                  <label for="js-date-expedition">Date d'expédition</label>

                  <input type="date" id="js-date-expedition" class="form-control" name="js-date-expedition">

                  <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                </div>

              </form>

            </div>

            <div class="card-footer clearfix">

              <button type="button" class="btn btn-warning btn-block" id="js-bouton-enregistrer">

                Enregistrer

              </button>

            </div>

            <!-- /.card-body -->

          </div>

        </div>

      </div>

      <!-- /.card -->

      <!-- /.container-fluid -->

  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->
