<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>

            Fiche : <?= $num ?>

             

          </h1>

        </div>
        <div class="col-md-6 ">
        <?php if ($autorisation_creation) { ?>

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
                <h3 class="card-title"> <span id='warning'></span> Enquête </h3>
            </div>
            <div class="card-body">

            <div class="card">
              <div class="card-body">
                <div class="row">
                 

                <input type='number' hidden id="js-recensement" value="<?= $recensement['id'] ?>" />
                <input type='number' hidden id="js-recensement-village" value="<?= $recensement['village'] ?>" />
                <div class="col-md-3" >
                    <div><label>Résident:       </label> </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-sm btn-outline-secondary  ">
                            
                                <input type="radio" value="0"  name="js-resident" onclick="change_resident()"  > Non
    
                                </label>
                                <label class="btn btn-sm btn-outline-secondary  ">
                            
                                <input type="radio" value="1"  name="js-resident" checked onclick="change_resident()" > Oui
    
                                </label>
    
                    </div>

                </div>

                <div class="col-md-3"  id="div-village-origine"  style='display:none' >
                    <div class="form-group w-75" >
                        <label>Village d'origine</label>
                        <select name="js-village-origine" id="js-village-origine" class="custom-select append-select1" onchange="change_village_origine()" >
                        <option value=''></option>
                            <?php foreach($villages as $village){ ?>
                                <option value='<?= $village['id'] ?>'><?= $village['nom'] ?></option>
                            <?php  } ?>

                        </select>
                       <input type='number' hidden name='nouveau-village-origine"' id="nouveau-village-origine">
                    </div>
                </div>

                <div class="col-md-3" >
                    <div class="form-group w-75">
                        <label>Pecheur(s)</label>
                        <select name="js-pecheur" id="js-pecheur" class="custom-select append-select1" onchange="change_pecheur()" >
                            <option value=''></option>
                            <?php foreach($pecheurs as $pecheur){ ?>
                                <option value='<?= $pecheur['id'] ?>'><?= $pecheur['nom'] ?></option>
                            <?php  } ?>
                        </select>
                        <input type='number' hidden name='nouveau-pecheur"' id="nouveau-pecheur">
                    </div>
                </div>

                <div class="col-md-3">
                
                  <label> Sexe <span id='warning-sexe'></span></label>
                  <div >

                    <input   type="radio" value="H" id="homme"  name="js-sexe" onclick="change_sexe()"  >
                    <label class="form-check-label" for="homme">Homme </label>
                    <input  class="ml-1" type="radio" value="F" id="femme"  name="js-sexe" onclick="change_sexe()"   > 
                    <label class="form-check-label" for="femme" >Femme</label>
                  
                  </div>

                </div>

                <div class="col-md-3">
                    <div class="form-group w-50" >
                    <label >Age</label>
                    <input type="number" id="js-age" name="js-age" class="custom-select" onkeyup="change_age()" />
                    </div>
                </div>


                <div class="col-md-3" >
                <div><label>Pirogue</label></div>

                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            
                            <label class="btn btn-sm btn-outline-secondary ">
                        
                            <input type="radio" value="0"  name="js-pirogue" checked onclick="change_pirogue()"  > Non

                            </label>
                            <label class="btn btn-sm btn-outline-secondary ">
                        
                            <input type="radio" value="1"  name="js-pirogue" onclick="change_pirogue()"  > Oui

                            </label>
                            <label class="btn btn-sm btn-outline-secondary  ">
                        
                            <input type="radio" value="2"  name="js-pirogue" onclick="change_pirogue()"  > Parfois

                            </label>
                                <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
    
                                </div>

                </div>

                <div class="col-md-3"  id="div-crabe-toute-annee" >

                    <div><label>Crabe toute l'année</label></div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    
                    <label class="btn btn-sm btn-outline-secondary ">
                            
                    <input type="radio" value="0"  name="js-toute-annee" checked onclick="change_toute_annee()"  > Non

                    </label>  
                    
                    <label class="btn btn-sm btn-outline-secondary ">
                            
                    <input type="radio" value="1"  name="js-toute-annee" onclick="change_toute_annee()" > Oui

                    </label> 
                    
                    <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                    </div>
                
                </div>

                <div class="col-md-3" id='div-periode-mois'    >
                  <div class="form-group w-50 " >
                    <label>Mois</label>
                  <select  multiple="multiple" class="custom-select append-select " id="js-periode-mois" name="js-periode-mois" onchange="change_valeur_periode_mois()">
                  <option value='' hidden></option>
                    <option value="1">Janvier</option>
                    <option value="2">Février</option>
                    <option value="3">Mars</option>
                    <option value="4">Avril</option>
                    <option value="5">Mai</option>
                    <option value="6">Juin</option>
                    <option value="7">Juillet</option>
                    <option value="8">Aout</option>
                    <option value="9">Septembre</option>
                    <option value="10">Octobre</option>
                    <option value="11">Novembre</option>
                    <option value="12">Décembre</option>
                    
                  </select>
                  </div>
                </div>

    
              </div>

              </div>
              </div>


            <div class="row ">

            <div class="col-md-4" >
              <div class="card card-warning card-outline" >
                <div class="card-header"><h6 class="card-title">Engins</h6></div>
                <div class="card-body" >



                <div class="row">
                <div class="col-md-8" >
                   <div class="form-group">
                        <label>Engin1</label>
                        <select class="custom-select" name="js-engin1" id="js-engin1" onchange="change_engin1()"  >
                            <option value='' hidden></option> 
                            
                            <?php foreach($engins as $engin){ if($engin['nom'] !=''){?>
                                
                                <option value='<?= $engin['id'] ?>'><?= $engin['nom'] ?></option>
                            <?php } } ?>
                            
                        </select>
                     </div>
                </div> 
                   
                <div class="col-md-4">
                    <div class="form-goup">
                        <label>Année1</label>

                        <select class="custom-select" id="js-annee1" name="js-annee1" onchange="change_annee1()" >
                        <option value="" selected hidden></option>
                            <option value="<?= $anneecourant ?>"><?= $anneecourant ?></option>
                            <?php $annee1 = intval($anneecourant); $anneedeb = intval($annee1) - 72; while ($annee1>$anneedeb){ ?>

                            <option value="<?= $annee1-1 ?>"><?= $annee1-1 ?></option>

                            <?php $annee1= $annee1 - 1; } ?>

                        </select>
                    </div>
                   
                </div>

                <div class="col-md-8">
                    <div class="form-group"> 
                        <label>Engin2</label>

                        <select class="custom-select" id="js-engin2" name="js-engin2" onchange="change_engin2()"  >
                        <option value='' hidden></option>
                        <?php foreach($engins as $engin){ if($engin['nom'] !=''){?>
                                
                                <option value='<?= $engin['id'] ?>'><?= $engin['nom'] ?></option>
                        <?php } } ?>
                        
                        </select>
                     </div>
                   
                </div>

                <div class="col-md-4">
                   
                    <div class="form-group">
                        <label>Année2</label>
                        <select class="custom-select" id="js-annee2" name="js-annee2" onchange="change_annee2()"  >
                        <option value="" selected hidden></option>
                            <option value="<?= $anneecourant ?>"><?= $anneecourant ?></option>
                            <?php $annee2 = intval($anneecourant); $anneedeb = intval($annee2) - 72;  while ($annee2>$anneedeb){ ?>

                            <option value="<?= $annee2 -1 ?>"><?= $annee2-1 ?></option>

                            <?php $annee2= $annee2 - 1; } ?>
                            
                         </select>
                    </div>
                   
                </div>
                </div>



                </div>
              </div>
            </div>
            <div class="col-md-8" >
            <div class="card card-warning card-outline" >
                <div class="card-header"><h6 class="card-title">Activités</h6></div>
                <div class="card-body" >

                    <div class="row">

                      <div class="col-md-6">

                          <div class="form-group">
                              <label>Activité1</label>
                              <select id="js-activite1" name="js-activite1" class="custom-select" onchange="change_activite1()" >
                                  <option value='' hidden  ></option>

                                  <?php foreach($activites as $activite){ ?>
                                      
                                      <option value='<?= $activite['id'] ?>'><?= $activite['nom'] ?></option>
                                  <?php  } ?>
                                  
                                  </select>
                          </div>
                    
                    </div>

                    <div class="col-md-6" >
                          <div class="form-group">
                              <label>Pourcentage</label>
                              <input type="number" id="js-activite1-pourcent" name="js-activite1-pourcent" class="form-control" onkeyup="change_pourcentage1()" />
                          </div>
                    </div>

                    <div class="col-md-4">
                          <div class="form-group">
                                  <label>Activité2</label>
                                  <select class="custom-select" id="js-activite2" name="js-activite2" onchange="change_activite2()" >
                                      <option value='' hidden></option>
                                      <?php foreach($activites as $activite){ ?>
                                      
                                      <option value='<?= $activite['id'] ?>'><?= $activite['nom'] ?></option>
                                  <?php  } ?>
                                      
                                  </select>

                          </div>
                          
                    </div>

                    <div class="col-md-2">
                          <div class="form-group">
                              <label>Pourcentage</label>
                              <input type="number" name="js-activite2-pourcent" id="js-activite2-pourcent" class="form-control" onkeyup="change_pourcentage2()" />
                          </div>
                    </div>

                    <div class="col-md-4 ">
                          <div class="form-group">
                                  <label>Activité3</label>
                                  <select class="custom-select" id="js-activite3" name="js-activite3" onchange="change_activite3()" >
                                      <option value='' hidden></option>
                                      <?php foreach($activites as $activite){ ?>
                                      
                                      <option value='<?= $activite['id'] ?>'><?= $activite['nom'] ?></option>
                                  <?php  } ?>
                                    
                                  </select>

                          </div>
                          
                    </div>

                    <div class="col-md-2">
                          <div class="form-group">
                              <label>Pourcentage</label>
                              <input type="number" name="js-activite3-pourcent" id="js-activite3-pourcent" class="form-control" onkeyup="change_pourcentage3()"  />
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
