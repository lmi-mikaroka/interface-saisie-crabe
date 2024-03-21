<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

<!-- Content Header (Page header) -->

<section class="content-header">

    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-12">

                <h1>Fiches de récensement N° 6: <?= $fiche['code'] ?></h1>

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
            <div class="card-tools" >
                <button id="btn_multiple"  class="btn btn-default" >Modification multiple</button>
            </div>
        </div>
            
       <input type='number' name="js-fiche" id="js-fiche" vlaue='<?= $fiche['id'] ?>' hidden>
            <!-- /.card-header -->

            <div class="card-body">

                <table id="datatable" class=" display table  table-bordered table-striped" width="100%">

                    <thead>

                    <tr>
                        <th></th>
                        <th>Pecheur</th>

                        <th>Sexe</th>

                        <th>Crabe</th>

                        <th>Activité1</th>

                        <th>%</th>

                        <th>activite2</th>

                        <th>%</th>

                        <th>activité3</th>

                        <th>%</th>

                        <th style="width:1px; white-space:nowrap; text-align: center;">Action</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php $i = 0; foreach($enquetes as $enquete){
                        $count_activite = count($enquete['activite']) ?>
                        <tr>
                            <td><input type="checkbox" name="modification-check<?= $i ?>" id="<?= $enquete['id'] ?>" onclick="recupValeurs(<?= $enquete['id'] ?>)" /></td>
                            <td><?= $enquete['nomPecheur'] ?></td>
                            <td><?= $enquete['sexe'] ?></td>
                            <td><?= $enquete['crabe']=='0'?'Non':'Oui' ?></td>
                            <td><?= $enquete['activite'][0]['nomActivite'] ?></td>
                            <td><?= $enquete['activite'][0]['pourcentage'] ?></td>
                            <td><?php if($count_activite>1){
                                echo $enquete['activite'][1]['nomActivite'];
                            } ?></td>
                            <td><?php if($count_activite>1){
                                echo $enquete['activite'][1]['pourcentage'];
                            } ?></td>
                            <td><?php if($count_activite>2){
                                echo $enquete['activite'][2]['nomActivite'];
                            } ?></td>
                            <td><?php if($count_activite>2){
                                echo $enquete['activite'][2]['pourcentage'];
                            } ?></td>
                            <td>

                            <div class="btn-group">
                              <a class="btn btn-sm btn-default update-button" data-target="#update-modal" href="<?= base_url("consultation-de-recensement-mensuel/modification-enquete/". $enquete['id'])  ?>"  >Modifier</a>
                              <button class="btn btn-sm btn-default delete-button"  data-target="<?= $enquete['id'] ?>">Supprimer</button>
                            </div>
                            </td>
                           
                        </tr>
                    <?php $i++; } ?>
                    
                    </tbody>

                    <tfoot>

                    <tr>
                        <th></th>
                        <th>Pecheur</th>

                        <th>Sexe</th>

                        <th>Crabe</th>

                        <th>Activité1</th>

                        <th>%</th>

                        <th>activite2</th>

                        <th>%</th>

                        <th>activité3</th>

                        <th>%</th>

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
