<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-warning">
    <div class="card-header text-center">
      <img src="<?= img_url('favicon.jpg') ?>" alt="logo-corecrabe"><br>
      <a href="#!" class="h1"><b>CORE</b>CRABE</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Vous devez être connécté pour commencer une session</p>

      <form action="" method="post" autocomplete="off" id="js-formulaire">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Identifiant" id="js-identifiant">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Mot de passe" id="js-mot-de-passe">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-warning btn-block">Commencer</button>
        <!-- /.col -->
    </div>
    </form>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
<!-- /.login-box -->
