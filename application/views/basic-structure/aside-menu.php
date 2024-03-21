<aside class="main-sidebar sidebar-light-warning elevation-4">

  <!-- Brand Logo -->

  <a href="/corecrabe" class="brand-link">

      <img src="<?= img_url('icon.gif') ?>" alt="Logo c" class="brand-image img-circle elevation-3" style="opacity: .8">

    <span class="brand-text font-weight-light">Plateforme de saisie</span>

  </a>

  

  <!-- Sidebar -->

  <div class="sidebar">

    <!-- SidebarSearch Form -->

    <div class="form-inline mt-3 pb-3 mb-3 d-flex">

      <div class="input-group" data-widget="sidebar-search">

        <input class="form-control form-control-sidebar" type="search" placeholder="Recherche" aria-label="Search">

        <div class="input-group-append">

          <button class="btn btn-sidebar">

            <i class="fas fa-search fa-fw"></i>

          </button>

        </div>

      </div>

    </div>

    

    <!-- Sidebar Menu -->

    <nav class="mt-2">

      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Add icons to the links using the .nav-icon class

		 with font-awesome or any other icon font library -->

        <?php if ($this->lib_autorisation->visualisation_autorise(1)) { ?>

          <li class="nav-item <?= route_active(array('edition-de-zone/zone-corecrabe', 'edition-de-zone/region', 'edition-de-zone/district', 'edition-de-zone/commune', 'edition-de-zone/fokontany', 'edition-de-zone/village'), isset($active_route) && !empty($active_route) ? $active_route : '', 'menu-is-opening menu-open') ?>">

            <a href="#"

               class="nav-link <?= route_active(array('edition-de-zone/zone-corecrabe', 'edition-de-zone/region', 'edition-de-zone/district', 'edition-de-zone/commune', 'edition-de-zone/fokontany', 'edition-de-zone/village'), isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

              <i class="nav-icon fas fa-map-marker-alt"></i>

              <p>

                Édition de zone

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <?php if ($this->lib_autorisation->visualisation_autorise(2)) { ?>

                <li class="nav-item">

                  <a href="/corecrabe/edition-de-zone/zone-corecrabe.html"

                     class="nav-link <?= route_active('edition-de-zone/zone-corecrabe', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                    <i class="far fa-circle nav-icon"></i>

                    <p>Zone</p>

                  </a>

                </li>

              <?php }

                if ($this->lib_autorisation->visualisation_autorise(3)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/edition-de-zone/region.html" class="nav-link <?= route_active('edition-de-zone/region', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Région</p>

                    </a>

                  </li>

                <?php }

                if ($this->lib_autorisation->visualisation_autorise(4)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/edition-de-zone/district.html" class="nav-link <?= route_active('edition-de-zone/district', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>District</p>

                    </a>

                  </li>

                <?php }

                if ($this->lib_autorisation->visualisation_autorise(5)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/edition-de-zone/commune.html" class="nav-link <?= route_active('edition-de-zone/commune', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Commune</p>

                    </a>

                  </li>

                <?php }

                if ($this->lib_autorisation->visualisation_autorise(6)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/edition-de-zone/fokontany.html" class="nav-link <?= route_active('edition-de-zone/fokontany', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Fokontany</p>

                    </a>

                  </li>

                <?php }

                if ($this->lib_autorisation->visualisation_autorise(7)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/edition-de-zone/village.html" class="nav-link <?= route_active('edition-de-zone/village', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Village</p>

                    </a>

                  </li>

                <?php } ?>

            </ul>

          </li>

        <?php } ?>

        <?php if ($this->lib_autorisation->visualisation_autorise(25)) { ?>

          <li class="nav-item <?= route_active(array('saisie-de-fiche-enqueteur', 'saisie-de-fiche-pecheur', 'saisie-de-fiche-acheteur', 'saisie-de-fiche-societe','recensement-ajout','saisie-de-fiche-recensement-mensuel','saisie-de-fiche-presence'), isset($active_route) && !empty($active_route) ? $active_route : '', 'menu-is-opening menu-open') ?>">

            <a href="#"

               class="nav-link <?= route_active(array('saisie-de-fiche-enqueteur', 'saisie-de-fiche-pecheur', 'saisie-de-fiche-acheteur', 'saisie-de-fiche-societe','recensement-ajout','saisie-de-fiche-recensement-mensuel','saisie-de-fiche-presence'), isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

              <i class="nav-icon fas fa-pen"></i>

              <p>

                Saisie des fiches

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <?php if ($this->lib_autorisation->visualisation_autorise(8)) { ?>

                <li class="nav-item">

                  <a href="/corecrabe/saisie-de-fiche-enqueteur.html" class="nav-link <?= route_active('saisie-de-fiche-enqueteur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                    <i class="far fa-circle nav-icon"></i>

                    <p>Enquêteur</p>

                  </a>

                </li>

              <?php }

                if ($this->lib_autorisation->visualisation_autorise(9)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/saisie-de-fiche-pecheur.html" class="nav-link <?= route_active('saisie-de-fiche-pecheur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Pêcheur</p>

                    </a>

                  </li>

                <?php }

                if ($this->lib_autorisation->visualisation_autorise(10)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/saisie-de-fiche-acheteur.html" class="nav-link <?= route_active('saisie-de-fiche-acheteur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Acheteur</p>

                    </a>

                  </li>

                <?php } ?>
                <?php

                if ($this->lib_autorisation->visualisation_autorise(37)) { ?>

                  <li class="nav-item">

                    <a href="<?=base_url('suivi-societe-ajout.html');?>" class="nav-link <?= route_active('saisie-de-fiche-societe', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Société de collecte</p>

                    </a>

                  </li>

                <?php } ?>
                <?php

              if ($this->lib_autorisation->visualisation_autorise(10)) { ?>

                <li class="nav-item <?= route_active(array('recensement-ajout','saisie-de-fiche-recensement-mensuel','saisie-de-fiche-presence'), isset($active_route) && !empty($active_route) ? $active_route : '', 'menu-is-opening menu-open') ?>" >

                    <a href="#" class="nav-link <?= route_active(array('recensement-ajout','saisie-de-fiche-recensement-mensuel','saisie-de-fiche-presence'), isset($active_route) && !empty($active_route) ? $active_route : '') ?>" >
                      <i class=" far fa-circle nav-icon"></i>
                      <p>
                        Récensement
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/corecrabe/recensement-ajout.html"  class="nav-link <?= route_active('recensement-ajout', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">
                          <i class="fas fa-circle nav-icon"></i>
                          <p>Fiche N° 5</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/corecrabe/saisie-de-fiche-recensement-mensuel.html" class="nav-link <?= route_active('saisie-de-fiche-recensement-mensuel', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">
                          <i class="fas fa-circle nav-icon"></i>
                          <p>Fiche N° 6</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/corecrabe/fiche-presence/saisie_enquete.html" class="nav-link <?= route_active('saisie-de-fiche-presence', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">
                          <i class="fas fa-circle nav-icon"></i>
                          <p>Fiche de presence</p>
                        </a>
                      </li>
                    </ul>
                  </li>

              <?php } ?>

            </ul>

          </li>

        <?php }

          if ($this->lib_autorisation->visualisation_autorise(28)) { ?>

            <li class="nav-item <?= route_active(array('consultation-de-fiche-enqueteur', 'consultation-de-fiche-acheteur', 'consultation-de-fiche-pecheur', 'consultation-de-fiche-societe', 'consultation-de-fiche-recensement','consultation-de-fiche-recensement-mensuel','consultation-de-fiche-presence'), isset($active_route) && !empty($active_route) ? $active_route : '', 'menu-is-opening menu-open') ?>">

              <a href="#"

                 class="nav-link <?= route_active(array('consultation-de-fiche-enqueteur', 'consultation-de-fiche-acheteur', 'consultation-de-fiche-pecheur', 'consultation-de-fiche-societe', 'consultation-de-fiche-recensement','consultation-de-fiche-recensement-mensuel','consultation-de-fiche-presence'), isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                <i class="nav-icon fas fa-book"></i>

                <p>

                  Consultation des fiches

                  <i class="right fas fa-angle-left"></i>

                </p>

              </a>

              <ul class="nav nav-treeview">

                <?php if ($this->lib_autorisation->visualisation_autorise(11)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/consultation-de-fiche-enqueteur.html"

                       class="nav-link <?= route_active(array('consultation-de-fiche-enqueteur'), isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Enquêteur</p>

                    </a>

                  </li>

                <?php }

                  if ($this->lib_autorisation->visualisation_autorise(14)) { ?>

                    <li class="nav-item">

                      <a href="/corecrabe/consultation-de-fiche-pecheur.html"

                         class="nav-link <?= route_active('consultation-de-fiche-pecheur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                        <i class="far fa-circle nav-icon"></i>

                        <p>Pêcheur</p>

                      </a>

                    </li>

                  <?php }

                  if ($this->lib_autorisation->visualisation_autorise(17)) { ?>

                    <li class="nav-item">

                      <a href="/corecrabe/consultation-de-fiche-acheteur.html"

                         class="nav-link <?= route_active('consultation-de-fiche-acheteur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                        <i class="far fa-circle nav-icon"></i>

                        <p>Acheteur</p>

                      </a>

                    </li>
                  <?php }

                  if ($this->lib_autorisation->visualisation_autorise(38)) { ?>

                    <li class="nav-item">

                      <a href="/corecrabe/consultation-de-fiche-societe.html"

                         class="nav-link <?= route_active('consultation-de-fiche-societe', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                        <i class="far fa-circle nav-icon"></i>

                        <p>Société de collecte</p>

                      </a>

                    </li>
                  <?php }

                if ($this->lib_autorisation->visualisation_autorise(11)) { ?>

                  <li class="nav-item <?= route_active(array('consultation-de-fiche-recensement','consultation-de-fiche-recensement-mensuel','consultation-de-fiche-presence'), isset($active_route) && !empty($active_route) ? $active_route : '', 'menu-is-opening menu-open') ?>">

                    <a href="#" class="nav-link <?= route_active(array('consultation-de-fiche-recensement','consultation-de-fiche-recensement-mensuel','consultation-de-fiche-presence'), isset($active_route) && !empty($active_route) ? $active_route : '') ?>">
                      <i class=" far fa-circle nav-icon"></i>
                      <p>
                        Récensement
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/corecrabe/consultation-de-recensement.html"  class="nav-link <?= route_active('consultation-de-fiche-recensement', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">
                          <i class="fas fa-circle nav-icon"></i>
                          <p>Fiche N° 5</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/corecrabe/consultation-de-fiche-recensement-mensuel.html" class="nav-link <?= route_active('consultation-de-fiche-recensement-mensuel', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">
                          <i class="fas fa-circle nav-icon"></i>
                          <p>Fiche N° 6</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/corecrabe/fiche-presence/consultation_fiche.html" class="nav-link <?= route_active('consultation-de-fiche-presence', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">
                          <i class="fas fa-circle nav-icon"></i>
                          <p>Fiche de presence</p>
                        </a>
                      </li>
                    </ul>
                  </li>

                <?php } ?>

              </ul>

            </li>

          <?php }

          if ($this->lib_autorisation->visualisation_autorise(26)) { ?>

            <li class="nav-item <?= route_active(array('entite/enqueteur', 'entite/pecheur', 'entite/societe'), isset($active_route) && !empty($active_route) ? $active_route : '', 'menu-is-opening menu-open') ?>">

              <a href="#" class="nav-link <?= route_active(array('entite/enqueteur', 'entite/pecheur', 'entite/societe'), isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                <i class="nav-icon fas fa-users"></i>

                <p>

                  Entités

                  <i class="right fas fa-angle-left"></i>

                </p>

              </a>

              <ul class="nav nav-treeview">

                <?php if ($this->lib_autorisation->visualisation_autorise(20)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/entite/enqueteur.html" class="nav-link <?= route_active('entite/enqueteur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Enquêteur</p>

                    </a>

                  </li>

                <?php }

                  if ($this->lib_autorisation->visualisation_autorise(21)) { ?>

                    <li class="nav-item">

                      <a href="/corecrabe/entite/pecheur.html" class="nav-link <?= route_active('entite/pecheur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                        <i class="far fa-circle nav-icon"></i>

                        <p>Pêcheur</p>

                      </a>

                    </li>
                <?php }

                  if ($this->lib_autorisation->visualisation_autorise(36)) { ?>

                    <li class="nav-item">

                      <a href="<?=base_url('entite/societe');?>" class="nav-link <?= route_active('entite/societe', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                        <i class="far fa-circle nav-icon"></i>

                        <p>Société de collecte</p>

                      </a>

                    </li>

                  <?php } ?>

              </ul>

            </li>

          <?php }

          if ($this->lib_autorisation->visualisation_autorise(27)) { ?>

            <li class="nav-item <?= route_active(array('login_shiny','organisation',"historique", 'utilisateur/gestion-utilisateur', 'operation/gestion-operation', 'groupe/gestion-groupe'), isset($active_route) && !empty($active_route) ? $active_route : '', 'menu-is-opening menu-open') ?>">

              <a href="#"

                 class="nav-link <?= route_active(array('login_shiny','organisation',"historique", 'utilisateur/gestion-utilisateur', 'operation/gestion-operation', 'groupe/gestion-groupe'), isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                <i class="nav-icon fas fa-user"></i>

                <p>

                  Accès et utilisateur

                  <i class="right fas fa-angle-left"></i>

                </p>

              </a>

              <ul class="nav nav-treeview">

                <?php if ($this->lib_autorisation->visualisation_autorise(22)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/operation/gestion-operation.html" class="nav-link <?= route_active('operation/gestion-operation', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Opérations</p>

                    </a>

                  </li>

                <?php }

                  if ($this->lib_autorisation->visualisation_autorise(23)) { ?>

                    <li class="nav-item">

                      <a href="/corecrabe/groupe/gestion-groupe.html" class="nav-link <?= route_active('groupe/gestion-groupe', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                        <i class="far fa-circle nav-icon"></i>

                        <p>Groupe</p>

                      </a>

                    </li>

                  <?php }

                  if ($this->lib_autorisation->visualisation_autorise(24)) { ?>

                    <li class="nav-item">

                      <a href="/corecrabe/utilisateur/gestion-utilisateur.html"

                         class="nav-link <?= route_active('utilisateur/gestion-utilisateur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                        <i class="far fa-circle nav-icon"></i>

                        <p>Utilisateur</p>

                      </a>

                    </li>

                  <?php }

                  if ($this->lib_autorisation->visualisation_autorise(33)) { ?>

                    <li class="nav-item">

                      <a href="/corecrabe/historique.html"

                         class="nav-link <?= route_active('historique', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                        <i class="far fa-circle nav-icon"></i>

                        <p>Historique</p>

                      </a>

                    </li>

                  <?php }  if ($this->lib_autorisation->visualisation_autorise(24)) { ?>
                    <li class="nav-item">

                      <a href="/corecrabe/organisation.html"

                         class="nav-link <?= route_active('organisation', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                        <i class="far fa-circle nav-icon"></i>

                        <p>Organisation</p>

                      </a>

                    </li>

                    <li class="nav-item">

                      <a href="/corecrabe/login_shiny.html"

                         class="nav-link <?= route_active('login_shiny', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                        <i class="far fa-circle nav-icon"></i>

                        <p>Utilisateur Shiny</p>

                      </a>

                    </li>
                  <?php } ?>

              </ul>

            </li>

          <?php } ?>

        <?php if ($this->lib_autorisation->visualisation_autorise(30) || $this->lib_autorisation->visualisation_autorise(31) || $this->lib_autorisation->visualisation_autorise(32)) { ?>

          <li class="nav-item <?= route_active(array('exporter-csv-enqueteur', 'exporter-csv-pecheur', 'exporter-csv-acheteur'), isset($active_route) && !empty($active_route) ? $active_route : '', 'menu-is-opening menu-open') ?>">

            <a href="#"

               class="nav-link <?= route_active(array('exporter-csv-enqueteur', 'exporter-csv-pecheur', 'exporter-csv-acheteur'), isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

              <i class="fa fa-database nav-icon"></i>

              <p>

                Export en CSV

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <?php if ($this->lib_autorisation->visualisation_autorise(30)) { ?>

                <li class="nav-item">

                  <a href="/corecrabe/exporter-csv/enqueteur.html" class="nav-link <?= route_active('exporter-csv-enqueteur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                    <i class="far fa-circle nav-icon"></i>

                    <p>Enquêteur</p>

                  </a>

                </li>

              <?php }

                if ($this->lib_autorisation->visualisation_autorise(31)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/exporter-csv/pecheur.html" class="nav-link <?= route_active('exporter-csv-pecheur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Pêcheur</p>

                    </a>

                  </li>

                <?php }

                if ($this->lib_autorisation->visualisation_autorise(32)) { ?>

                  <li class="nav-item">

                    <a href="/corecrabe/exporter-csv/acheteur.html" class="nav-link <?= route_active('exporter-csv-acheteur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Acheteur</p>

                    </a>

                  </li>

                <?php } ?>

            </ul>

          </li>

        <?php } ?>
	<?php if ($this->lib_autorisation->visualisation_autorise(30) || $this->lib_autorisation->visualisation_autorise(31) || $this->lib_autorisation->visualisation_autorise(32)) { ?>

<li class="nav-item <?= route_active(array('import-enqueteur','import-acheteur-2', 'import-enqueteur-2', 'import-pecheur', 'import-acheteur','import-recensement-5', 'import-recensement-6'), isset($active_route) && !empty($active_route) ? $active_route : '', 'menu-is-opening menu-open') ?>">

  <a href="#"

     class="nav-link <?= route_active(array('import-enqueteur', 'import-acheteur-2', 'import-pecheur', 'import-enqueteur-2', 'import-acheteur','import-recensement-5', 'import-recensement-6'), isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

    <i class="fa fa-upload nav-icon"></i>

    <p>

      Importer les données

      <i class="right fas fa-angle-left"></i>

    </p>

  </a>

  <ul class="nav nav-treeview">

    <?php if ($this->lib_autorisation->visualisation_autorise(30)) { ?>

      <li class="nav-item">

        <a href="<?=base_url();?>import-donnees-enqueteur" class="nav-link <?= route_active('import-enqueteur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

          <i class="far fa-circle nav-icon"></i>

          <p>Enquêteur</p>

        </a>

      </li>

    <?php }
    
    if ($this->lib_autorisation->visualisation_autorise(30)) { ?>

      <li class="nav-item">

        <a href="<?=base_url();?>import-donnees-enqueteur-2" class="nav-link <?= route_active('import-enqueteur-2', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

          <i class="far fa-circle nav-icon"></i>

          <p>Enquêteur (Récupération)</p>

        </a>

      </li>

    <?php }

      if ($this->lib_autorisation->visualisation_autorise(31)) { ?>

        <li class="nav-item">

          <a href="<?=base_url();?>import-donnees-recensement-5" class="nav-link <?= route_active('import-recensement-5', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

            <i class="far fa-circle nav-icon"></i>

            <p>Recensement (N°5)</p>

          </a>

        </li>
    <?php }

      if ($this->lib_autorisation->visualisation_autorise(31)) { ?>

        <li class="nav-item">

          <a href="<?=base_url();?>import-donnees-recensement-6" class="nav-link <?= route_active('import-recensement-6', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

            <i class="far fa-circle nav-icon"></i>

            <p>Recensement (N°6)</p>

          </a>

        </li>

      <?php }

      if ($this->lib_autorisation->visualisation_autorise(32)) { ?>

        <li class="nav-item">

          <a href="<?=base_url();?>import-donnees-acheteur" class="nav-link <?= route_active('import-acheteur', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

            <i class="far fa-circle nav-icon"></i>

            <p>Acheteur</p>

          </a>

        </li>

        <?php }
    
          if ($this->lib_autorisation->visualisation_autorise(32)) { ?>

            <li class="nav-item">

              <a href="<?=base_url();?>import-donnees-acheteur-2" class="nav-link <?= route_active('import-acheteur-2', isset($active_route) && !empty($active_route) ? $active_route : '') ?>">

                <i class="far fa-circle nav-icon"></i>

                <p>Acheteur (Récupération)</p>

              </a>

            </li>
      <?php } ?>

  </ul>

</li>

<?php } ?>

      </ul>

    </nav>

    <!-- /.sidebar-menu -->

  </div>

  <!-- /.sidebar -->

</aside>
