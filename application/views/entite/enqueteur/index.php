<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Enquêteur</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- /.card -->
      <div class="card">
        <?php if ($autorisation_creation) { ?>
          <div class="card-header">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#insert-modal">
              Nouvel Enquêteur
            </button>
          </div>
        <?php } ?>
        
        <!--les modals d'ajout et modification sous forme de composant-->
        <?= $insert_modal_component = isset($insert_modal_component) && !empty($insert_modal_component) && $autorisation_creation ? $insert_modal_component : '' ?>
        <?= $update_modal_component = isset($update_modal_component) && !empty($update_modal_component) && $autorisation_modification ? $update_modal_component : '' ?>
        <!--les modals d'ajout et modification sous forme de composant-->
        
        <!-- /.card-header -->
        <div class="card-body">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Code</th>
              <th>Nom</th>
              <th>Type</th>
              <th>Structure</th>
              <th>Village</th>
              <th style="width:1px; white-space:nowrap; text-align: center;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
              <th>Code</th>
              <th>Nom</th>
              <th>Type</th>
              <th>Structure</th>
              <th>Village</th>
              <th style="width:1px; white-space:nowrap; text-align: center;">Action</th>
            </tr>
            </tfoot>
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
