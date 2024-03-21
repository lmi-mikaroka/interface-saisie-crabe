<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">
          <h1>Fiche de recensement N° 6</h1>
        </div>
        <div class="col-sm-6">
            <span><button type="button" class="btn btn-warning" id="enregistrer">Enregistrer et terminer</button></span>
            <span><button type="button" class="btn btn-warning" id="enregistrer-nouvelle">Enregistrer et nouvelle enquête</button></span>
        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>



  <!-- Main content -->

  <section class="content">

    <div class="container">

    <div class="card">
      <div class="card-header">
      <h6 class="card-title" ><span id="warning"></span>Information du fiche</h6>
      </div>
      <div class="card-body" >
        <div class="row">
          <div class="col-md-6" style="border-right: 1px solid #ffc107">
              <div class="row"  style="display:flex; align-items: center" >
                  <div class="col-md-6">
                  <h6 style="font-weight: bold">Zone corecrabe <span class="text text-red">*</span>:</h6>
                  </div>
                  <div class="col-md-6 mb-1">
                  <div >

                    <select name="js-zone-corecrabe" id="js-zone-corecrabe" class=" selectpicker custom-select">

                      <option value="" hidden selected></option>

                      <?php if (isset($zone_corecrabes) && is_array($zone_corecrabes)) foreach ($zone_corecrabes as $zone_corecrabe) { ?>

                        <option value="<?= $zone_corecrabe['id'] ?>"><?= $zone_corecrabe['id'] . ' - ' . $zone_corecrabe['nom'] ?></option>

                      <?php } ?>

                    </select>

                    <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                    </div>
                  </div>
                  <div class="col-md-6">
                  <h6 style="font-weight: bold">Fokontany <span class="text text-red">*</span>:</h6>
                  </div>
                  <div class="col-md-6 mb-1">
                  <div class="text-center" style="display: none;" id="actualisation-fokontany">

                    <div class="spinner-border" role="status">

                      <span class="sr-only">Loading...</span>

                    </div>

                    <p><strong>Actualisation des villages...</strong></p>

                    </div>
                  <div  id="champ-insertion-fokontany">

                    <select name="js-fokontany" id="js-fokontany" class="custom-select selectpicker">

                      <option value="" hidden selected></option>

                    </select>

                    <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                    </div>
                  </div>
                  <div class="col-md-6">
                  <h6 style="font-weight: bold">Village <span class="text text-red">*</span>:</h6>
                  </div>
                  <div class="col-md-6 mb-1">
                    <div class="text-center" style="display: none;" id="actualisation-village">

                    <div class="spinner-border" role="status">

                      <span class="sr-only">Loading...</span>

                    </div>

                    <p><strong>Actualisation des villages...</strong></p>

                    </div>
                  <div class="form-group" id="champ-insertion-village">

                    <select name="js-village" id="js-village" class="custom-select selectpicker">

                      <option value="" hidden selected></option>

                    </select>

                    <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                    </div>
                  </div>
              </div>
          </div>
          <div class="col-md-6" style="border-right: 1px solid #ffc107">
                      <div class="row"  style="display:flex; align-items: center">
                        <div class="col-md-6" ><h6 style="font-weight: bold">Mois <span class="text text-red">*</span>:</h6></div>
                        <div class="col-md-6 mb-1" >
                            <input type="month" name="js-annee-mois" type="number" class=" form-control selectpicker" id="js-annee-mois">
                          
                        </div>
                        <div class="col-md-6" ><h6 style="font-weight: bold">Date <span class="text text-red">*</span>:</h6></div>
                        <div class="col-md-6 mb-1" >
                            <input type="date" name="js-date" type="number" class=" form-control selectpicker"id="js-date">
                        </div>
                        <div class="col-md-6" ><h6 style="font-weight: bold">Enqueteur :</h6></div>
                        <div class="col-md-6 mb-1" >
                            <select name="js-enqueteur" type="number" class="custom-select selectpicker" id="js-enqueteur">
                            <option value="" hidden selected></option>

                              <?php if (isset($enqueteurs) && is_array($enqueteurs)) foreach ($enqueteurs as $enqueteur) { ?>

                                <option value="<?= $enqueteur['id'] ?>"><?= $enqueteur['code'] ?></option>

                              <?php } ?>
                          </select>
                        </div>
                      </div>
          </div>
        </div>
      </div>
    </div>

    <div id="conteneur_fiche"></div>
    
    <div class="card" id="table_pecheur" style="display:none">
      <div class="card-body">
          <table id="example"  class=" display table " style="width:100%">
              <thead>
                  <tr class="text-center">
                      <th>Pecheur</th>
                      <th>Sexe</th>
                      <th>crabe</th>
                      <th>Activité1</th>
                      <th>%</th>
                      <th>Activité2</th>
                      <th>%</th>
                      <th>Activité3</th>
                      <th>%</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody id="body-table" >
              <!-- <tr>
                      <td>Alexandre</td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Homme
                          </option>
                          <option value="London">
                              Femme
                          </option>
                          
                      </select></td>
                      <td>


                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-xs btn-outline-secondary  ">
                            
                                <input type="radio" value="0"    > Non
    
                                </label>
                                <label class="btn btn-xs btn-outline-secondary  ">
                            
                                <input type="radio" value="1"  name="js-crabe"   > Oui
    
                                </label>
    
                               </div>



                      </td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Edinburgh
                          </option>
                          <option value="London">
                              London
                          </option>
                          <option value="New York">
                              New York
                          </option>
                          <option value="San Francisco">
                              San Francisco
                          </option>
                          <option value="Tokyo">
                              Tokyo
                          </option>
                      </select></td>
                      <td>
                        <input  type="number" size="1" id="row-1-office" name="row-1-office" >
                      </td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Edinburgh
                          </option>
                          <option value="London">
                              London
                          </option>
                          <option value="New York">
                              New York
                          </option>
                          <option value="San Francisco">
                              San Francisco
                          </option>
                          <option value="Tokyo">
                              Tokyo
                          </option>
                      </select></td>
                      <td><input  type="number" size="1" id="row-1-office" name="row-1-office" ></td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Edinburgh
                          </option>
                          <option value="London">
                              London
                          </option>
                          <option value="New York">
                              New York
                          </option>
                          <option value="San Francisco">
                              San Francisco
                          </option>
                          <option value="Tokyo">
                              Tokyo
                          </option>
                      </select></td>
                      <td><input  type="number" size="1" id="row-1-office" name="row-1-office" ></td>
                      <td> <button class="btn btn-default">Enregistrer</button> </td>
              </tr>
          
              <tr>
                      <td>Tiger Nixon</td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Homme
                          </option>
                          <option value="London">
                              Femme
                          </option>
                          
                      </select></td>
                      <td>


                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-xs btn-outline-secondary  ">
                            
                                <input type="radio" value="0"    > Non
    
                                </label>
                                <label class="btn btn-xs btn-outline-secondary  ">
                            
                                <input type="radio" value="1"  name="js-crabe"   > Oui
    
                                </label>
    
                               </div>



                      </td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Edinburgh
                          </option>
                          <option value="London">
                              London
                          </option>
                          <option value="New York">
                              New York
                          </option>
                          <option value="San Francisco">
                              San Francisco
                          </option>
                          <option value="Tokyo">
                              Tokyo
                          </option>
                      </select></td>
                      <td>
                        <input  type="number" size="1" id="row-1-office" name="row-1-office" >
                      </td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Edinburgh
                          </option>
                          <option value="London">
                              London
                          </option>
                          <option value="New York">
                              New York
                          </option>
                          <option value="San Francisco">
                              San Francisco
                          </option>
                          <option value="Tokyo">
                              Tokyo
                          </option>
                      </select></td>
                      <td><input  type="number" size="1" id="row-1-office" name="row-1-office" ></td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Edinburgh
                          </option>
                          <option value="London">
                              London
                          </option>
                          <option value="New York">
                              New York
                          </option>
                          <option value="San Francisco">
                              San Francisco
                          </option>
                          <option value="Tokyo">
                              Tokyo
                          </option>
                      </select></td>
                      <td><input  type="number" size="1" id="row-1-office" name="row-1-office" ></td>
                      <td> <button class="btn btn-default">Enregistrer</button> </td>
              </tr>
              <tr>
                      <td>Tino Mixon</td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Homme
                          </option>
                          <option value="London">
                              Femme
                          </option>
                          
                      </select></td>
                      <td>


                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-xs btn-outline-secondary  ">
                            
                                <input type="radio" value="0"    > Non
    
                                </label>
                                <label class="btn btn-xs btn-outline-secondary  ">
                            
                                <input type="radio" value="1"  name="js-crabe"   > Oui
    
                                </label>
    
                               </div>



                      </td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Edinburgh
                          </option>
                          <option value="London">
                              London
                          </option>
                          <option value="New York">
                              New York
                          </option>
                          <option value="San Francisco">
                              San Francisco
                          </option>
                          <option value="Tokyo">
                              Tokyo
                          </option>
                      </select></td>
                      <td>
                        <input  type="number" size="1" id="row-1-office" name="row-1-office" >
                      </td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Edinburgh
                          </option>
                          <option value="London">
                              London
                          </option>
                          <option value="New York">
                              New York
                          </option>
                          <option value="San Francisco">
                              San Francisco
                          </option>
                          <option value="Tokyo">
                              Tokyo
                          </option>
                      </select></td>
                      <td><input  type="number" size="1" id="row-1-office" name="row-1-office" ></td>
                      <td><select size="1" id="row-1-office" name="row-1-office">
                          <option value="Edinburgh" selected="selected">
                              Edinburgh
                          </option>
                          <option value="London">
                              London
                          </option>
                          <option value="New York">
                              New York
                          </option>
                          <option value="San Francisco">
                              San Francisco
                          </option>
                          <option value="Tokyo">
                              Tokyo
                          </option>
                      </select></td>
                      <td><input  type="number"  id="row-1-office" name="row-1-office" ></td>
                      <td> <button class="btn btn-default">Enregistrer</button> </td>
              </tr> -->
              </tbody>
              <tfoot class="text-center">
                    <tr>
                        <th>Pecheur</th>
                        <th>Sexe</th>
                        <th>crabe</th>
                        <th>Activité1</th>
                        <th>%</th>
                        <th>Activité2</th>
                        <th>%</th>
                        <th>Activité3</th>
                        <th>%</th>
                        <th>Actions</th>
                    </tr>
              </tfoot>
          <table>
      </div>
    </div>

      <!-- /.card -->

      

      <!-- /.card -->

      <!-- /.container-fluid -->

  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->
