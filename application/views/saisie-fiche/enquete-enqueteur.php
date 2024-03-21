<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <h1>Enquête de la fiche numéro "<?= $fiche['code'] ?>"</h1>

    </div><!-- /.container-fluid -->

  </section>

  

  <!-- Main content -->

  <section class="content">

    <div class="container mb-2">

      <div class="">

        <div class="card">

          <div class="card-body">

            <form autocomplete="off" id="js-formulaire">

              <input type="text" hidden name="js-fiche" value="<?= $fiche['id'] ?>">

              <div class="row">

                <div class="col-md-3 col-sm-12">

                  <div class="form-group">

                    <label for="js-date">Date de l'enquête<span class="text text-red">*</span></label>

                    <div class="input-group">

                      <select name="js-jour" id="js-jour" class="custom-select">

                        <option value="" hidden selected></option>

                        <?php for ($jours = 1; $jours <= $jours_max_du_mois; $jours++) { ?>

                          <option value="<?= $jours ?>"><?= $jours ?></option>

                        <?php } ?>

                      </select>

                      <div class="input-group-append"><span class="btn btn-default"><?= $mois_francais[intval($fiche['mois']) - 1] ?> <?= $fiche['annee'] ?></span></div>

                    </div>

                    <input type="date" name="js-date" class="form-control js-date" value="<?= $fiche['annee'] . '-' . (substr('0' . $fiche['mois'], -2)) . '-01' ?>" hidden>

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

                <div class="col-md-3 col-sm-12">

                  <div class="form-group">

                    <label>Pêcheur <span class="text text-red">*</span></label>

                    <select class="custom-select" name="js-pecheur">

                      <option value="" selected hidden></option>

                      <?php foreach ($pecheurs as $pecheur) { ?>

                        <option value="<?= $pecheur['id'] ?>"><?= $pecheur['nom'] ?></option>

                      <?php } ?>

                    </select>

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

                <div class="col-md-6 col-sm-12">

                  <div class="form-group">

                    <label>Accompagnateur du pêcheur et leur nombre <span class="text text-red">*</span></label>

                    <div class="input-group">

                      <select class="custom-select" name="js-individu-accompagnateur">

                        <option value="seul" selected>seul</option>

                        <option value="partenaire">femme/mari</option>

                        <option value="enfant">enfant(s)</option>

                        <option value="amis">amis</option>

                      </select>

                      <input min="0" type="number" value="0" class="form-control" name="js-nombre-accompagnateur" readonly>

                    </div>

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

              </div>

              <label class="text">♦ DERNIERES SORTIES DE PÊCHE AU COURS DES 4 DERNIERS JOURS</label>

              <p>

                Le champ "<b>Sortie</b>" correspond au nombre de sorties effectuées au jour indiqué au-dessus.<br>

                Le champ "<b>pirogue</b>" correspond au nombre de sorties où une pirogue a été utilisée.<br>

              </p>

              <div class="row">

                <?php for ($iteration = 0; $iteration < 4; $iteration++) { ?>

                  <div class="col-md-6 col-sm-12">

                    <div class="card">

                      <div class="card-header">

                        <label class="js-date-literalle"><?= $jours_nominaux[$iteration] ?></label>

                      </div>

                      <div class="card-body">

                        <div class="form-group">

                        <div class="row">

                          <div class="col-md-6">

                          <label for="js-derniere-sortie-de-peche-nombre">Nombre de sortie(s) <span class="text text-red">*</span></label><br>

                          <div class="btn-group btn-group-toggle" data-toggle="buttons">

                            <label class="btn btn-outline-secondary">

                              <input type="radio" value="0" name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off" checked> 0

                            </label>

                            <label class="btn btn-outline-secondary">

                              <input type="radio" value="1" name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off"> 1

                            </label>

                            <label class="btn btn-outline-secondary">

                              <input type="radio" value="2" name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off"> 2

                            </label>

                            <label class="btn btn-outline-secondary">

                              <input type="radio" value="3" name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off"> 3

                            </label>

                          </div>

                          </div>

                          <div class="col-md-6">

                          <label for="js-derniere-sortie-de-peche-pirogue">Sortie(s) avec pirogue <span class="text text-red">*</span></label><br>

                          <div class="btn-group btn-group-toggle" data-toggle="buttons">

                            <label class="btn btn-outline-secondary">

                              <input type="radio" value="0" name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>" autocomplete="off" checked> 0

                            </label>

                            <label class="btn btn-outline-secondary">

                              <input type="radio" value="1" name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>" autocomplete="off"> 1

                            </label>

                            <label class="btn btn-outline-secondary">

                              <input type="radio" value="2" name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>" autocomplete="off"> 2

                            </label>

                            <label class="btn btn-outline-secondary">

                              <input type="radio" value="3" name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>" autocomplete="off"> 3

                            </label>

                          </div>

                          </div>
                          </div>

                        </div>

                        <div class="form-group">

                          

                        </div>

                        <div class="row">

                          <div class="col-sm-6 col-xs-12">

                            <div class="card">

                              <div class="card-header">

                                <h3 class="card-title">

                                  <label>Engin n°1</label>

                                </h3>

                              </div>

                              <div class="card-body">

                                <div class="form-group">

                                  <label>Nom <span class="text-danger">*</span></label>

                                  <select class="custom-select table-cell-form" name="js-derniere-sortie-de-peche-premier-engin-nom<?= $iteration ?>">

                                    <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>

                                      <option value="<?= $engin['id'] ?>"><?= $engin['nom'] ?></option>

                                    <?php } ?>

                                  </select>

                                  <span class="form-text text-red" style="display: none;"></span>

                                </div>

                                <div class="form-group">

                                  <label>Nombre <span class="text-danger">*</span></label>

                                  <input type="number" class="form-control" name="js-derniere-sortie-de-peche-premier-engin-nombre<?= $iteration ?>" readonly="readonly" value="0">

                                  <span class="form-text text-red" style="display: none;"></span>

                                </div>

                              </div>

                            </div>

                          </div>

                          <div class="col-sm-6 col-xs-12">

                            <div class="card">

                              <div class="card-header">

                                <h3 class="card-title">

                                  <label>Engin n°2</label>

                                </h3>

                              </div>

                              <div class="card-body">

                                <div class="form-group">

                                  <label>Nom <span class="text-danger">*</span></label>

                                  <select class="custom-select table-cell-form" name="js-derniere-sortie-de-peche-deuxieme-engin-nom<?= $iteration ?>">

                                    <?php if (isset($engins) && is_array($engins)) foreach ($engins as $engin) { ?>

                                      <option value="<?= $engin['id'] ?>"><?= $engin['nom'] ?></option>

                                    <?php } ?>

                                  </select>

                                  <span class="form-text text-red" style="display: none;"></span>

                                </div>

                                <div class="form-group">

                                  <label>Nombre <span class="text-danger">*</span></label>

                                  <input type="number" class="form-control" name="js-derniere-sortie-de-peche-deuxieme-engin-nombre<?= $iteration ?>" readonly="readonly" value="0">

                                  <span class="form-text text-red" style="display: none;"></span>

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
              <label class="text">♦ DONNEES SUR LES CAPTURES OBSERVEES <span class="maintenant"></span></label>
              </div>

              <div class="form-group">

                <label for="js-nombre-sortie-capture">Nombre de sortie(s)<span class="text-danger">*</span></label>

                <input type="number" min="0" max="12" name="js-nombre-sortie-capture" id="js-nombre-sortie-capture" class="form-control">

                <span class="form-text text-red" style="display: none;"></span>

              </div>

              <div class="form-group">

                <label for="js-capture-poids-total">Poids total (Kg) de la capture toute(s) destination(s) <span class="text text-danger">*</span></label>

                <input type="number" class="form-control" name="js-capture-poids-total" id="js-capture-poids-total" max="100">

                <span class="form-text text-red" style="display: none;"></span>

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

                            <label for="js-collecte-poids">Poids 1 <span class="text-danger">*</span><small>(Kg)</small></label>

                            <input type="number" class="form-control" name="js-collecte-poids1">

                            <span class="form-text text-red" style="display: none;"></span>

                          </div>

                        </div>

                        <div class="col-md-6 col-sm-12">

                          <div class="form-group">

                            <label for="js-collecte-prix">Prix 1 <span class="text-danger">*</span><small>(Ariary/Kg)</small></label>

                            <input type="number" class="form-control" name="js-collecte-prix1" min="1000" max="20000" step="50">

                            <span class="form-text text-red" style="display: none;"></span>

                          </div>

                        </div>

                        <div class="col-md-6 col-sm-12">

                          <div class="form-group">

                            <label for="js-collecte-poids">Poids 2 <small>(Kg)</small></label>

                            <input type="number" class="form-control" name="js-collecte-poids2">

                            <span class="form-text text-red" style="display: none;"></span>

                          </div>

                        </div>

                        <div class="col-md-6 col-sm-12">

                          <div class="form-group">

                            <label for="js-collecte-prix">Prix 2 <small>(Ariary/Kg)</small></label>

                            <input type="number" class="form-control" name="js-collecte-prix2" min="0" max="20000" step="50">

                            <span class="form-text text-red" style="display: none;"></span>

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

                        <label for="js-marche-local-poids">Poids <span class="text-danger">*</span><small>(Kg)</small></label>

                        <input type="number" class="form-control" name="js-marche-local-poids">

                        <span class="form-text text-red" style="display: none;"></span>

                      </div>

                      <div class="form-group">

                        <label for="js-marche-local-prix">Prix <span class="text-danger" id="js-marche-local-prix-obligatoire">*</span><small>(Ariary/Kg)</small></label>

                        <input type="number" class="form-control" name="js-marche-local-prix" step="50">

                        <span class="form-text text-red" style="display: none;"></span>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col-md-6 col-sm-12">

                  <div class="form-group">

                    <label for="js-crabe-consomme-poids-total">Poids total des crabes consommés <span class="text text-danger">*</span><small>(Kg)</small></label>

                    <input type="number" class="form-control" name="js-crabe-consomme-poids-total" id="js-crabe-consomme-poids-total">

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

                <div class="col-md-6 col-sm-12">

                  <div class="form-group">

                    <label for="js-crabe-consomme-nombre">Nombre des crabes consommés</label>

                    <input type="number" class="form-control" name="js-crabe-consomme-nombre" id="js-crabe-consomme-nombre">

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

              </div>

              <p class="text"><b>Échantillon <span class="text text-red">*</span>:</b> est-ce que l'échantillon ci-dessous

                a été trié par le pêcheur suivant la

                taille de crabe?</p>

              <div class="form-group">

                <div class="form-check">

                  <input class="form-check-input" type="radio" name="js-echantillon-trie" id="js-echantillon-trie-non" value="false" checked>

                  <label class="form-check-label" for="js-echantillon-trie-non">Non</label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="radio" name="js-echantillon-trie" id="js-echantillon-trie-oui" value="true">

                  <label class="form-check-label" for="js-echantillon-trie-oui">Oui</label>

                </div>

                <div class="js-echantillon-trie-taille-absente-autre" style="display: none">

                  <label>Préciser les tailles absentes <span class="text text-red">*</span></label>

                  <div class="form-check">

                    <input class="form-check-input" type="radio" name="js-echantillon-trie-taille-absente" id="js-echantillon-trie-taille-absente-plus-gros" value="plus gros" checked>

                    <label class="form-check-label" for="js-echantillon-trie-taille-absente-plus-gros">Les plus gros</label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="radio" name="js-echantillon-trie-taille-absente" id="js-echantillon-trie-taille-absente-plus-petit" value="plus petit">

                    <label class="form-check-label" for="js-echantillon-trie-taille-absente-plus-petit">Les plus petits</label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="radio" name="js-echantillon-trie-taille-absente" id="js-echantillon-trie-taille-absente-autre" value="autre">

                    <label class="form-check-label" for="js-echantillon-trie-taille-absente-autre">Autres</label>

                  </div>

                  <div class="form-group">

                    <input type="text" placeholder="précision" class="form-control crab-other-size-precision" name="js-echantillon-trie-taille-absente-autre-precision" readonly>

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

              </div>

              <label>Nombre de crabes mesurés</label>

              <div class="form-group">

                <div class="input-group">

                  <input type="number" value="1" min="1" max="30" class="form-control" id="js-donnee-biometrique-taille-allouer">

                  <div class="input-group-append">

                    <button type="button" class="btn btn-default" id="js-donnee-biometrique-allouer">Ajouter des lignes</button>

                  </div>

                </div>

              </div>

              <div id="js-donnees-biometrique-crabe">

                <div class="row">

                  <div class="col-12 d-flex align-items-stretch flex-column" id="js-biometrie-crabe-ajouter">

                    <div type="button" class="card d-flex flex-fill">

                      <button type="button" class="btn btn-default btn-block" style="height: 100%;">

                        <i class="fa fa-plus"></i><br>

                        <span>Ajouter un crabe</span>

                      </button>

                    </div>

                  </div>

                </div>

              </div>

              <div class="form-group">

                <label for="js-echantillon-poids-total">Poids total de l'échantillon <small>(Kg)</small>:</label> laissez-le vide si <b>Non renseigné</b>

                <input type="number" class="form-control" name="js-echantillon-poids-total" id="js-echantillon-poids-total">

                <span class="form-text text-red" style="display: none;"></span>

              </div>

              <div class="alert alert-danger alert-dismissible js-alerte-information-incorrecte" style="display: none;">

                <h5><i class="icon fas fa-ban"></i> Information incorrecte!</h5>

                <ul class="js-alerte-information-incorrecte-conteneur">

                </ul>

              </div>

            </form>

          </div>

          <div class="card-footer clearfix">

            <?php if (intval($max_enquete) > intval($enquete_enregistrees) + 1) { ?>

              <button type="button" class="btn btn-warning" id="js-bouton-enregistrer-et-nouveau">

                Enregistrer et nouvelle Enquête

              </button>

            <?php } ?>

            <button type="button" class="btn btn-warning float-right" id="js-bouton-enregistrer">

              Enregistrer et cloturer la saisie

            </button>

          </div>

        </div>

      </div>

    </div>

    <!-- /.container-fluid -->

  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->
