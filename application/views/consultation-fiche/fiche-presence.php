<!-- Content Wrapper. Contains page content -->
<style>
  /* table > tbody > tr > td{
    border-bottom: 1px solid black;
} */
.btn-circle .btn-xs {
            width: 30px;
            height: 30px;
            padding: 6px 0px;
            border-radius: 15px;
            font-size: 8px;
            text-align: center;
        }
</style>
<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">
          <h1>Fiche de presence</h1>
        </div>
        <!-- <div class="col-sm-6">
            <span><button type="button" class="btn btn-warning float-right" id="enregistrer-nouvelle">Enregistrer et nouvelle enquête</button></span>
        </div> -->

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
        <div class="form-row">
            <div class="form-group col-md-2">
              <label for="mois1">Mois1 <span class="text text-red">*</span>:</label>
              <select name="mois1" id="mois1" class=" selectpicker custom-select" onchange="change_mois1()">
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="mois2">Mois2 <span class="text text-red">*</span>:</label>
              <select name="mois2" id="mois2" class=" selectpicker custom-select" onchange="change_mois2()">
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="js-zone-corecrabe">Zone corecrabe <span class="text text-red">*</span>:</label>
              <select name="js-zone-corecrabe" id="js-zone-corecrabe" class=" selectpicker custom-select">

                <option value="" hidden selected></option>

                <?php if (isset($zone_corecrabes) && is_array($zone_corecrabes)) foreach ($zone_corecrabes as $zone_corecrabe) { ?>

                  <option value="<?= $zone_corecrabe['id'] ?>"><?= $zone_corecrabe['id'] . ' - ' . $zone_corecrabe['nom'] ?></option>

                <?php } ?>

              </select>
            </div>
            <div class="form-group col-md-3">
                  <label for="js-village">Village <span class="text text-red">*</span>:</label>
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
            <div class="form-group col-md-2">
              <label for="inputPassword4">Date <span class="text text-red">*</span>:</label>
              <input type="date" name="js-date" type="number" class=" form-control selectpicker"id="js-date">
            </div>
        </div>


      </div>
    </div>

    <div id="conteneur_fiche"></div>
    <p id="info-validation-p"> <span class="bg-warning" id="info-validation" ></span><span id='ckeckignoreSpan' style="margin-left:10px;display:none"><input type="checkbox" name="checkIgnore" id="checkIgnore" onclick="change_ignore()" ><b style="margin-left:3px;">ignorer</b></span></p>
    <div class="card" id="table_pecheur" >
      <div class="card-body " id="table_pecheur_id">
          <table id="example"  class=" display table text-center " style="width:100%">
              <thead>
                      <th></th>
                      <th>#</th>
                      <th>Pecheur</th>
                      <th>01/21</th>
                      <th>02/21</th>
                      <th>03/21</th>
                      <th>04/21</th>
                      <th>05/21</th>
                      <th>06/21</th>
                      <th>07/21</th>
                      <th>08/21</th>
                      <th>09/21</th>
                      <th>10/21</th>
                      <th>11/21</th>
                      <th>12/21</th>
                      <th>01/22</th>
                      <th>02/22</th>
                      <th>03/22</th>
                      <th>04/22</th>
                      <th>05/22</th>
                      <th>06/22</th>
                      <th>07/22</th>
                      <th>08/22</th>
                      <th>09/22</th>
                      
                  </tr>
              </thead>
             
              <tbody id="body-table" >

              </tbody>
          <table>
          
      </div>
    </div>
    
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modification enquete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <input type="number" hidden name="index-pecheur" id="index-pecheur">
          <div class="form-group col-md-5">
            <label>Nom <span class="text text-red">*</span></label>
            <input class=" form-control"  id="nom-pecheur" disabled>
          </div>
          <div class="form-group col-md-5">
            <label>Mois <span class="text text-red">*</span></label>
            <select class="custom-select selectpicker" id="mois-edit" onchange="change_mois_edit()">
            </select>
          </div>
          <div class="form-group col-md-2 ">
                  <label>Crabe <span class="text text-red">*</span></label>
                  <select class="custom-select selectpicker" id="js-crabe" onchange="change_crabe_edit()">
                    <option value='' hidden selected></option>
                    <option value='0'>0</option>
                    <option value='1'>1</option>
                  </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Fermer</button>
        <button type="button" id="modification-presence"  class="btn btn-primary"><i class="fa fa-save mr-2"></i> Modifier</button>
      </div>
    </div>
  </div>
</div>


  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->