<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Historique</h1>

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>

  

  <!-- Main content -->

  <section class="content">

    <div class="container-fluid">

      <!-- /.card -->

      <div class="card">

        <div class="card-header">

          <button id="js-nettoyer-historique" class="btn btn-danger">Nettoyer l'historique</button>

        </div>

        <!-- /.card-header -->

        <div class="card-body">

          <table class="table" id="historiqueTable">

            <thead>

            <tr>

              <th>Date</th>

              <th>Utilisateur</th>

              <th>Action</th>

              <th>Détail</th>

            </tr>

            </thead>

            <tbody>

            <?php foreach ($historiques as $historique) {?>

                <tr>

                  <td><?= $historique["date"] ?></td>

                  <td><?= $historique["utilisateur"] ?></td>

                  <td><?= $historique["action"] ?></td>

                  <td><?= $historique["detail"] ?></td>

                </tr>

            <?php } ?>

            </tbody>

          </table>

        </div>

        <!-- /.card-body -->

      </div>

      <!-- /.card -->

      <!-- /.container-fluid -->

  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->
