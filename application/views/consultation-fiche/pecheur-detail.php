<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            Fiche : <?= $fiche['code'] ?><?php if (isset($fiche['date_expedition_literalle']) && !empty($fiche['date_expedition_literalle'])) { ?> <br><small><i>Expédiée
                le : <?= $fiche['date_expedition_literalle'] ?></i></small><?php } else {
              echo ' <br><small>(<i>Pas encore enregistrée</i>)</small>';
            } ?>
          </h1>
        </div>
      </div>
      <?php if (isset($max_enquete) && isset($enquetes) && is_array($enquetes) && intval($max_enquete) > count($enquetes) && $autorisation_creation && $enqueteur_responsable) { ?>
        <a href="<?= site_url('saisie-de-fiche-pecheur/saisie-enquete/' . $fiche['id']) ?>" class="btn btn-warning mb-2 mr-2">Poursuivre la saisie d'enquêtes</a>
      <?php } ?>
    </div><!-- /.container-fluid -->
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="container">
      <?php if (isset($enquetes) && is_array($enquetes)) {
        foreach ($enquetes as $order => $enquete) { ?>
          <!-- /.card -->
          <div class="card">
            <div class="card-header  align-middle">
              <h1 class="card-title">Enquête numéro <?= $order + 1 ?></h1>
              <div class="card-tools">
                <div class="btn-group">
                  <?php if ($autorisation_modification && $enqueteur_responsable) { ?>
                    <a class="btn btn-default" href="<?= site_url('modification-de-fiche-pecheur/page-de-saisie/' . $enquete['id']) ?>">modifier</a>
                  <?php }
                    if ($autorisation_suppression && $enqueteur_responsable) { ?>
                      <button class="btn btn-default js-bouton-supprimer" data-target="<?= $enquete['id'] ?>">supprimer</button>
                    <?php } ?>
                </div>
              </div>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">
              <input type="text" name="js-fiche" hidden value="<?= $fiche['id'] ?>">
              <div class="row">
                <div class="col-sm-4 d-flex align-items-stretch flex-column">
                  <div class="card card-default d-flex flex-fill">
                    <div class="card-header">
                      <h3 class="card-title">
                        Dernière sortie de pêche
                      </h3>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="js-date">Date</label><br>
                        <span><?= $enquete["date_literalle"] ?></span>
                      </div>
                      <div class="form-group">
                        <label>Pêcheur(s)</label><br>
                        <span class="text-capitalize"><?= $enquete["partenaire_peche_individu"] ?></span> : <span><?= $enquete["partenaire_peche_nombre"] ?></span>
                      </div>
                      <div class="form-group">
                        <label>Avec pirogue</label>: <?= intval($enquete["avec_pirogue"]) ? "Oui" : "Non" ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 d-flex align-items-stretch flex-column">
                  <div class="card card-default d-flex flex-fill">
                    <div class="card-header">
                      <h3 class="card-title">
                        Engins de pêche
                      </h3>
                    </div>
                    <div class="card-body">
                      <?php
                        $engin_vue = array(
                            array("nom" => "", "nombre" => 0),
                            array("nom" => "", "nombre" => 0)
                        );
                        foreach ($engins as $engin) {
                          if (intval($engin["id"]) === intval($enquete["engins"][0]["engin"])) {
                            $engin_vue[0]["nom"] = $engin["nom"];
                            $engin_vue[0]["nombre"] = $enquete["engins"][0]["nombre"];
                          }
                          
                          if (intval($engin["id"]) === intval($enquete["engins"][1]["engin"])) {
                            $engin_vue[1]["nom"] = $engin["nom"];
                            $engin_vue[1]["nombre"] = $enquete["engins"][1]["nombre"];
                          }
                        }
                      ?>
                      <div class="row">
                        <div class="form-group">
                          <label>Premier engin</label><br>
                          <?= intval($engin_vue[0]["nombre"]) ? $engin_vue[0]["nombre"] . " x " : "" ?> <?= $engin_vue[0]["nom"] ?>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group">
                          <label>Deuxième engin</label><br>
                          <?= intval($engin_vue[1]["nombre"]) ? $engin_vue[1]["nombre"] . " x " : "" ?> <?= $engin_vue[1]["nom"] ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 d-flex align-items-stretch flex-column">
                  <div class="card card-default d-flex flex-fill">
                    <div class="card-header">
                      <h3 class="card-title">
                        Crabes consommés <small>(Kg/nombre)</small>
                      </h3>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="js-poids-crabe-consomme">Poids</label><br>
                        <span><?= $enquete["consommation_crabe_poids"] ?></span> <small>Kg</small>
                      </div>
                      <div class="form-group">
                        <label for="js-nombre-crabe-consomme">Nombre</label><br>
                        <span><?= $enquete["consommation_crabe_nombre"] ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-8 offset-sm-2">
                  <label class="text">Crabes vendus</label>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="card card-default">
                        <div class="card-header">
                          <h3 class="card-title">Destiné à la Collecte</h3>
                        </div>
                        <div class="card-body">
                          <div class="form-group">
                            <label for="js-collecte-poids">Poids</label><br>
                            <span><?= $enquete["collecte_poids"] ?></span> <small>Kg</small>
                          </div>
                          <div class="form-group">
                            <label for="js-collecte-prix">Prix</label><br>
                            <span><?= $enquete["collecte_prix"] ?></span> <small>Ariary/Kg</small>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="card card-default">
                        <div class="card-header">
                          <h3 class="card-title">Destiné au Marché local</h3>
                        </div>
                        <div class="card-body">
                          <div class="form-group">
                            <label for="js-marche-local-poids">Poids</label><br>
                            <span><?= $enquete["marche_local_poids"] ?></span> <small>Kg</small>
                          </div>
                          <div class="form-group">
                            <label for="js-marche-local-prix">Prix</label><br>
                            <span><?= $enquete["marche_local_prix"] ?></span> <small>Ariary/Kg</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="alert alert-danger alert-dismissible js-alerte-information-incorrecte" style="display: none;">
                    <h5><i class="icon fas fa-ban"></i> Information incorrecte!</h5>
                    <ul class="js-alerte-information-incorrecte-conteneur">
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        <?php }
      } ?>
      <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
