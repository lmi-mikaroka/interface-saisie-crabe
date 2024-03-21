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
        <a href="<?= site_url('saisie-de-fiche-acheteur/saisie-enquete/' . $fiche['id']) ?>" class="btn btn-warning mb-2 mr-2">Poursuivre la saisie d'enquêtes</a>
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
                    <a class="btn btn-default" href="<?= site_url('modification-de-fiche-acheteur/page-de-saisie/' . $enquete['id']) ?>">modifier</a>
                  <?php }
                    if ($autorisation_suppression && $enqueteur_responsable) { ?>
                      <button class="btn btn-default js-bouton-supprimer" data-target="<?= $enquete['id'] ?>">supprimer</button>
                    <?php } ?>
                </div>
              </div>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="js-date">Date de l'enquête</label><br>
                    <span><?= $enquete["date_literalle"] ?></span>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Pêcheur et leur nombre</label><br>
                    <span><?= $enquete["pecheur"]["nom"] ?>: <?= $enquete["pecheur"]["nombre"] ?></span>
                  </div>
                </div>
              </div>
              <label class="text">Dernières sorties de pêches</label>
              <p>
                Le champ "<b>Sortie</b>" correspond au nombre de sorties effectuées au jour indiqué au-dessus.<br>
                Le champ "<b>pirogue</b>" corréspond au nombre de sorties où une pirogue a été utilisée.<br>
              </p>
              <div class="row">
                <?php foreach ($enquete["sortie_de_peche"] as $iteration_sortie_de_peche => $sortie_de_peche) { ?>
                  <div class="col-md-6 col-sm-12">
                    <div class="card">
                      <div class="card-header">
                        <label class="js-date-literalle"><?= $sortie_de_peche["date_literalle"] ?></label>
                      </div>
                      <div class="card-body">
                        <div class="form-group">
                          <label for="js-derniere-sortie-de-peche-nombre">Sortie</label>: <?= $sortie_de_peche["nombre"] ?><br>
                        </div>
                        <div class="form-group">
                          <label for="js-derniere-sortie-de-peche-pirogue">Pirogue</label>: <?= $sortie_de_peche["pirogue"] ?><br>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="card">
                              <div class="card-header">
                                <h3 class="card-title">
                                  <label>Engin de pêche</label>
                                </h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="form-group">
                                    <label>Premier engin</label><br>
                                    <?= intval($sortie_de_peche["engins"][0]["nombre"]) ? $sortie_de_peche["engins"][0]["nombre"] . " x " : "" ?> <?= $sortie_de_peche["engins"][0]["nom"] ?>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="form-group">
                                    <label>Deuxième engin</label><br>
                                    <?= intval($sortie_de_peche["engins"][1]["nombre"]) ? $sortie_de_peche["engins"][1]["nombre"] . " x " : "" ?> <?= $sortie_de_peche["engins"][1]["nom"] ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="js-nombre-sortie-vente">Nombre de sorties de vente de crabe</label><br>
                <span><?= $enquete["nombre_sortie_vente"] ?></span>
              </div>
              <label>Crabes vendus</label>
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="card card-default">
                    <div class="card-header">
                      <h3 class="card-title">Destiné à la Collecte</h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label for="js-collecte-poids">Poids 1</label><br>
                            <span><?= $enquete["collecte_poids1"] ?> <small>Kg</small></span>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label for="js-collecte-prix">Prix 1</label><br>
                            <span><?= $enquete["collecte_prix1"] ?> <small>Ariary/Kg</small></span>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label for="js-collecte-poids">Poids 2</label><br>
                            <?php if ($enquete["collecte_poids2"] === null || $enquete["collecte_poids2"] === "") { ?>
                              <span>(Vide)</span>
                            <?php } else { ?>
                              <span><?= $enquete["collecte_poids2"] ?> <small>Ariary/Kg</small></span>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label for="js-collecte-prix">Prix 2</label><br>
                            <?php if ($enquete["collecte_prix2"] === null || $enquete["collecte_prix2"] === "") { ?>
                              <span>(Vide)</span>
                            <?php } else { ?>
                              <span><?= $enquete["collecte_prix2"] ?> <small>Ariary/Kg</small></span>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="card card-default">
                    <div class="card-header">
                      <h3 class="card-title">Destiné au Marché local</h3>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="js-marche-local-poids">Poids</label><br>
                        <?php if ($enquete["marche_local_poids"] === null || $enquete["marche_local_poids"] === "") { ?>
                          <span>(Vide)</span>
                        <?php } else { ?>
                          <span><?= $enquete["marche_local_poids"] ?> <small>Ariary/Kg</small></span>
                        <?php } ?>
                      </div>
                      <div class="form-group">
                        <label for="js-marche-local-prix">Prix</label><br>
                        <?php if ($enquete["marche_local_prix"] === null || $enquete["marche_local_prix"] === "") { ?>
                          <span>(Vide)</span>
                        <?php } else { ?>
                          <span><?= $enquete["marche_local_prix"] ?> <small>Ariary/Kg</small></span>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="js-nombre-de-crabe-non-vendu">Nombre de crabes non vendus</label><br>
                <span><?= $enquete["crabe_non_vendu_nombre"] ?></span>
              </div>
              <div class="form-group">
                <label for="js-poids-de-crabe-non-vendu">Poids de crabes non vendus</label><br>
                <span><?= $enquete["crabe_non_vendu_poids"] ?> <small>Kg</small></span>
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
