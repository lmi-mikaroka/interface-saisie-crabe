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

        <a href="<?= site_url('saisie-de-fiche-enqueteur/saisie-enquete/' . $fiche['id']) ?>" class="btn btn-warning mb-2 mr-2">Poursuivre la saisie d'enquêtes</a>

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

                    <a class="btn btn-default" href="<?= site_url('modification-de-fiche-enqueteur/page-de-saisie/' . $enquete['id']) ?>">modifier</a>

                  <?php }

                    if ($autorisation_suppression && $enqueteur_responsable) { ?>

                      <button class="btn btn-default js-bouton-supprimer" data-target="<?= $enquete['id'] ?>">supprimer</button>

                    <?php } ?>

                </div>

              </div>

            </div>

            

            <!-- /.card-header -->

            <div class="card-body">

              <input type="text" hidden name="js-fiche" value="<?= $fiche['id'] ?>">

              <div class="row">

                <div class="col-md-3 col-sm-12">

                  <div class="form-group">

                    <label for="js-date">Date de l'enquête</label><br>

                    <span><?= $enquete["date_literalle"] ?></span>

                  </div>

                </div>

                <div class="col-md-3 col-sm-12">

                  <div class="form-group">

                    <label>Pêcheur</label><br>

                    <span><?= $enquete["pecheur_nom"] ?></span>

                  </div>

                </div>

                <div class="col-md-6 col-sm-12">

                  <div class="form-group">

                    <label>Accompagnateur du pêcheur et leur nombre</label><br>

                    <span class="text-capitalize"><?= $enquete["participant_individu"] ?></span> <?php if (intval($enquete["participant_nombre"]) > 0) { ?>

                      <span>: <?= $enquete["participant_nombre"] ?> </span> <?php } ?>

                  </div>

                </div>

              </div>

              <label class="text">♦ DERNIERES SORTIES DE PÊCHE AU COURS DES 4 DERNIERS JOURS</label>

              <p>

                Le champ "<b>Sortie</b>" correspond au nombre de sorties effectuées au jour indiqué au-dessus.<br>

                Le champ "<b>pirogue</b>" correspond au nombre de sorties où une pirogue a été utilisée.<br>

              </p>

              <div class="row">

                <?php foreach ($enquete["sortie_de_peche"] as $iteration_sortie_de_peche => $sortie_de_peche) { ?>

                  <div class="col-md-6 col-sm-12">

                    <div class="card">

                      <div class="card-header">

                        <label class="js-date-literalle">○ Activité le  <?= $sortie_de_peche["date_literalle"] ?></label>

                      </div>

                      <div class="card-body">

                        <div class="form-group">
                        <div class="row">
                          <div class="col-md-6">
                          <label for="js-derniere-sortie-de-peche-nombre">Nombre de Sortie(s)</label>: <span class="badge badge-secondary"><?= $sortie_de_peche["nombre"] ?></span>
                          </div>
                          <div class="col-md-6">
                          <label for="js-derniere-sortie-de-peche-pirogue">Sortie(s) avec Pirogue</label>: <span class="badge badge-secondary"><?= $sortie_de_peche["pirogue"] ?></span>
                          </div>
                        </div>
                        </div>

                        <div class="row">

                          <div class="col">

                            <div class="card">

                              <div class="card-header">

                                <h3 class="card-title">

                                  <label>Engin(s) de pêche</label>

                                </h3>

                              </div>

                              <div class="card-body">

                                <div class="row">

                                  <div class="col-md-6">

                                    <label>Premier engin</label><br>

                                    <?= intval($sortie_de_peche["engins"][0]["nombre"]) ? $sortie_de_peche["engins"][0]["nombre"] . " x " : "" ?> <?= $sortie_de_peche["engins"][0]["nom"] ?>

                                  </div>

                                  <div class="col-md-6">

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
              <div class="row">
              <label class="text">♦ DONNEES SUR LES CAPTURES OBSERVEES <span class="maintenant">LE <?= $enquete["date_literalle"] ?></span></label>
              </div>

              <div class="form-group">
                  <div class="row">
                  <div class="col-md-6">
                <label for="js-nombre-sortie-capture">Nombre de sorties de pêche de crabe</label>: <span class="badge badge-secondary"><?= $enquete["nombre_sortie_capture"] ?></span>
                  </div>
                  <div class="col-md-6">

                <label for="js-capture-poids-total">Poids total de la capture</label>: <span class="badge badge-secondary"><?= $enquete["capture_poids"] ?></span>
                  </div>
                  </div>
              </div>

              <label>Vente de crabe</label>

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

                              <span><?= $enquete["collecte_poids2"] ?> <small>Kg</small></span>

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

                          <span><?= $enquete["marche_local_poids"] ?> <small>Kg</small></span>

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

              <div class="row">

                <div class="col-md-6 col-sm-12">

                  <div class="form-group">

                    <label for="js-crabe-consomme-poids-total">Poids total des crabes consommés</label><br>

                    <span><?= $enquete["crabe_consomme_poids"] ?> <small>Kg</small></span>

                  </div>

                </div>

                <div class="col-md-6 col-sm-12">

                  <div class="form-group">

                    <label for="js-crabe-consomme-nombre">Nombre des crabes consommés</label><br>

                    <span><?php if ($enquete["crabe_consomme_nombre"] === null || $enquete["crabe_consomme_nombre"] === "") { ?>(Vide)<?php } else {

                        echo $enquete["crabe_consomme_nombre"];

                      } ?></span>

                  </div>

                </div>

              </div>

              <p class="text"><b>Échantillon</b><br>

                <span>L'échantillon

                  <?php if (intval($enquete["echantillon"]["trie"]) > 0) { ?>

                    <strong>est trié</strong> Les tailles absentes sont : <b>"

                    <?php

                    if (strtolower($enquete["echantillon"]["taille_absente"]) === "autre") {

                      echo $enquete["echantillon"]["taille_absente_autre"];

                    } else {

                      echo $enquete["echantillon"]["taille_absente"];

                    }

                  } else { ?>

                    n'est pas trié

                  <?php } ?></span>

              </p>

              <div class="card card-default collapsed-card">

                <div class="card-header">

                  <h3 class="card-title">CRABES MESURES</h3>

                  <div class="card-tools">

                    <button type="button" class="btn btn-tool" data-card-widget="collapse">

                      <i class="fas fa-plus"></i>

                    </button>

                  </div>

                </div>

                <div class="card-body">

                  <div class="row">

                    <?php foreach ($enquete['echantillon']['crabes'] as $iteration_crabe => $crabe) { ?>

                      <div class="col-sm-4 col-xs-12 d-flex align-items-stretch flex-column">

                        <div class="card">

                          <div class="card-header border-0">

                            <h3 class="card-title">Crabe N°<?= $iteration_crabe + 1 ?></h3>

                          </div>

                          <div class="card-body">

                            <div class="form-group">

                              <label>Destination</label><br>

                              <span class="text-capitalize">

                          <?php switch (intval($crabe['destination'])) {

                            case 1:

                              echo "Collecte";

                              break;

                            case 2:

                              echo "Marché local";

                              break;

                            default:

                              echo "Autoconsommation";

                              break;

                          } ?>

                          </span>

                            </div>

                            <div class="form-group">

                              <label for="js-donnees-biometrique-crabe-sexe<?= $iteration_crabe ?>">Sexe</label><br>

                              <span class="text-capitalize">

                          <?php switch ($crabe['sexe']) {

                            case "NR":

                              echo "Non renseigné";

                              break;

                            case "M":

                              echo "Male";

                              break;

                            case "NO":

                              echo "Femelle non-ovée";

                              break;

                            case "FO":

                              echo "Femelle ovée";

                              break;

                          } ?>

                          </span>

                            </div>

                            <div class="form-group">

                              <label for="js-donnees-biometrique-crabe-taille<?= $iteration_crabe ?>">Taille</label>

                              <span><?= $crabe["taille"] ?> <small>millimètre</small></span>

                            </div>

                          </div>

                        </div>

                      </div>

                    <?php } ?>

                  </div>

                </div>

                <!-- /.card-body -->

              </div>

              <div class="form-group">

                <label>Poids total de l'échantillon</label><br>

                <span><?= $enquete["echantillon"]["poids"] ?> <small>Kg</small></span>

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
