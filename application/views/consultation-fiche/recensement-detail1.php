<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-12">

          <h1>

            Fiche : <?= $num ?>

             

          </h1>

        </div>

      </div>

      <?php if (is_array($enquetes) && 5 > count($enquetes) && $autorisation_creation) { ?>

        <a href="<?= site_url('recensement/saisie-manquant/' . $recensement['id']) ?>" class="btn btn-warning mb-2 mr-2">Poursuivre la saisie d'enquêtes</a>

      <?php } ?>

    </div><!-- /.container-fluid -->

  </section>

  <section class="content">
    <div class="container">

        

    <?php if (isset($enquetes) && is_array($enquetes)) {

      foreach ($enquetes as $order => $enquete) { ?>
       <div class="card">




          <div class="card-header  align-middle">

            <h1 class="card-title">Enquête numéro <?= $order + 1 ?>:

                <?php if($enquete["village_origine"] ==  $recensement["village"]){ ?>

                <span class="d-inline p-2 bg-warning  text-white rounded-circle">Résident</span>

                <?php } else{ ?>

                  <span class="d-inline p-2 bg-warning  text-white rounded-circle">Non Résident</span>

                <?php }  ?>
            </h1>

              <div class="card-tools">

                <div class="btn-group">

                  <?php if ($autorisation_modification ) { ?>

                    <a class="btn btn-default" href="<?= site_url('consultation-de-recensement/modification-enquete/' . $enquete['id']) ?>">modifier</a> 

                  <?php }

                    if ($autorisation_suppression ) { ?>

                      <button class="btn btn-default js-bouton-supprimer" data-target="<?= $enquete['id'] ?>">supprimer</button>

                    <?php } ?>

                </div>

              </div>

            </div>
            <div class="card-body">

              <input type="text" hidden name="js-fiche" value="<?= $recensement['id'] ?>">

              <div class="row">

                <div class="col-sm-12 ">

                    <div class="row" >
                        <div class='col-md-6' >
                            <table class="table table-sm table-bordered text-center">
                              <tr><td colspan="2" style='background-color:#e9ecef' >Information du pêcheur</td></tr>
                              <?php if ($enquete["village_origine"] !=  $recensement["village"]){ ?>
                              <tr><td >village d'origine</td><td> <?= $enquete['village_origine_nom'] ?></td></tr>
                              <?php } ?>
                              <tr><td >pecheur</td><td><?= $enquete['nom'] ?></td></tr>
                              <tr><td >Sexe</td><td><?php  switch($enquete['sexe']){
                                      case 'F': echo "Femme";
                                      break;
                                      case 'H': echo "Homme";
                                      break;
                                      default:
                                      echo "";
                                      break;
                             }?></td></tr>
                              <?php
                                    $dateNaissance = $enquete['datenais'];
                                    $aujourdhui = date("Y");
                                    $age = $aujourdhui - $dateNaissance;

                                  ?>
                              <tr><td >Age</td><td><?php if($enquete['datenais'] != ''){ ?><?= $age.' ans' ?><?php } ?></td></tr>
                              <tr><td >Pirogue</td><td><?php  switch($enquete['pirogue']){
                                      case 0: echo "Non";
                                      break;
                                      case 1: echo "Oui";
                                      break;
                                      case 2: echo "Parfois";
                                      break;
                                      default:
                                      echo "";
                                      break;
                             }?></td></tr>
                              
                              <tr><td >Période de pêche</td><td>
                              <?= $enquete['type_mare'].'('  ?>
                              <?php if($enquete['toute_annee']=='0'){
                                if($enquete['periode_mois'] !=null && $enquete['periode_mois'] !='' ){
                                  $periode_mois = json_decode($enquete['periode_mois']);
                                  foreach($periode_mois as $p){
                                      echo $mois_francais[intval($p)-1].' ';
                                  }
                                  
                                  }
                              }else{
                               echo 'Toute l\'année'; 
                              } echo ')' ?>
                              <!-- <?php if (($enquete["village_origine"] !=  $enquete["village_activite"])||($enquete["toute_annee"] ==  0)){ ?>
                                <?php if($enquete['periode_mois'] !=null){
                                $periode_mois = json_decode($enquete['periode_mois']);
                                foreach($periode_mois as $p){
                                    echo $mois_francais[intval($p)-1].' ';
                                }
                                
                                }echo $enquete['type_mare'] ; ?>
                                <?php }else{
                                  echo 'Toute l\'année';
                                } ?> -->
                              </td></tr>
                              


                              <tr><td colspan="2" style='background-color:#e9ecef' >Information du pêcheur</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-bordered text-center">
                                
                                <tbody>
                                    <tr><td colspan="2" style='background-color:#e9ecef' >Engins de pêche</td></tr>
                                    <?php foreach($enquete['engins'] as $engin){ ?>
                                        <tr><td ><?= $engin['engin_nom'] ?></td><td><?= $engin['annee'] ?></td></tr>
                                    <?php } ?>
                    
                                    <tr><td colspan="2" style='background-color:#e9ecef' >Activités du pêcheur</td></tr>
                                    <?php foreach($enquete['activites'] as $activite){ ?>
                                        <tr><td ><?= $activite['activite_nom'] ?></td><td><?= $activite['pourcentage'].' %' ?></td></tr>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
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
