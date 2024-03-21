<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <h1>Enquête de la fiche numéro "<?= $enquete['fiche']['code'] ?>"</h1>

    </div><!-- /.container-fluid -->

  </section>

  

  <!-- Main content -->

  <section class="content">

    

    <div class="container mb-2">

      <div class="">

        <div class="card">

          <div class="card-body">

            <form autocomplete="off" id="js-formulaire">

              <input type="text" name="js-fiche-enquete" hidden value="<?= $enquete['id'] ?>">

              <input type="text" name="js-fiche" hidden value="<?= $enquete['fiche']['id'] ?>">

              <div class="row">

                <div class="col-sm-3 col-xs-12">

                  <div class="form-group">

                    <label for="js-date">Date de l'enquête<span class="text text-red">*</span></label>

                    <div class="input-group">

                      <select name="js-jour" id="js-jour" class="custom-select">

                        <?php for ($jours = 1; $jours <= $jours_max_du_mois; $jours++) { ?>

                          <option value="<?= $jours ?>" <?= intval($jours_enquete) === $jours ? 'selected' : '' ?>><?= $jours ?></option>

                        <?php } ?>

                      </select>

                      <div class="input-group-append"><span class="btn btn-default"><?= $mois_francais[intval($enquete['fiche']['mois']) - 1] ?> <?= $enquete['fiche']['annee'] ?></span></div>

                    </div>

                    <input type="date" name="js-date" class="form-control js-date"

                           value="<?= $enquete['fiche']['annee'] . '-' . (substr('0' . $enquete['fiche']['mois'], -2)) . '-' . (substr('0' . intval($jours_enquete), -2)) ?>" hidden>

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

                <div class="col-sm-3 col-xs-12">

                  <div class="form-group">

                    <label>Pêcheur <span class="text text-red">*</span></label>

                    <select class="custom-select" name="js-pecheur">

                      <?php foreach ($pecheurs as $pecheur) { ?>

                        <option value="<?= $pecheur['id'] ?>" <?= $enquete['pecheur'] === $pecheur['id'] ? 'selected' : '' ?>><?= $pecheur['nom'] ?></option>

                      <?php } ?>

                    </select>

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

                <div class="col-sm-6 col-xs-12">

                  <div class="form-group">

                    <label>Accompagnateur du pêcheur et leur nombre <span class="text text-red">*</span></label>

                    <div class="input-group">

                      <select class="custom-select" name="js-individu-accompagnateur">

                        <option value="seul" <?= $enquete['participant_individu'] === 'seul' ? 'selected' : '' ?>>seul</option>

                        <option value="partenaire" <?= $enquete['participant_individu'] === 'partenaire' ? 'selected' : '' ?>>femme/mari</option>

                        <option value="enfant" <?= $enquete['participant_individu'] === 'enfant' ? 'selected' : '' ?>>enfant(s)</option>

                        <option value="amis" <?= $enquete['participant_individu'] === 'amis' ? 'selected' : '' ?>>amis</option>

                      </select>

                      <?php

                        $champ_partenaire_pecheur_nombre = array(

                            array('valeur' => 'seul', 'min' => 0, 'max' => 0, 'lectureSeul' => true),

                            array('valeur' => 'partenaire', 'min' => 1, 'max' => 1, 'lectureSeul' => true),

                            array('valeur' => 'enfant', 'min' => 1, 'max' => 5, 'lectureSeul' => false),

                            array('valeur' => 'amis', 'min' => 1, 'max' => 10, 'lectureSeul' => false),

                        );

                        

                        $min = 0;

                        $max = 0;

                        $readonly = '';

                        

                        foreach ($champ_partenaire_pecheur_nombre as $champ) {

                          if ($champ['valeur'] === $enquete['participant_individu']) {

                            $min = $champ['min'];

                            $max = $champ['max'];

                            $readonly = $champ['lectureSeul'] ? 'readonly' : '';

                          }

                        }

                      ?>

                      <input

                          min="<?= $min ?>"

                          max="<?= $max ?>"

                          type="number"

                          style="text-align: right;"

                          value="<?= $enquete['participant_nombre'] ?>"

                          class="form-control" <?= $readonly ?>

                          name="js-nombre-accompagnateur"

                      >

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

                <?php foreach ($enquete['sortie_de_peches'] as $iteration => $sortie_de_peche) { ?>

                  <div class="col-sm-6 col-xs-12">

                    <div class="card">

                      <div class="card-header">

                        <label class="js-date-literalle">○ Activité le  <?= $date_de_sortie[$iteration] ?></label>

                      </div>

                      <div class="card-body">

                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-6">
                              <label for="js-derniere-sortie-de-peche-nombre">Nombre de sortie(s) <span class="text text-red">*</span></label><br>

                              <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                <label class="btn btn-outline-secondary">

                                  <input type="radio" value="0" <?= $sortie_de_peche['nombre'] == '0' ? 'checked' : '' ?> name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off">

                                  0

                                </label>

                                <label class="btn btn-outline-secondary">

                                  <input type="radio" value="1" <?= $sortie_de_peche['nombre'] == '1' ? 'checked' : '' ?> name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off">

                                  1

                                </label>

                                <label class="btn btn-outline-secondary">

                                  <input type="radio" value="2" <?= $sortie_de_peche['nombre'] == '2' ? 'checked' : '' ?> name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off">

                                  2

                                </label>

                                <label class="btn btn-outline-secondary">

                                  <input type="radio" value="3" <?= $sortie_de_peche['nombre'] == '3' ? 'checked' : '' ?> name="<?= "js-derniere-sortie-de-peche-nombre$iteration" ?>" autocomplete="off">

                                  3

                                </label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label for="js-derniere-sortie-de-peche-pirogue">Sortie avec pirogue(s) <span class="text text-red">*</span></label><br>

                              <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                <label class="btn btn-outline-secondary">

                                  <input

                                      type="radio"

                                      value="0"

                                      <?= $sortie_de_peche['pirogue'] == '0' ? 'checked' : '' ?>

                                      name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>"

                                      autocomplete="off"

                                  > 0

                                </label>

                                <label class="btn btn-outline-secondary">

                                  <input

                                      type="radio"

                                      value="1"

                                      <?= $sortie_de_peche['pirogue'] == '1' ? 'checked' : '' ?>

                                      name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>"

                                      autocomplete="off"

                                  > 1

                                </label>

                                <label class="btn btn-outline-secondary">

                                  <input

                                      type="radio"

                                      value="2"

                                      <?= $sortie_de_peche['pirogue'] == '2' ? 'checked' : '' ?>

                                      name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>"

                                      autocomplete="off"

                                  > 2

                                </label>

                                <label class="btn btn-outline-secondary">

                                  <input

                                      type="radio"

                                      value="3"

                                      <?= $sortie_de_peche['pirogue'] == '3' ? 'checked' : '' ?>

                                      name="<?= "js-derniere-sortie-de-peche-pirogue$iteration" ?>"

                                      autocomplete="off"

                                  > 3

                                </label>
                              </div>
                            </div>
                          </div>
                        </div>

                        <?php

                          $ENGINS = array();

                          foreach ($engins as $engin) {

                            $ENGINS[strval($engin['id'])] = array(

                                'min' => intval($engin['min']),

                                'max' => intval($engin['max'])

                            );

                          }

                        ?>

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

                                      <option value="<?= $engin['id'] ?>" <?= $engin['id'] === $sortie_de_peche['engins'][0]['engin'] ? 'selected' : '' ?>><?= $engin['nom'] ?></option>

                                    <?php } ?>

                                  </select>

                                  <span class="form-text text-red" style="display: none;"></span>

                                </div>

                                <div class="form-group">

                                  <label>Nombre <span class="text-danger">*</span></label>

                                  <input

                                      min="<?= $ENGINS[strval($sortie_de_peche['engins'][0]['engin'])]['min'] ?>"

                                      max="<?= $ENGINS[strval($sortie_de_peche['engins'][0]['engin'])]['max'] ?>"

                                      type="number"

                                      class="form-control"

                                      name="js-derniere-sortie-de-peche-premier-engin-nombre<?= $iteration ?>"

                                      <?= $sortie_de_peche['engins'][0]['engin'] == $engins[0]['id'] ? 'readonly' : '' ?>

                                      value="<?= $sortie_de_peche['engins'][0]['nombre'] ?>">

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

                                      <option value="<?= $engin['id'] ?>" <?= $engin['id'] === $sortie_de_peche['engins'][1]['engin'] ? 'selected' : '' ?>><?= $engin['nom'] ?></option>

                                    <?php } ?>

                                  </select>

                                  <span class="form-text text-red" style="display: none;"></span>

                                </div>

                                <div class="form-group">

                                  <label>Nombre <span class="text-danger">*</span></label>

                                  <input

                                      min="<?= $ENGINS[strval($sortie_de_peche['engins'][1]['engin'])]['min'] ?>"

                                      max="<?= $ENGINS[strval($sortie_de_peche['engins'][1]['engin'])]['max'] ?>"

                                      type="number"

                                      class="form-control"

                                      name="js-derniere-sortie-de-peche-deuxieme-engin-nombre<?= $iteration ?>"

                                      <?= $sortie_de_peche['engins'][1]['engin'] == $engins[0]['id'] ? 'readonly' : '' ?>

                                      value="<?= $sortie_de_peche['engins'][1]['nombre'] ?>">

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
              <label class="text">♦ DONNEES SUR LES CAPTURES OBSERVEES <span class="maintenant">LE <?= $date_de_sortie[0] ?></span></label>
              </div>
              <div class="form-group">

                <label for="js-nombre-sortie-capture">Nombre de sortie(s) <span class="text-danger">*</span></label>

                <input type="number" min="0" max="12" name="js-nombre-sortie-capture" id="js-nombre-sortie-capture" class="form-control" value="<?= $enquete["nombre_sortie_capture"] ?>">

                <span class="form-text text-red" style="display: none;"></span>

              </div>

              <div class="form-group">

                <label for="js-capture-poids-total">Poids total (kg) de la capture toute(s) destination(s)<span class="text text-danger">*</span><small>(Kg)</small></label>

                <input type="number" class="form-control" name="js-capture-poids-total" id="js-capture-poids-total" max="100" value="<?= $enquete['capture_poids'] ?>">

                <span class="form-text text-red" style="display: none;"></span>

              </div>

              <label>Vente de crabe</label>

              <div class="row">

                <div class="col-sm-6 col-xs-12">

                  <div class="card card-default">

                    <div class="card-header">

                      <h3 class="card-title">Destiné à la Collecte</h3>

                    </div>

                    <div class="card-body">

                      <div class="row">

                        <div class="col-sm-6 col-xs-12">

                          <div class="form-group">

                            <label for="js-collecte-poids">Poids 1 <span class="text-danger">*</span><small>(Kg)</small></label>

                            <input type="number" class="form-control" name="js-collecte-poids1" value="<?= $enquete['collecte_poids1'] ?>">

                            <span class="form-text text-red" style="display: none;"></span>

                          </div>

                          <div class="form-group">

                            <label for="js-collecte-poids">Poids 2 <small>(Kg)</small></label>

                            <input type="number" class="form-control" name="js-collecte-poids2" value="<?= $enquete['collecte_poids2'] ?>">

                            <span class="form-text text-red" style="display: none;"></span>

                          </div>

                        </div>

                        <div class="col-sm-6 col-xs-12">

                          <div class="form-group">

                            <label for="js-collecte-prix">Prix 1 <span class="text-danger">*</span><small>(Ariary/Kg)</small></label>

                            <input type="number" class="form-control" name="js-collecte-prix1" min="1000" max="20000" step="50" value="<?= $enquete['collecte_prix1'] ?>">

                            <span class="form-text text-red" style="display: none;"></span>

                          </div>

                          <div class="form-group">

                            <label for="js-collecte-prix">Prix 2 <small>(Ariary/Kg)</small></label>

                            <input type="number" class="form-control" name="js-collecte-prix2" min="0" max="20000" step="50" value="<?= $enquete['collecte_prix2'] ?>">

                            <span class="form-text text-red" style="display: none;"></span>

                          </div>

                        </div>

                      </div>

                    </div>

                  </div>

                </div>

                <div class="col-sm-6 col-xs-12">

                  <div class="card card-default">

                    <div class="card-header">

                      <h3 class="card-title">Destiné au Marché local</h3>

                    </div>

                    <div class="card-body">

                      <div class="form-group">

                        <label for="js-marche-local-poids">Poids <span class="text-danger">*</span><small>(Kg)</small></label>

                        <input type="number" class="form-control" name="js-marche-local-poids" value="<?= $enquete['marche_local_poids'] ?>">

                        <span class="form-text text-red" style="display: none;"></span>

                      </div>

                      <div class="form-group">

                        <label for="js-marche-local-prix">Prix <span class="text-danger" id="js-marche-local-prix-obligatoire">*</span><small>(Ariary/Kg)</small></label>

                        <input type="number" class="form-control" name="js-marche-local-prix" min="400" max="20000" step="50" value="<?= $enquete['marche_local_prix'] ?>">

                        <span class="form-text text-red" style="display: none;"></span>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col-sm-6 col-xs-12">

                  <div class="form-group">

                    <label for="js-crabe-consomme-poids-total">Poids total des crabes consommés <span class="text text-danger">*</span></label>

                    <input type="number" class="form-control" name="js-crabe-consomme-poids-total" id="js-crabe-consomme-poids-total" value="<?= $enquete['crabe_consomme_poids'] ?>">

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

                <div class="col-sm-6 col-xs-12">

                  <div class="form-group">

                    <label for="js-crabe-consomme-nombre">Nombre des crabes consommés</label>

                    <input type="number" class="form-control" name="js-crabe-consomme-nombre" id="js-crabe-consomme-nombre" value="<?= $enquete['crabe_consomme_nombre'] ?>">

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

              </div>

              <p class="text"><b>Échantillon <span class="text text-red">*</span>:</b> est-ce que l'échantillon ci-dessous

                a été trié par le pêcheur suivant la

                taille de crabe?</p>

              <div class="form-group">

                <div class="form-check">

                  <input class="form-check-input" type="radio" <?= $enquete['echantillon']['trie'] !== 't' ? 'checked' : '' ?> name="js-echantillon-trie" id="js-echantillon-trie-non" value="false">

                  <label class="form-check-label" for="js-echantillon-trie-non">Non</label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="radio" <?= $enquete['echantillon']['trie'] === 't' ? 'checked' : '' ?> name="js-echantillon-trie" id="js-echantillon-trie-oui" value="true">

                  <label class="form-check-label" for="js-echantillon-trie-oui">Oui</label>

                </div>

                <div class="js-echantillon-trie-taille-absente-autre" style="display: <?= $enquete['echantillon']['trie'] === 't' ? 'block' : 'none' ?>">

                  <label>tailles absentes <span class="text text-red">*</span></label>

                  <div class="form-check">

                    <input class="form-check-input" type="radio" <?= $enquete['echantillon']['taille_absente'] === 'plus gros' ? 'checked' : '' ?> name="js-echantillon-trie-taille-absente"

                           id="js-echantillon-trie-taille-absente-plus-gros" value="plus gros">

                    <label class="form-check-label" for="js-echantillon-trie-taille-absente-plus-gros">Les plus gros</label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="radio" <?= $enquete['echantillon']['taille_absente'] === 'plus petit' ? 'checked' : '' ?> name="js-echantillon-trie-taille-absente"

                           id="js-echantillon-trie-taille-absente-plus-petit" value="plus petit">

                    <label class="form-check-label" for="js-echantillon-trie-taille-absente-plus-petit">Les plus petits</label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="radio" <?= $enquete['echantillon']['taille_absente'] === 'autre' ? 'checked' : '' ?> name="js-echantillon-trie-taille-absente"

                           id="js-echantillon-trie-taille-absente-autre" value="autre">

                    <label class="form-check-label" for="js-echantillon-trie-taille-absente-autre">Autre</label>

                  </div>

                  <div class="form-group">

                    <input type="text" placeholder="précision" class="form-control crab-other-size-precision" value="<?= $enquete['echantillon']['taille_absente_autre'] ?>"

                           name="js-echantillon-trie-taille-absente-autre-precision" <?= $enquete['echantillon']['taille_absente'] !== 'autre' ? 'readonly' : '' ?>>

                    <span class="form-text text-red" style="display: none;"></span>

                  </div>

                </div>

              </div>

              <label>Nombre de crabes mésurés</label>

              <div class="form-group">

                <div class="input-group">

                  <input type="number" value="<?= count($enquete['echantillon']['crabes']) ?>" min="<?= count($enquete['echantillon']['crabes']) ?>" max="30" class="form-control"

                         id="js-donnee-biometrique-taille-allouer">

                  <div class="input-group-append">

                    <button type="button" class="btn btn-default" id="js-donnee-biometrique-allouer">Ajouter une ligne</button>

                  </div>

                </div>

              </div>

              <div id="js-donnees-biometrique-crabe">

                <div class="row">

                  <?php foreach ($enquete['echantillon']['crabes'] as $iteration => $crabe) { ?>

                    <div class="col-sm-2 col-xs-12 d-flex align-items-stretch flex-column">

                      <div class="card">

                        <div class="card-header border-0">

                          <h3 class="card-title">Crabe N°<?= $iteration + 1 ?></h3>

                          <!-- tools card -->

                          <div class="card-tools">

                            <button type="button" class="btn btn-danger btn-sm" id="js-donnees-biometrique-crabe-fermer<?= $iteration ?>">

                              <i class="fas fa-times"></i>

                            </button>

                          </div>

                          <!-- /. tools -->

                        </div>

                        <div class="card-body">

                          <div class="form-group">

                            <label for="js-donnees-biometrique-crabe-destination<?= $iteration ?>">Destination</label>

                            <select name="js-donnees-biometrique-crabe-destination<?= $iteration ?>" id="js-donnees-biometrique-crabe-destination<?= $iteration ?>" class="custom-select">

                              <option value="1" <?= $crabe['destination'] === '1' ? 'selected' : '' ?>>Collecte</option>

                              <option value="2" <?= $crabe['destination'] === '2' ? 'selected' : '' ?>>Marché local</option>

                              <option value="3" <?= $crabe['destination'] === '3' ? 'selected' : '' ?>>Autoconsommation</option>

                            </select>

                          </div>

                          <div class="form-group">

                            <label for="js-donnees-biometrique-crabe-sexe<?= $iteration ?>">Sexe</label>

                            <select name="js-donnees-biometrique-crabe-sexe<?= $iteration ?>" id="js-donnees-biometrique-crabe-sexe<?= $iteration ?>" class="custom-select">

                              <option value="NR" <?= $crabe['sexe'] === 'NR' ? 'selected' : '' ?>>Non renseigné</option>

                              <option value="M" <?= $crabe['sexe'] === 'M' ? 'selected' : '' ?>>Mâle</option>

                              <option value="NO" <?= $crabe['sexe'] === 'NO' ? 'selected' : '' ?>>Femelle non-ovée</option>

                              <option value="FO" <?= $crabe['sexe'] === 'FO' ? 'selected' : '' ?>>Femelle ovée</option>

                            </select>

                          </div>

                          <div class="form-group">

                            <label for="js-donnees-biometrique-crabe-taille<?= $iteration ?>">Taille<span class="text text-red">*</span></label>

                            <input type="number" value="<?= $crabe['taille'] ?>" min="30" max="250" class="form-control" name="js-donnees-biometrique-crabe-taille<?= $iteration ?>"

                                   id="js-donnees-biometrique-crabe-taille<?= $iteration ?>">

                            <span class="form-text text-red" style="display: none;"></span>

                          </div>

                        </div>

                      </div>

                    </div> <?php } ?>

                  <?php if (count($enquete['echantillon']['crabes']) < 30) { ?>

                    <div class="col-sm-<?= count($enquete['echantillon']['crabes']) % 6 == 0 ? 12 : 2 ?> col-xs-12 d-flex align-items-stretch flex-column" id="js-biometrie-crabe-ajouter">

                      <div type="button" class="card d-flex flex-fill">

                        <button type="button" class="btn btn-default btn-block" style="height: 100%;">

                          <i class="fa fa-plus"></i><br>

                          <span>Ajouter un crabe</span>

                        </button>

                      </div>

                    </div>

                  <?php } ?>

                </div>

              </div>

              <div class="form-group">

                <label for="js-echantillon-poids-total">Poids total de l'échantillon <small>(Kg)</small>:</label> laissez-le vide si <b>Non renseigné</b>

                <input type="number" class="form-control" name="js-echantillon-poids-total" id="js-echantillon-poids-total" value="<?= $enquete['echantillon']['poids'] ?>">

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

            <button type="button" class="btn btn-warning float-right" id="js-bouton-enregistrer">

              Enregistrer

            </button>

          </div>

        </div>

      </div>

    </div>

  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->