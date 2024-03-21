<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>

            Fiche : <?= $fiche['code'] ?><?php if (isset($fiche['date_expedition_literalle']) && !empty($fiche['date_expedition_literalle'])) { ?> <br><small><i>Expédiée le

                : <?= $fiche['date_expedition_literalle'] ?></i>

              </small><?php } else {

              echo ' <br><small>(<i>Pas encore enregistrée</i>)</small>';

            } ?>

          </h1>

        </div>

      </div>

      <?php if (is_array($enquetes) && intval($max_enquete) > count($enquetes) && $autorisation_creation && $enqueteur_responsable) { ?>

        <a href="<?= site_url('saisie-de-fiche-recensement/saisie-enquete/' . $fiche['id']) ?>" class="btn btn-warning mb-2 mr-2">Poursuivre la saisie d'enquêtes</a>

      <?php } ?>

    </div><!-- /.container-fluid -->

  </section>

  <section class="content">
    <div class="container">

    <?php if (isset($enquetes) && is_array($enquetes)) {

      foreach ($enquetes as $order => $enquete) { ?>
       <div class="card">


          <div class="card-header  align-middle">

              <h1 class="card-title">Enquête numéro <?= $order + 1 ?></h1>

              <div class="card-tools">

                <div class="btn-group">

                  <?php if ($autorisation_modification && $enqueteur_responsable) { ?>

                    <a class="btn btn-default" href="<?= site_url('modification-de-fiche-recensement/page-de-saisie/' . $enquete['id']) ?>">modifier</a>

                  <?php }

                    if ($autorisation_suppression && $enqueteur_responsable) { ?>

                      <button class="btn btn-default js-bouton-supprimer" data-target="<?= $enquete['id'] ?>">supprimer</button>

                    <?php } ?>

                </div>

              </div>

            </div>
            <div class="card-body">

              <input type="text" hidden name="js-fiche" value="<?= $fiche['id'] ?>">

              <div class="row">

                <div class="col-sm-8 offset-sm-2">

                  <div class="card">

                    <div class="card-header">

                      <h3 class="card-title"> Information du pêcheur</h3>

                      <div class="card-tools">

                      <label >Date de l'enquête:</label>

                            <span><?= $enquete["date_literalle"] ?></span>

                      </div>

                    </div>

                    <div class="card-body">

                      <div class="row">
                        
                        <div class="col-sm-6">

                            <label >Resident: </label>

                            <?php if($enquete["pecheur_village_origine"] ==  $enquete["pecheur_village_activite"]){ ?>

                            <span class="badge badge-secondary">Oui</span>

                            <?php } else{ ?>

                              <span class="badge badge-secondary">Non</span>

                              <?php }  ?>

                        </div>
                       <?php if ($enquete["pecheur_village_origine"] !=  $enquete["pecheur_village_activite"]){ ?> 
                        <div class="col-sm-6">

                            <label >Village d'origine: </label>

                            <span class="badge badge-secondary"><?= $enquete["village_origine_nom"] ?></span>

                        </div>
                      <?php } ?>

                        <div class="col-sm-6">

                            <label >Pecheur: </label>

                            <span class="badge badge-secondary"><?= $enquete["pecheur_nom"] ?></span>

                        </div>

                        <div class="col-sm-6">

                            <label >Sexe: </label>

                            <span class="badge badge-secondary">
                            <?php  switch($enquete['pecheur_sexe']){
                                      case 'M': echo "Masculin";
                                      break;
                                      case 'F': echo "Féminin";
                                      break;
                                      default:
                                      echo "";
                                      break;
                             }?> 
                              
                            </span>

                        </div>
                        <div class="col-sm-6">

                            <label >Age: </label>

                            <?php
                              $dateNaissance = $enquete['pecheur_datenais'];

                              $aujourdhui = date("Y");


                              $age = $aujourdhui - $dateNaissance;

                            ?>
                            <?php if($enquete['pecheur_datenais'] != ''){ ?>
                            <span id="age-pecheur" class="badge badge-secondary">
                              
                                 <?= $age.' ans' ?> 
                               
                              </span>
                              <?php } ?>
                        </div>
                        <div class="col-sm-6">

                            <label >Pirogue: </label>

                            <span class="badge badge-secondary">
                           <?php  switch($enquete['pirogue']){
                                      case 0: echo "Non";
                                      break;
                                      case 1: echo "Oui";
                                      break;
                                      case 2: echo "Parfois";
                                      break;
                                      default:
                                      echo "";
                                      break;
                             }?>
                            </span>

                        </div>
                        <?php if ($enquete["pecheur_village_origine"] ==  $enquete["pecheur_village_activite"]){ ?> 
                        <div class="col-sm-6">

                            <label >Toute année: </label>

                            <span class="badge badge-secondary">
                            <?php  switch($enquete['toute_annee']){
                                      case 0: echo "Non";
                                      break;
                                      case 1: echo "Oui";
                                      break;
                                      default:
                                      echo "";
                                      break;
                             }?>
                            </span>

                        </div>
                        <?php } ?>
                        <?php if (($enquete["pecheur_village_origine"] ==  $enquete["pecheur_village_activite"])||($enquete['toute_annee']==0)){ ?> 
                        <div class="col-sm-6">
                            <label >Periode: </label>
                            <span class="badge badge-secondary"><?= $mois_francais[intval($enquete['datedebut']) - 1].'-'.$mois_francais[intval($enquete['datefin']) - 1] ?></span>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Engin du pêcheur </h3>
                    </div>
                    <div class="card-body">

                    <div class="row">
                      
                      <?php foreach ($enquete["engins"] as $iteration_engin => $engin) { $i ?>
                      <div class="col-md-8 col-sm-12" >
                      <label class=""> <?=  $engin["engin_nom"] ?></label>
                      </div>
                      <div class="col-md-4 col-sm-12" >
                      <label class=""> <?=  $engin["annee"] ?></label>
                      </div>
                      
                    
                      <?php } ?>

                    </div>

                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12" >
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Activité du pêcheur </h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                      <?php foreach ($enquete["activite"] as $iteration_activite => $activite) { $i ?>
                        <div class="col-md-6 col-sm-12">
                          <label >
                          <?php 
                                    switch($iteration_activite){
                                      case 0: echo "1er";
                                      break;
                                      case 1: echo "2ème";
                                      break;
                                      case 2: echo "3ème";
                                      break;
                                      default:
                                      echo "";
                                      break;
                                      }?>
                            Activité 
                                
                          </label>:<span class=""><?= $activite["activite_nom"] ?></span> 
                        </div>
                        <div class="col-md-6 col-sm-12"> 
                        <label >Pourcentage</label>: <span class="badge badge-success"><?= $activite["pourcentage"].'%' ?></span><br>
                        </div>
                      <?php } ?>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>

       </div>

      <?php }

} ?>

    </div>
  </section>







  <!-- /.content -->

</div>

<!-- /.content-wrapper -->
