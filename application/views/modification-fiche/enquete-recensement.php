<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col">

          <h1>Enquête de la fiche numéro "<?= $enquete['fiche']['code'] ?>"</h1> 

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>



  <!-- Main content -->

  <section class="content">

    <div class="container">



      <!-- /.card -->

      <div class="card card-default js-formulaire-card">

        <!-- /.card-header -->

        <div class="card-body">

          <form autocomplete="off" id="js-formulaire">

             <input type="text" name="js-enquete" hidden value="<?= $enquete['id'] ?>">

            <input type="text" name="js-fiche" hidden value="<?= $enquete['fiche']['id'] ?>">

            <input type="text" name="js-village-activite" hidden value="<?= $enquete['fiche']['village'] ?>">

            <!-- /.nouveau -->
            <div class="row">

              <div class="col-sm-8 offset-sm-1" >

                <div class="card card-default d-flex flex-fill">

                  <div class="card-header">

                    <h3 class="card-title">

                      Information sur le pêcheur

                    </h3>

                  </div>

                  <div class="card-body">

                  <div class="form-group">

                    <label for="js-date">Date <span class="text text-red">*</span></label>

                    <div class="input-group">

                      <select name="js-jour" id="js-jour" class="custom-select">

                        <option value="" hidden selected></option>

                        <?php for ($jours = 1; $jours <= $jours_max_du_mois; $jours++) { ?>

                          <option value="<?= $jours ?>" <?= $jours_enquete ? 'selected' : '' ?>> <?= $jours ?></option>

                        <?php } ?>

                      </select>

                      <div class="input-group-append"><span class="btn btn-default"><?= $mois_francais[intval($enquete['fiche']['mois']) - 1] ?> <?= $enquete['fiche']['annee'] ?></span></div>

                    </div>

                    <input type="date" name="js-date" class="form-control js-date" value="<?= $enquete['fiche']['annee'] . '-' . (substr('0' . $enquete['fiche']['mois'], -2)) . '-01' ?>" hidden>

                    <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                    </div>

                    <fieldset class="mb-3"> 

                        <div>

                          <input type="radio" id="resident" name="js-resident" value="1" <?= $enquete['resident'] == '1' ? 'checked' : '' ?> >
                          
                          <label for="resident">Resident</label> <span></span> <input type="radio" id="nonresident" class="ml-2" name="js-resident" value="0" <?= $enquete['resident'] == '0' ? 'checked' : '' ?> >
                          
                          <label for="nonresident">Non Resident</label>
                          
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
                        
                        </div>
                    
                      </fieldset>
                   <div class="row" >
                   
                   <div class="col-sm-4 " id="div-village-origine"<?php if($enquete['resident']==1){ ?> style="display:none"<?php } ?>>
                      <div class="form-group">

                         <label>Village d'orgine  <span class="text text-red">*</span></label>

                        <select name="js-village-origine" id="js-village-origine" class="custom-select">

                        <option value="" hidden selected></option>
                        
                          <?php foreach ($village_origines as $village_origine) { ?>

                          <option value="<?= $village_origine['id'] ?>" <?= $enquete['pecheur_village_origine'] == $village_origine['id']  ? 'selected' : '' ?>  ><?= $village_origine['nom'] ?></option>

                          <?php } ?>

                        </select>

                        <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                      </div>

                    </div>

                    <div class="col-sm-4">

                      <div class="form-group">

                         <label>Pêcheur(s) <span class="text text-red">*</span></label>

                        <select name="js-pecheur" id="js-pecheur" class="custom-select">

                            <option value="" selected hidden></option>

                            <?php foreach ($pecheurs as $pecheur) { ?>

                              <option value="<?= $pecheur['id'] ?>" <?= $enquete['pecheur'] == $pecheur['id'] ? 'selected' : '' ?>><?= $pecheur['nom'] ?></option>

                            <?php } ?>
                        </select>

                        <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                      </div>
                    </div>
                    <div class="col-sm-4">

                      <div class="form-group">

                         <label >Pirogue <span class="text text-red">*</span></label>

                         <div class="btn-group btn-group-toggle" data-toggle="buttons">

                          <label class="btn btn-outline-secondary">

                            <input type="radio" value="0" name="js-pirogue" autocomplete="off" <?= $enquete['pirogue'] == '0' ? 'checked' : '' ?>> Non

                          </label>

                          <label class="btn btn-outline-secondary">

                            <input type="radio" value="1" name="js-pirogue" autocomplete="off" <?= $enquete['pirogue'] == '1' ? 'checked' : '' ?>> Oui

                          </label>

                          <label class="btn btn-outline-secondary">

                            <input type="radio" value="2" name="js-pirogue" autocomplete="off" <?= $enquete['pirogue'] == '2' ? 'checked' : '' ?>> Parfois

                          </label>
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                          </div>

                      </div>
                    </div>
                    
                    <div class="col-sm-4" id="div-toute-annee" <?php if($enquete['resident']!=1){ ?> style="display:none"<?php } ?>>

                      <div class="form-group">

                         <label> Crabe Toute l'année <span class="text text-red">*</span></label>

                         <div class="btn-group btn-group-toggle" data-toggle="buttons">

                          <label class="btn btn-outline-secondary">

                            <input type="radio" value="0"  name="js-toute-annee" autocomplete="off" <?= $enquete['toute_annee'] == '0' ? 'checked' : '' ?> > Non

                          </label>

                          <label class="btn btn-outline-secondary">

                            <input type="radio" value="1"  name="js-toute-annee" autocomplete="off" <?= $enquete['toute_annee'] == '1' ? 'checked' : '' ?>> Oui

                          </label>

                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                          </div>
                      </div>
                    </div>
                    <div class=" col-sm-8" id="div-periode" <?php if(($enquete['resident']==1 && $enquete['toute_annee']==1)){ ?> style="display:none"<?php } ?>>
                      <div class="row">
                        <div class="col-sm-8 offset-sm-4">
                          <label class="ml-3">Période</label>
                        </div>
                        <div class="col-sm-5" >
                          <div class="form-group">

                          

                          <select name="js-date-debut" id="js-date-debut" class="custom-select">

                          <option value="" hidden selected></option>

                            <?php for ($mois = 1; $mois <= $nb_max_du_mois; $mois++) { ?>

                              <option value="<?= $mois ?>" <?= $enquete['datedebut'] == $mois ? 'selected' : '' ?>><?= $mois_francais[intval($mois) - 1] ?></option>

                            <?php } ?>

                          </select>

                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                          </div>
                        </div>
                        <div class="col-sm-1">
                          <strong>-</strong>
                        </div>
                        <div class="col-sm-5">
                          <div class="form-group">

                          <select name="js-date-fin" id="js-date-fin" class="custom-select">

                          <option value="" hidden selected></option>

                            <?php for ($mois = 1; $mois <= $nb_max_du_mois; $mois++) { ?>

                            <option value="<?= $mois ?>" <?= $enquete['datefin'] == $mois ? 'selected' : '' ?> ><?= $mois_francais[intval($mois) - 1] ?></option>

                            <?php } ?>
                          </select>

                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="col-sm-4" id="div-date-debut" >

                      
                    </div>
                    <div class="col-sm-4" id="div-date-fin">

                      
                    </div>

                   </div>
                    
                  </div>

                </div>

              </div>
              <div class="col-sm-3  " id="information-pecheur" >

                <div class="card mt-5   " >
                  
                  <div class="card-body" >

                  <div class="form-group"> 

                    <label for="pecheur-nom">Nom: </label>

                    <input type="text" class="form-control" name="pecheur-nom" id="pecheur-nom" value="<?= $information_pecheur['nom'] ?>" readonly>

                  </div>

                  <div class="form-group"> 

                    <label for="pecheur-datenais">Sexe: </label> 

                    <div class="form-group">

                      <input type="radio" id="masculin" name="pecheur-sexe" value="M" autocomplete="off"  <?=  $information_pecheur['sexe'] == 'M' ? 'checked' : '' ?> >

                      <label for="masculin">Masculin</label> <span></span> 

                      <input type="radio" id="F" class="ml-2" name="pecheur-sexe" autocomplete="off" value="F" <?= $information_pecheur['sexe'] == 'F' ? 'checked' : '' ?>>

                      <label for="feminin">Féminin</label>

                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                    </div>

                  </div>

                  <div class="form-group"> 

                    <label for="pecheur-datenais">Age: </label>

                    <?php
                              $dateNaissance = $information_pecheur['datenais'];
                              $age ='';
                              if($dateNaissance != null){

                                $aujourdhui = date("Y");

                                $age = $aujourdhui - $dateNaissance;

                              }
                              

                            ?> 
                    <input type="number" min="6" max="90" class="form-control" name="pecheur-datenais" id="pecheur-datenais" value="<?= $age ?>" >
                  </div>
  
                </div>
              </div>

            </div>
          <!-- /.fin nouveau-->

            <div class="row">


              <div class="col-sm-6 d-flex align-items-stretch flex-column">

                <div class="card card-default d-flex flex-fill">

                  <div class="card-header">

                    <h3 class="card-title">

                      Engins de pêche

                    </h3>

                  </div>

                  <div class="card-body">

                    <div class="row">

                      <div class="col-sm-7">

                        <div class="form-group">

                          <label>Premier engin <span class="text-danger">*</span></label>

                          <select class="custom-select table-cell-form material-selection" name="js-engin-de-peche-nom1">

                          <option value="" selected hidden></option>
                          
                          <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>

                              <option value="<?= $engin['id'] ?>" <?= $enquete['engins'][0]['engin'] == $engin['id']  ? 'selected' : '' ?> ><?= $engin['nom'] ?></option>

                            <?php } ?>

                          </select>
                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                        </div>

                      </div>

                      <div class="col-sm-5">

                        <div class="form-group">

                          <label>Année <span class="text-danger">*</span></label>

                          <select class="custom-select table-cell-form material-selection" name="js-engin-de-peche-annee1" >

                            <option value="" selected hidden></option>

                            <option value="<?= $anneecourant ?>"><?= $anneecourant ?></option>

                            <?php 
                            $annee1 = intval($anneecourant); $anneedeb = intval($annee1) - intval($maxannee);

                             while ($annee1>$anneedeb){ ?>

                            <option value="<?= $annee1-1 ?>" <?= $enquete['engins'][0]['annee'] == $annee1-1  ? 'selected' : '' ?>><?= $annee1-1 ?></option>

                            <?php $annee1= $annee1 - 1; } 
                            
                            ?>


                          </select>

                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                        </div>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col-sm-7">

                        <div class="form-group">

                          <label>Deuxième engin <span class="text-danger"></span></label>

                          <select class="custom-select table-cell-form material-selection" name="js-engin-de-peche-nom2">

                          <option value="" selected hidden></option>
                          
                          <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>

                              <option value="<?= $engin['id'] ?>" <?php if(count($enquete['engins'])>1){ ?> <?= $enquete['engins'][1]['engin'] == $engin['id']  ? 'selected' : '' ?> <?php } ?>><?= $engin['nom'] ?></option>

                            <?php } ?>

                          </select>

                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                        </div>

                      </div>

                      <div class="col-sm-5">

                        <div class="form-group">

                          <label>Année <span class="text-danger"></span></label>

                          <select class="custom-select table-cell-form material-selection" name="js-engin-de-peche-annee2" >

                            <option value="" selected hidden></option>

                            <option value="<?= $anneecourant ?>"><?= $anneecourant ?></option>

                            <?php 

                            $annee2 = intval($anneecourant); $anneedeb = intval($annee2) - intval($maxannee);

                            while ($annee2>$anneedeb){ ?>

                            <option value="<?= $annee2 -1 ?>" <?php if(count($enquete['engins'])>1){ ?> <?= $enquete['engins'][1]['annee'] == $annee2-1  ? 'selected' : '' ?> <?php } ?>><?= $annee2-1 ?></option>

                            <?php 
                            $annee2= $annee2 - 1; } 
                            ?>


                          </select>

                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                        </div>

                      </div>

                    </div>
                    <div class="row">

                      <div class="col-sm-7">

                        <div class="form-group">

                          <label>Troisième engin <span class="text-danger"></span></label>

                          <select class="custom-select table-cell-form material-selection" name="js-engin-de-peche-nom3">

                          <option value="" selected hidden></option>  
                          
                          <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>

                              <option value="<?= $engin['id'] ?>" <?php if(count($enquete['engins'])>2){ ?> <?= $enquete['engins'][2]['engin'] == $engin['id']  ? 'selected' : '' ?> <?php } ?>><?= $engin['nom'] ?></option>

                            <?php } ?>

                          </select>

                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>


                        </div>

                      </div>

                      <div class="col-sm-5">

                        <div class="form-group">

                          <label>Année <span class="text-danger"></span></label>

                          <select class="custom-select table-cell-form material-selection" name="js-engin-de-peche-annee3" >
                            <option value="" selected hidden></option>
                            <option value="<?= $anneecourant ?>"><?= $anneecourant ?></option>
                            <?php $annee3 = intval($anneecourant); $anneedeb = intval($annee3) - intval($maxannee);  while ($annee3>$anneedeb){ ?>

                            <option value="<?= $annee3 -1 ?>" <?php if(count($enquete['engins'])>2){ ?> <?= $enquete['engins'][2]['annee'] == $annee3-1  ? 'selected' : '' ?> <?php } ?>><?= $annee3-1 ?></option>

                            <?php $annee3= $annee3 - 1; } ?>


                          </select>

                          <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                        </div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

              <div class="col-sm-6 d-flex align-items-stretch flex-column">

                <div class="card card-default d-flex flex-fill">

                  <div class="card-header">

                    <h3 class="card-title">

                      Activité de pêcheur 

                    </h3>

                  </div>

                  <div class="card-body">

                    <div class="row"> 

                      <div class="col-sm-7">

                      <div class="form-group">

                        <label for="js-activite-primaire">Activité primaire <span class="text-danger">*</span></label>

                        <select class="custom-select table-cell-form material-selection" name="js-activite-primaire">

                        <option value="" selected hidden></option>

                          <?php foreach ($activites as $activite) { ?>

                            <option value="<?= $activite['id'] ?>" <?= $enquete['activite'][0]['activite'] == $activite['id']  ? 'selected' : '' ?>><?= $activite['id'].'-'.$activite['nom'] ?></option>

                          <?php } ?>
                        </select>

                        <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                        </div>
                      </div>
                      <div class="col-sm-5">

                      <div class="form-group">

                      <label for="js-activite-primaire-pourcent">Pourcentage (%) <span class="text-danger">*</span></label>

                      <input type="number" min="0" max="100" class="form-control" name="js-activite-primaire-pourcent" value="<?= $enquete['activite'][0]['pourcentage'] ?>">

                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                      </div>
                      </div>
                    </div>
                    <div class="row"> 

                      <div class="col-sm-7">

                      <div class="form-group">

                        <label for="js-activite-secondaire">Activité sécondaire <span class="text-danger"></span></label>
                        
                        <select class="custom-select table-cell-form material-selection" name="js-activite-secondaire">

                        <option value="" selected hidden></option>

                          <?php foreach ($activites as $activite) { ?>

                            <option value="<?= $activite['id'] ?>"<?php if (count($enquete['activite'])>1) { ?> <?= $enquete['activite'][1]['activite'] == $activite['id']  ? 'selected' : '' ?> <?php } ?>><?= $activite['id'].'-'.$activite['nom'] ?></option>

                          <?php } ?>
                        </select>

                        <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                        </div>
                      </div>
                      <div class="col-sm-5">

                      <div class="form-group">

                      <label for="js-activite-secondaire-pourcent">Pourcentage (%) <span class="text-danger"></span></label>

                      <input type="number" min="0" max="100" class="form-control" name="js-activite-secondaire-pourcent" <?php if(count($enquete['activite'])>1) { ?> value="<?= $enquete['activite'][1]['pourcentage'] ?>" <?php } ?>>
                      

                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                      </div>
                      </div>
                    </div>
                    <div class="row">

                      <div class="col-sm-7">
                        
                      <div class="form-group">

                        <label for="js-activite-tertiaire">Activité tertiaire <span class="text-danger"></span></label>

                        <select class="custom-select table-cell-form material-selection" name="js-activite-tertiaire">

                        <option value="" selected hidden></option>

                          <?php foreach ($activites as $activite) { ?>

                            <option value="<?= $activite['id'] ?>" 
                            <?php if(count($enquete['activite'])>2){ ?> <?= $enquete['activite'][2]['activite'] == $activite['id']  ? 'selected' : '' ?> <?php } ?>>
                            <?= $activite['id'].'-'.$activite['nom'] ?>
                          </option>

                          <?php } ?>

                        </select>

                        <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                        </div>
                      </div>
                      <div class="col-sm-5">

                      <div class="form-group">

                      <label for="js-activite-tertiaire-pourcent">Pourcentage (%) <span class="text-danger"></span></label>

                      <input type="number" min="0" max="100" class="form-control" name="js-activite-tertiaire-pourcent"  <?php if(count($enquete['activite'])>2) { ?> value="<?= $enquete['activite'][2]['pourcentage']  ?>" <?php } ?>>

                      <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                      </div>
                      </div>
                    </div>

                  </div>

                </div>

              </div>

            </div>

           

          </form>
          <div class="alert alert-danger alert-dismissible js-alerte-information-incorrecte" style="display: none;">

            <h5><i class="icon fas fa-ban"></i> Information incorrecte!</h5>

            <ul class="js-alerte-information-incorrecte-conteneur">

            </ul>

          </div>

        </div>

        <div class="card-footer clearfix">


          <button type="button" class="btn btn-warning float-right" id="js-bouton-enregistrer">

            Enregistrer et revenir à la liste

          </button>

        </div>

        <!-- /.card-body -->

      </div>

      <!-- /.card -->

      <!-- /.container-fluid -->

  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->
