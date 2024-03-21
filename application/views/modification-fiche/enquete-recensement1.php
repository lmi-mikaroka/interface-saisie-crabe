<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>

            Fiche : <?= $num ?>

             <input type='number' id="resident-par-defaut" name="resident-par-defaut" hidden value="<?= $enquete['resident'] ?>">

          </h1>

        </div>
        <div class="col-md-6 ">
        <?php if (true) { ?>

        <button id="enregistrer"  class="btn btn-warning mb-2 float-right mr-2">Enregistrer</button>

        <?php } ?>
        </div>

      </div>

      

    </div><!-- /.container-fluid -->

  </section>

  <section class="content">
    <div class="container">


    <div class="card ">
            <div class="card-header" >
                <h3 class="card-title"> Enquête </h3>
            </div>
            <div class="card-body">
             <div class="card">
               <div class="card-body">
                <div class="row">

                <input type='number' hidden id="js-recensement" value="<?= $enquete['recensement']['id'] ?>" />
                <input type='number' hidden id="js-enquete-recensement" value="<?= $enquete['id'] ?>" />
                <input type='number' hidden id="js-recensement-village" value="<?= $enquete['recensement']['village'] ?>" />
                <div class="col-md-3" >
                   <div> <label>Résident:       </label> </div>
                    <div class="btn-group  btn-group-toggle" data-toggle="buttons">
                                <label class="btn  btn-sm   disabled <?= $enquete['resident']==0?'btn-secondary':'btn-outline-secondary' ?>  ">
                            
                                <input type="radio" value="0"  name="js-resident"  onclick="change_resident()" <?= $enquete['resident']==0?'checked':'' ?>   > Non
    
                                </label>
                                <label class="btn btn-sm disabled    <?= $enquete['resident']==1?'btn-secondary':'btn-outline-secondary' ?>  ">
                            
                                <input type="radio" value="1"  name="js-resident"   onclick="change_resident()" <?= $enquete['resident']==1?'checked':'' ?> > Oui
    
                                </label>
    
                    </div>

                </div>

                <div class="col-md-3"  id="div-village-origine" <?php if($enquete['resident']==1){?> style='display:none' <?php } ?> >
                    <div class="form-group w-75" >
                        <label>Village d'origine</label>
                        <select name="js-village-origine" id="js-village-origine" class="custom-select append-select1" onchange="change_village_origine()" disabled >
                        <option value=''></option>
                            <?php foreach($villages as $village){ ?>
                                <option value='<?= $village['id'] ?>' <?= $village['id']==$enquete['pecheur_village_origine']?'selected':'' ?>><?= $village['nom'] ?></option>
                            <?php  } ?>

                        </select>
                       <input type='number' hidden name='nouveau-village-origine"' id="nouveau-village-origine">
                    </div>
                </div>

                <div class="col-md-3" >
                    <div class="form-group w-75">
                        <label>Pecheur(s)</label>
                        <select name="js-pecheur" id="js-pecheur" class="custom-select append-select1" onchange="change_pecheur()" disabled >
                            <option value=''></option>
                            <?php foreach($pecheurs as $pecheur){ ?>
                                <option value='<?= $pecheur['id'] ?>' <?= $pecheur['id'] == $enquete['pecheur']?'selected':''  ?>><?= $pecheur['nom'] ?></option>
                            <?php  } ?>
                            
                        </select>
                        <input type='number' hidden name='nouveau-pecheur"' id="nouveau-pecheur">
                    </div>
                </div>

                <div class="col-md-3">
                
                  <label>Sexe</label>
                  <div >

                    <input   type="radio" value="H" id="homme"  name="js-sexe" onclick="change_sexe()"  <?= $enquete['sexe']=='H'?'checked':'' ?> >
                    <label class="form-check-label" for="homme">Homme </label>
                    <input  class="ml-1" type="radio" value="F" id="femme" <?= $enquete['sexe']=='F'?'checked':'' ?>  name="js-sexe" onclick="change_sexe()"   > 
                    <label class="form-check-label" for="femme" >Femme</label>
                  
                  </div>

                </div>

                <div class="col-md-3">
                    <div class="form-group w-75" >
                    <label >Age</label>
                    <?php
                      $dateNaissance = $enquete['datenais'];
                      $aujourdhui = date("Y");
                      $age = $aujourdhui - $dateNaissance;

                    ?>
                    <input type="number" id="js-age" name="js-age" class="custom-select" onkeyup="change_age()" value="<?= $age ?>" />
                    </div>
                </div>


                <div class="col-md-3" >
                <div><label>Pirogue</label></div>

                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            
                            <label class="btn btn-sm btn-outline-secondary ">
                        
                            <input type="radio" value="0" <?= $enquete['pirogue']=='0'?'checked':'' ?>  name="js-pirogue"  onclick="change_pirogue()"  > Non

                            </label>
                            <label class="btn btn-sm btn-outline-secondary ">
                        
                            <input type="radio" value="1" <?= $enquete['pirogue']=='1'?'checked':'' ?>  name="js-pirogue" onclick="change_pirogue()"  > Oui

                            </label>
                            <label class="btn btn-sm btn-outline-secondary  ">
                        
                            <input type="radio" value="2" <?= $enquete['pirogue']=='2'?'checked':'' ?>  name="js-pirogue" onclick="change_pirogue()"  > Parfois

                            </label>
                                <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
    
                                </div>

                </div>

                <div class="col-md-3"  id="div-crabe-toute-annee"  >

                    <div><label>Crabe toute l'année</label></div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    
                    <label class="btn btn-sm btn-outline-secondary ">
                            
                    <input type="radio" value="0" <?= $enquete['toute_annee']=='0'?'checked':'' ?>  name="js-toute-annee"  onclick="change_toute_annee()"  > Non

                    </label>  
                    
                    <label class="btn btn-sm btn-outline-secondary ">
                            
                    <input type="radio" value="1"  <?= $enquete['toute_annee']=='1'?'checked':'' ?>  name="js-toute-annee" onclick="change_toute_annee()" > Oui

                    </label> 
                    
                    <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                    </div>
                
                </div>

                <!-- <div class="col-md-3" id="div-periode"    >
                  <div class="form-group" >
                  <label>Période</label> 
                  <div >
                    <input  type="radio" value="mare" <?= $enquete['type_periode']=='mare'?'checked':'' ?>  id="js-mare" name="js-mare" onclick="change_periode()"  >
                    <label class="form-check-label" for="flexCheckDefault">
                        Marée
                    </label>
                    <input class="ml-2" type="radio" value="mois" <?= $enquete['type_periode']=='mois'?'checked':'' ?> id="js-mare1" name="js-mare" onclick="change_periode()"  >
                    <label class="form-check-label" for="flexCheckDefault">
                        Mois
                    </label>
                    </div>
                  </div>
                </div> -->
                <div class="col-md-3" id='div-periode-mois' <?php if($enquete['toute_annee']=='1'){ ?> style=' display:none' <?php } ?>   >
                  <div class="form-group w-50" >
                  <label>Periode</label>
                  <select  multiple="multiple" class="custom-select append-select " id="js-periode-mois" name="js-periode-mois" onchange="change_valeur_periode_mois()">
                  <option value='' hidden></option>
                  
                  <?php 
                  if($enquete['periode_mois'] != null){
                    $periode_mois = json_decode($enquete['periode_mois'],true);
                  }
                  else{
                    $periode_mois = [];
                  }
                  
                   ?>
                    <option value="1"  <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==1 ){
                        echo 'selected';
                      }
                    } ?> >Janvier</option>
                    <option value="2" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==2 ){
                        echo 'selected';
                      }
                    } ?>>Février</option>
                    <option value="3" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==3 ){
                        echo 'selected';
                      }
                    } ?>>Mars</option>
                    <option value="4" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==4 ){
                        echo 'selected';
                      }
                    } ?>>Avril</option>
                    <option value="5" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==5 ){
                        echo 'selected';
                      }
                    } ?>>Mai</option>
                    <option value="6" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==6 ){
                        echo 'selected';
                      }
                    } ?>>Juin</option>
                    <option value="7" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==7 ){
                        echo 'selected';
                      }
                    } ?>>Juillet</option>
                    <option value="8" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==8 ){
                        echo 'selected';
                      }
                    } ?>>Aout</option>
                    <option value="9" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==9 ){
                        echo 'selected';
                      }
                    } ?>>Septembre</option>
                    <option value="10" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==10 ){
                        echo 'selected';
                      }
                    } ?>>Octobre</option>
                    <option value="11" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==11 ){
                        echo 'selected';
                      }
                    } ?>>Novembre</option>
                    <option value="12" <?php foreach($periode_mois as $mois){
                      if(intval($mois) ==12 ){
                        echo 'selected';
                      }
                    } ?>>Décembre</option>
                  </select>
                  </div>
                </div>

                <!-- <div class="col-md-3" id='div-periode-mare' <?php if($enquete['type_periode']!='mare'){ ?> style=' display:none' <?php } ?>   >
                  <div class="form-group "  >
                  <label>Marée</label>
                  <select   class="custom-select append-select " id="js-periode-mare" name="js-periode-mare" onchange="change_valeur_periode_mare()">
                  <option value='' hidden></option>
                    <option value="Vives eaux" <?= $enquete['type_mare']=='Vives eaux'?'selected':'' ?> >Vives eaux</option>
                    <option value="Mortes eaux" <?= $enquete['type_mare']=='Mortes eaux'?'selected':'' ?> >Mortes eaux</option>
                  </select>
                  </div>
                </div> -->
    
    
              </div>

              </div>

              </div>


            <div class="row ">

             <div class="col-md-4" >
               <div class="card card-warning card-outline">
                 <div class="card-header"><h6 class="card-title">Engins</h6></div>
                 <div class="card-body">

                 <div class="row" >
                  <div class="col-md-8" >
                    <div class="form-group">
                          <label>Engin1</label>
                          <select class="custom-select" name="js-engin1" id="js-engin1" onchange="change_engin1()"  >
                              <option value='' hidden></option> 
                              
                              <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>

                            <option value="<?= $engin['id'] ?>"  <?= $enquete['engins'][0]['engin'] == $engin['id']  ? 'selected' : '' ?> ><?= $engin['nom'] ?></option>

                            <?php } ?>
                              
                          </select>
                      </div>
                  </div> 
                    
                  <div class="col-md-4">
                      <div class="form-goup">
                          <label>Année1</label>

                          <select class="custom-select" id="js-annee1" name="js-annee1" onchange="change_annee1()" >
                          <option value="" selected hidden></option>
                          

                          <?php 

                          $annee1 = intval($anneecourant); $anneedeb = intval($annee1) - 72;

                          while ($annee1>$anneedeb){ ?>

                          <option value="<?= $annee1  ?>" <?= $enquete['engins'][0]['annee'] == $annee1  ? 'selected' : '' ?> ><?= $annee1 ?></option>

                          <?php 
                          $annee1= $annee1 - 1; } 
                          ?>

                          </select>
                      </div>
                    
                  </div>

                  <div class="col-md-8">
                      <div class="form-group"> 
                          <label>Engin2</label>

                          <select class="custom-select" id="js-engin2" name="js-engin2" onchange="change_engin2()"  >
                          <option value='' hidden></option>
                          <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>

                          <option value="<?= $engin['id'] ?>" <?php if(count($enquete['engins'])>1){ ?> <?= $enquete['engins'][1]['engin'] == $engin['id']  ? 'selected' : '' ?> <?php } ?>><?= $engin['nom'] ?></option>

                          <?php } ?>
                          
                          </select>
                      </div>
                    
                  </div>

                  <div class="col-md-4">
                    
                      <div class="form-group">
                          <label>Année2</label>
                          <select class="custom-select" id="js-annee2" name="js-annee2" onchange="change_annee2()"  >
                          <option value="" selected hidden></option>
                              
                              <?php 

                              $annee2 = intval($anneecourant); $anneedeb = intval($annee2) - 72;

                              while ($annee2>$anneedeb){ ?>

                              <option value="<?= $annee2  ?>" <?php if(count($enquete['engins'])>1){ ?> <?= $enquete['engins'][1]['annee'] == $annee2  ? 'selected' : '' ?> <?php } ?>><?= $annee2?></option>

                              <?php 
                              $annee2= $annee2 - 1; } 
                              ?>

                              
                          </select>
                      </div>
                    
                  </div>


                 </div>

                 </div>
               </div>
             </div>
             <div class="col-md-8" >
                
                  <div class="card card-warning card-outline" >
                    <div class="card-header" ><h6 class="card-title">Activités</h6></div>
                    <div class="card-body">
                      <div class="row" >



                      <div class="col-md-6">

                        <div class="form-group">
                            <label>Activité1</label>
                            <select id="js-activite1" name="js-activite1" class="custom-select" onchange="change_activite1()" >
                                <option value='' hidden  ></option>

                                <?php foreach ($activites as $activite) { ?>

                                <option value="<?= $activite['id'] ?>" <?= $enquete['activite'][0]['activite'] == $activite['id']  ? 'selected' : '' ?>><?= $activite['nom'] ?></option>

                                <?php } ?>
                                
                                </select>
                        </div>

                        </div>

                        <div class="col-md-6" >
                        <div class="form-group">
                            <label>Pourcentage</label>
                            <input type="number" step="any" id="js-activite1-pourcent" name="js-activite1-pourcent" class="form-control" onkeyup="change_pourcentage1()" value="<?= $enquete['activite'][0]['pourcentage'] ?>" />
                        </div>
                        </div>

                        <div class="col-md-4">
                        <div class="form-group">
                                <label>Activité2</label>
                                <select class="custom-select" id="js-activite2" name="js-activite2" onchange="change_activite2()" >
                                    <option value='' hidden></option>
                                    <?php foreach ($activites as $activite) { ?>

                                      <option value="<?= $activite['id'] ?>"<?php if (count($enquete['activite'])>1) { ?> <?= $enquete['activite'][1]['activite'] == $activite['id']  ? 'selected' : '' ?> <?php } ?>><?= $activite['nom'] ?></option>

                                    <?php } ?>
                                    
                                </select>

                        </div>

                        </div>

                        <div class="col-md-2">
                        <div class="form-group">
                            <label>Pourcentage</label>
                            <input type="number" step="any" name="js-activite2-pourcent" id="js-activite2-pourcent" class="form-control" onkeyup="change_pourcentage2()" <?php if(count($enquete['activite'])>1) { ?> value="<?= $enquete['activite'][1]['pourcentage']  ?>" <?php } ?> />
                        </div>
                        </div>

                        <div class="col-md-4 ">
                        <div class="form-group">
                                <label>Activité3</label>
                                <select class="custom-select" id="js-activite3" name="js-activite3" onchange="change_activite3()" >
                                    <option value='' hidden></option>
                                    <?php foreach ($activites as $activite) { ?>

                                    <option value="<?= $activite['id'] ?>" 
                                    <?php if(count($enquete['activite'])>2){ ?> <?= $enquete['activite'][2]['activite'] == $activite['id']  ? 'selected' : '' ?> <?php } ?>>
                                    <?= $activite['nom'] ?>
                                    </option>

                                    <?php } ?>
                                  
                                </select>

                        </div>

                        </div>

                        <div class="col-md-2">
                        <div class="form-group">
                            <label>Pourcentage</label>
                            <input type="number" step="any" name="js-activite3-pourcent" id="js-activite3-pourcent" class="form-control" onkeyup="change_pourcentage3()" <?php if(count($enquete['activite'])>2) { ?> value="<?= $enquete['activite'][2]['pourcentage']  ?>" <?php } ?>  />
                        </div>
                        </div>



                      </div>
                    </div>
                  </div>

             </div>
               

            </div>

            </div>
        </div>





    </div>
  </section>







  <!-- /.content -->

</div>

<!-- /.content-wrapper -->
