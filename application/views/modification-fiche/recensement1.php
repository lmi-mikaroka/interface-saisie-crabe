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
          <input type='number' id="js-recensement" hidden value="<?= $recensement['id'] ?>" />
        <span><button type="button" class="btn btn-warning float-right" id="enregistrer">Enregistrer et Lister</button></span>
                       
        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>
  <section class="content">
    <div class="container">
      <div class="card" >
          <div class="card-header" >
              <h3 class="card-title">modification de fiche</h3>
          </div>
          <div class="card-body">
          <div class="row">
              <div class="col-sm-6" style="border-right: 1px solid #ffc107" >
                <div class="row" style="display:flex; align-items: center">
                    <div class="col-md-6" ><h6 style="font-weight: bold">Zone corecrabe <span class="text text-red">*</span>:</h6></div>
                    <div class="col-md-6 mb-1" >
                        <input class=" form-control " id="js-zone-corecrabe" name="js-zone-corecrabe" readonly value="<?= $recensement['nomDistrict']!=null?$recensement['nomDistrict']:'Commune non renseigné' ?>">
                        
                    </div>
                    <div class="col-md-6" ><h6 style="font-weight: bold">Commune <span class="text text-red">*</span>:</h6></div>
                    <div class="col-md-6 mb-1" >
                        <input class="form-control" name="js-commune" id="champ-insertion-commune" readonly value="<?= $recensement['nomCommune'] ?>">   
                    </div>
                    <div class="col-md-6" ><h6 style="font-weight: bold">Fokontany <span class="text text-red">*</span>:</h6></div>
                    <div class="col-md-6 mb-1" >

                        <input class="form-control" name="js-fokontany" id="champ-insertion-fokontany" readonly value="<?= $recensement['nomFokontany'] ?>">   
                    </div>
                </div>
            </div>
            <div class="col-sm-6 " style="border-right: 1px solid #ffc107" >
                <div class="row" style="display:flex; align-items: center">
                    <div class="col-md-6" ><h6 style="font-weight: bold">Village <span class="text text-red">*</span>:</h6></div>
                    <div class="col-md-6 mb-1" >
                        <input class="form-control" name="js-village" id="champ-insertion-village" readonly value="<?= $recensement['nomVillage'] ?>">   
                        
                    </div>
                    <div class="col-md-6" ><h6 style="font-weight: bold">Date du récensement<span class="text text-red">*</span>:</h6></div>
                    <div class="col-md-6 mb-1" >
                        <input type="date" class="form-control" id="js-date-enquete" name="js-date-enquete" value="<?= $recensement['date'] ?>" onchange="change_date()"/>
                    </div>
                    
                    <div class="col-md-6" ><h6 style="font-weight: bold">Code Enqueteur:</h6></div>
                    <div class="col-md-6 mb-1" >
                        <select class="custom-select" id="js-enqueteur" name="js-enqueteur" onchange="change_enqueteur()"> 
                            <option value='' hidden></option>
                            <?php if(isset($enqueteurs)){
                              if($enqueteurs !=null){
                                foreach($enqueteurs as $enqueteur){
                                  ?> 
                                  <option value="<?= $enqueteur['id'] ?>" <?= $enqueteur['id']==$recensement['enqueteur']?'selected':'' ?>><?= $enqueteur['code'] ?></option>
                                  
                                  <?php 

                                }
                              }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </div>


    <div id="conteneur_fiche"></div>
 
    </div>
  </section>
</div>
