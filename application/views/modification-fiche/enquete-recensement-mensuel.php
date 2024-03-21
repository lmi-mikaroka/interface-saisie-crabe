<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-12">
          <h1>Fiche de recensement N° 6 :<?= $fiche['code'] ?></h1>
        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>



  <!-- Main content -->

  <section class="content">
<input type='number' hidden name='nombre_enquete' id='nombre_enquete' value="<?= count($enquetes) ?>" />
<input type='number' hidden name='fiche' id='fiche' value="<?= $fiche['id'] ?>" />
    <div class="container">
    
    <div class="card" id="table_pecheur" >
      <div class='card-header'>
        <h3 class="card-title">Modification enquete(s) n° 6</h3>
        <div class="card-tools">
        <button id="enregistrer"  class="btn btn-warning mb-2 float-right mr-2">Enregistrer</button>
        </div>
      </div>
      <div class="card-body table-responsive">
        
          <table id="example"  class=" display table text-center " style="width:100%">
              <thead>
                  <tr >
                      <th>Pecheur</th>
                      <th>Sexe</th>
                      <th>crabe</th>
                      <th>Activité1</th>
                      <th>%</th>
                      <th>Activité2</th>
                      <th>%</th>
                      <th>Activité3</th>
                      <th>%</th>
                  </tr>
              </thead>
              <tbody id="body-table" >
                  <?php $i=0; foreach($enquetes as $enquete) { ?>
                    <input type='number' hidden name='js-enquete<?= $i ?>' id='js-enquete<?= $i ?>' value='<?= $enquete['id'] ?>' />
                    <tr> 
                      <td><?= $enquete['nomPecheur'] ?>  <input type='number' hidden name='pecheur<?= $i ?>' id='pecheur<?= $i ?>' value='<?= $enquete['pecheur'] ?>' />  </td>
                      <td><?= $enquete['sexe'] ?></td>
                      <td>
                          <div class="btn-group btn-group-toggle" data-toggle="buttons">
                              <label class="btn btn-xs btn-outline-secondary   ">
                          
                                 <input type="radio" value="0" name="js-crabe<?= $i ?>" <?= $enquete['crabe']=='0'?'checked':'' ?> onclick='change_crabe(<?= $i ?>)'   > Non
                        
                              </label>
                              <label class="btn btn-xs btn-outline-secondary   ">
                          
                                  <input type="radio" value="1"   name="js-crabe<?= $i ?>"  <?= $enquete['crabe']=='1'?'checked':'' ?> onclick='change_crabe(<?= $i ?>)'   > Oui
                        
                              </label>
                      
                            </div>
                      </td>
                      <td>
                      <select size="1" class="custom-select" name="js-activite1<?= $i ?>" id="js-activite1<?= $i ?>"  style="width:110px" onchange="change_activite1(<?= $i ?>)">
                          <option value=""></option>
                               <?php foreach ($activites as $activite){ if($activite['id']==1){ if($enquete['crabe']==1){ ?>
                                  <option value="<?= $activite['id']?>" <?= $enquete['activites'][0]['activite']==$activite['id']?'selected':'' ?>><?= $activite['nom']?></option>
                               <?php } } else{ ?>
                                <option value="<?= $activite['id']?>"  <?= $enquete['activites'][0]['activite']==$activite['id']?'selected':'' ?> ><?= $activite['nom']?></option>
                              <?php  } } ?>
                           </select>
                      </td>

                      <td><input  type="number" step='any' class="form-control"  name="js-activite1-pourcent<?= $i ?>" id="js-activite1-pourcent<?= $i ?>" style="width:60px" value="<?= $enquete['activites'][0]['pourcentage'] ?>" onkeyup="change_pourcentage1(<?= $i ?>)" ></td>

                      <td><select size="1" class="custom-select" name="js-activite2<?= $i ?>" id="js-activite2<?= $i ?>"  style="width:110px" onchange="change_activite2(<?= $i ?>)">
                          <option value=""></option>
                               <?php foreach ($activites as $activite){ if($activite['id']==1){ if($enquete['crabe']==1){ ?>
                                  <option value="<?= $activite['id']?>" <?php if(count($enquete['activites'])>1){ ?> <?= $enquete['activites'][1]['activite']==$activite['id']?'selected':''  ?> <?php } ?> <?= $enquete['activites'][0]['activite']==$activite['id']?'disabled':''  ?> ><?= $activite['nom']?></option>
                               <?php } } else{ ?>
                                <option value="<?= $activite['id']?>" <?php if(count($enquete['activites'])>1){ ?>   <?= $enquete['activites'][1]['activite']==$activite['id']?'selected':'' ?> <?php }?> <?= $enquete['activites'][0]['activite']==$activite['id']?'disabled':''  ?> ><?= $activite['nom']?></option>
                              <?php  } } ?>
                           </select></td>
                      <td><input  type="number" class="form-control"  name="js-activite2-pourcent<?= $i ?>" id="js-activite2-pourcent<?= $i ?>" style="width:60px" value="<?= count($enquete['activites'])>1?$enquete['activites'][1]['pourcentage']:'' ?>" onkeyup="change_pourcentage2(<?= $i ?>)" ></td>
                      <td><select size="1" class="custom-select" name="js-activite3<?= $i ?>" id="js-activite3<?= $i ?>"  style="width:110px" onchange="change_activite3(<?= $i ?>)">
                          <option value=""></option>
                               <?php foreach ($activites as $activite){ $disabled_activite2 = null; if(count($enquete['activites'])>2){
                                $disabled_activite2 = $enquete['activites'][1]['activite'];
                               }
                                if($activite['id']==1){ if($enquete['crabe']==1){  ?>
                                  <option value="<?= $activite['id']?>" <?php if(count($enquete['activites'])>2){ ?> <?= $enquete['activites'][2]['activite']==$activite['id']?'selected':'' ?> <?php } ?>  <?= ( $enquete['activites'][0]['activite'] ==$activite['id'] ||$disabled_activite2 ==$activite['id'])?'disabled':''  ?>><?= $activite['nom']?></option>
                               <?php } } else{ ?>
                                <option value="<?= $activite['id']?>" <?php if(count($enquete['activites'])>2){ ?>  <?= $enquete['activites'][2]['activite']==$activite['id']?'selected':'' ?> <?php } ?> <?= ($enquete['activites'][0]['activite'] == $activite['id'] || $disabled_activite2 ==$activite['id'])?'disabled':''  ?>  ><?= $activite['nom']?></option>
                              <?php  } } ?>
                           </select></td>
                      <td><input  type="number" class="form-control"  name="js-activite3-pourcent<?= $i ?>" id="js-activite3-pourcent<?= $i ?>" style="width:60px" value="<?= count($enquete['activites'])>2?$enquete['activites'][2]['pourcentage']:'' ?>" onkeyup="change_pourcentage3(<?= $i ?>)" ></td>
                    </tr>
                    <?php $i= $i+1; }  ?>
              </tbody>
              <tfoot >
                    <tr>
                        <th>Pecheur</th>
                        <th>Sexe</th>
                        <th>crabe</th>
                        <th>Activité1</th>
                        <th>%</th>
                        <th>Activité2</th>
                        <th>%</th>
                        <th>Activité3</th>
                        <th>%</th>
                    </tr>
              </tfoot>
          <table>
      </div>
    </div>

      <!-- /.card -->

      

      <!-- /.card -->

      <!-- /.container-fluid -->

  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->
