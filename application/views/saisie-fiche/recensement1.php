<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Fiche de recensement N° 5
              
          </h1>

        </div>
        <div class="col-sm-6">
        <span><button type="button" class="btn btn-warning" id="enregistrer">Enregistrer et terminer</button></span>
                        <span><button type="button" class="btn btn-warning" id="enregistrer-nouvelle">Enregistrer et nouvelle fiche</button></span>
        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>
  <section class="content">
    <div class="container">
      <div class="card" >
          <div class="card-header" >
              <h3 class="card-title">Information sur le fiche</h3>
              <div class="card-tools" >
                  <button class="btn btn-default" id="nouveau_fiche"><i class="fa fa-plus-circle mr-2"></i>Saisir nouveau enquête</button>
              </div>
          </div>
          <div class="card-body">
          <div class="row">
              <div class="col-sm-6" style="border-right: 1px solid #ffc107" >
                <div class="row" style="display:flex; align-items: center">
                    <div class="col-md-6" ><h6 style="font-weight: bold">Zone corecrabe <span class="text text-red">*</span>:</h6></div>
                    <div class="col-md-6 mb-1" >
                        <select class="selectpicker form-control " id="js-zone-corecrabe" name="js-zone-corecrabe">
                            <option value="" >--sélectionner une zone corecrabe--</option>
                            <?php if (isset($zone_corecrabes) && is_array($zone_corecrabes)) foreach ($zone_corecrabes as $zone_corecrabe) { ?>
                            <option value="<?= $zone_corecrabe['id'] ?>"><?= $zone_corecrabe['id'] . ' - ' . $zone_corecrabe['nom'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6" ><h6 style="font-weight: bold">Commune <span class="text text-red">*</span>:</h6></div>
                    <div class="col-md-6 mb-1" >
                        <div class="text-center" style="display: none;" id="actualisation-commune">

                        <div class="spinner-border" role="status">

                        <span class="sr-only">Loading...</span>

                        </div>

                        <p><strong>Actualisation des communes...</strong></p>

                        </div>
                        <select class="custom-select select-add" name="js-commune" id="champ-insertion-commune">   
                        </select>
                        <input type="number" hidden id="js-nouveau-commune" name="js-nouveau-commune" />
                    </div>
                    <div class="col-md-6" ><h6 style="font-weight: bold">Fokontany <span class="text text-red">*</span>:</h6></div>
                    <div class="col-md-6 mb-1" >

                        <div class="text-center" style="display: none;" id="actualisation-fokontany">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p><strong>Actualisation des fokontany...</strong></p>
                        </div>

                        <select class="custom-select select-add" name="js-fokontany" id="champ-insertion-fokontany">   
                        </select>
                        <input type="number" hidden id="js-nouveau-fokontany" name="js-nouveau-fokontany" />
                    </div>
                </div>
            </div>
            <div class="col-sm-6 " style="border-right: 1px solid #ffc107" >
                <div class="row" style="display:flex; align-items: center">
                    <div class="col-md-6" ><h6 style="font-weight: bold">Village <span class="text text-red">*</span>:</h6></div>
                    <div class="col-md-6 mb-1" >
                        <div class="text-center" style="display: none;" id="actualisation-village">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p><strong>Actualisation des villages...</strong></p>
                        </div>
                        <select class="custom-select select-add" name="js-village" id="champ-insertion-village">   
                        </select>
                        <input type="number" hidden id="js-nouveau-village" name="js-nouveau-village" />
                    </div>
                    <div class="col-md-6" ><h6 style="font-weight: bold">Date du récensement<span class="text text-red">*</span>:</h6></div>
                    <div class="col-md-6 mb-1" >
                        <input type="date" class="form-control" id="js-date-enquete" name="js-date-enquete"/>
                    </div>
                    <div class="col-md-6" ><h6 style="font-weight: bold">Code Enqueteur:</h6></div>
                    <div class="col-md-6 mb-1" >
                    <div class="text-center" style="display: none;" id="actualisation-enqueteur">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p><strong>Actualisation des villages...</strong></p>
                        </div>
                        <select class="custom-select" id="js-enqueteur" name="js-enqueteur">   
                        </select>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </div>

    <!-- test javascript -->

    <div id="conteneur_fiche"></div>

    <!-- fin test -->
<!-- fiche -->
    <?php for($i=0;$i<5;$i++){ ?>
    <!-- <div class="card">
        <div class="card-header" >
            <h3 class="card-title">Information du pêcheur</h3>
            <div class="card-tools"><i class="fa fa-window-close"></i></div>
        </div>
        <div class="card-body">
            <div class="row">

            
                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Résident</h6></div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Village d'origine</h6></div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Pécheur(s)</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Sexe</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Age</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Pirogue</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Crabe toute l'année</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Période</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Engin1</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Année1</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Engin2</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Année2</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Activité1</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Pourcentage1</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Activite2</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Pourcentage2</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Activité3</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row" style="display:flex; align-items: center">
                        <div class="col-md-6"><h6 style="font-weight: bold">Pourcentage3</h6></div>
                        <div class="col-sm-6 mb-1">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div> -->
    <?php } ?>
<!-- fiche -->  
    </div>
  </section>
</div>
