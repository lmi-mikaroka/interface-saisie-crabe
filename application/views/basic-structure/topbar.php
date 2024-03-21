<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->

  <ul class="navbar-nav">

    <li class="nav-item">

      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

    </li>

      

  </ul>

    



  <!-- Right navbar links -->

  <ul class="navbar-nav ml-auto">




  <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <img width="30" height="30" src="<?=base_url('assets/apks/app_web.png');?>" /> Application web
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"></span>
          <a href="<?=base_url('assets/EXPORT_MANUEL_APP_WEB.pdf');?>" class="dropdown-item">
            <i class="fas fa-atlas mr-2"></i> Manuel d'utilisation
            <span class="float-right text-muted text-sm">(en redaction)</span>
          </a>
        </div>
  </li>


  <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <img width="30" height="30" src="<?=base_url('assets/apks/app-android.png');?>" /> Application Mobile <span class="badge badge-success">New</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"></span>
          <a href="http://vps-a8d8821c.vps.ovh.net/owncloud/index.php/s/vMNzjYOwTe8nIgV" target="_blank" class="dropdown-item">
            <i class="fas fa-download mr-2"></i> ODKrabe 2.0.0
            <span class="float-right text-muted text-sm">(Dernière version)</span>
          </a>
          <div class="dropdown-divider"></div>
	  <a href="http://vps-a8d8821c.vps.ovh.net/owncloud/index.php/s/krPkAklpb9f4Cvp" target="_blank" class="dropdown-item">
            <i class="fas fa-object-ungroup mr-2"></i> Toutes les versions
            <span class="float-right text-muted text-sm"></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="https://expo.dev/@mendrika861/ODKrabe" target="_blank" class="dropdown-item">
            <i class="fas fa-play mr-2"></i> Test en direct avec Expo Go <span class="badge badge-success">New</span>
          </a>
          <div class="dropdown-divider"></div>
          <div class="dropdown-divider"></div>
          <a href="https://expo.dev/client" target="_blank" class="dropdown-item">
            <i class="fas fa-tablet mr-2"></i> Télécharger Expo Go
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?=base_url('assets/MANUEL_D_UTILISATION_ODKrabe.pdf');?>" class="dropdown-item">
            <i class="fas fa-atlas mr-2"></i> Manuel d'utilisation
            <span class="float-right text-muted text-sm">(En cours)</span>
          </a>
        </div>
  </li>

    <li class="nav-item dropdown user-menu show">

      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

        <img src="<?= img_url('user-icon.png') ?>" class="user-image img-circle elevation-2" alt="photo d'utilisateur">

        <span class="d-none d-md-inline"><?= $utilisateur['nom'] ?></span>

      </a>

      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">

        <!-- User image -->

        <li class="user-header bg-light">

        <img src="<?= img_url('user-icon.png') ?>" class="img-circle elevation-2" alt="photo d'utilisateur">

          <p>
          <?= $utilisateur['nom'] ?><span class="badge bg-success">.</span>

          </p>
            

        </li>

        <!-- Menu Footer-->

        <li class="user-footer">

            <a id="js-bouton-deconnexion" class="btn btn-app bg-danger float-right"><i class="fas fa-power-off"></i> Déconnexion</a>

        </li>
          

      </ul>

    </li>

    <li class="nav-item">

      <a class="nav-link" data-widget="fullscreen" href="#" role="button">

        <i class="fas fa-expand-arrows-alt"></i>

      </a>

    </li>

  </ul>

</nav>
