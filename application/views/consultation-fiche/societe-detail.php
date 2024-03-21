<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1>

                    Cargaison N°  <?=$num;?>

                    </h1>    
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container">
            <div class="card">
                <div class="card-header  align-middle">
                    <h1 class="card-title">Informations sur la cargaison</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6" style="border-right: 1px solid">
                            <div class="row" style="display:flex; align-items: center">
                                <div class="col-md-6"><h6 style="font-weight: bold">Date de débarquement</h6></div>
                                <div class="col-md-6 mb-1">
                                    <input type="text" readonly class="form-control" value="<?=date_format(date_create($cargaison['datedebarquement']),"d M Y");?>">
                                </div>
                                <div class="col-md-6"><h6 style="font-weight: bold">Date d'expédition</h6></div>
                                <div class="col-md-6 mb-1">
                                    <input type="text" class="form-control" readonly value="<?php if($cargaison['dateexpedition']!=null){
                                        echo date_format(date_create($cargaison['dateexpedition']),"d M Y");
                                    }?>">
                                </div>
                                <div class="col-md-6"><h6 style="font-weight: bold">Zone biogéographique</h6></div>
                                <div class="col-md-6 mb-1">
                                <input type="text" readonly class="form-control" value="<?=$cargaison['nomZone'];?>">
                                </div>
                                <div class="col-md-6"><h6 style="font-weight: bold">Société de collecte</h6></div>
                                <div class="col-md-6 mb-1">
                                <input type="text" readonly class="form-control" value="<?=$cargaison['nomSociete'];?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="border-right: 1px solid">
                            <div class="row" style="display:flex; align-items: center">
                                <div class="col-md-6"><h6 style="font-weight: bold">Type de transport</h6></div>
                                <div class="col-md-6 mb-1">
                                    <input type="text" readonly class="form-control" value="<?=$cargaison['transport'];?>">
                                </div>
                                <div class="col-md-6"><h6 style="font-weight: bold">Enquêteur responsable</h6></div>
                                <div class="col-md-6 mb-1">
                                    <input type="text" readonly class="form-control" value="<?=$cargaison['nomEnqueteur'];?>">
                                </div>
                                <div class="col-md-6"><h6 style="font-weight: bold">Poids de la cargaison
				<?=$cargaison['trie']=="t" ? '<span class="badge badge-sm badge-success">Trié</span>' : '<span class="badge badge-sm badge-danger">Non trié</span>';?></h6></div>
                                <div class="col-md-6 mb-1">
                                    <input type="text" readonly class="form-control" value="<?=$cargaison['poidstotalcargaison'];?> kg">
                                </div>
                                <div class="col-md-6"><h6 style="font-weight: bold">Village(s) de provenance de la cargaison</h6></div>
                                <div class="col-md-12 mb-1">
                                    <div class="row">
                                        <?php foreach($pro as $key => $value):?>
                                        <div class="col-md-4 mx-1 card">
                                        
                                        <!-- <input type="text" readonly class="form-control" value="<?=$key+1;?> - <?=$value['nom'];?>"> -->
                                            <span><h6><?=$key+1;?>-<?=$value['nom'];?></h6></span>
                                        </div>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
            <?php foreach($lots as $key => $value):?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header  align-middle">
                            <h1 class="card-title">LOT/FICHE N° <?=$key+1;?></h1>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6" style="border-right: 1px solid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6 style="font-weight: bold">Informations sur chaque bac/gony (kg)</h6>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <?php foreach($value['bacs'] as $keyBac => $bac):?>
                                                <div class="col-md-4">
                                                    <span class="card mx-1 p-1"><h6 style="font-weight: bold">Bac <?=$keyBac+1;?> : <span><?=$bac['poidsbac'];?> kg (<?=$bac['type'];?>)</span></h6></span>
                                                </div>
                                                <?php endforeach;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="border-right: 1px solid">
                                    <div class="row" style="display:flex; align-items: center">
                                        <div class="col-md-6"><h6 style="font-weight: bold">Village de provenance du lot échantillonné</h6></div>
                                        <div class="col-md-6 mb-1">
                                            <input type="text" readonly class="form-control" value="<?=$value['nom'];?>">
                                        </div>
                                        <div class="col-md-6"><h6 style="font-weight: bold">Poids total du lot échantillonné</h6></div>
                                        <div class="col-md-6 mb-1">
                                            <input type="text" readonly class="form-control" value="<?=$value['poidstotal'];?> kg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                        <?php $point=1;?>
                                <?php foreach($value['crabes'] as $keyCrabe => $crabe){
                                    if($keyCrabe == $point-1){
                                        if(count($value['crabes'])/40 > 0 && count($value['crabes'])/40 <= 1 ){
                                            echo "
                                        <div class='col-md-12'> 
                                        <table class='table table-bordered table-sm'>
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Taille (mm)</th>
                                                <th>Sexe(M/F)</th>
                                            </tr>
                                        </thead>
                                        <tbody id='crabe-container'>
                                        ";
                                        }elseif(count($value['crabes'])/40 > 1 && count($value['crabes'])/40 <= 2 ){
                                            echo "
                                        <div class='col-md-6'> 
                                        <table class='table table-bordered table-sm'>
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Taille (mm)</th>
                                                <th>Sexe(M/F)</th>
                                            </tr>
                                        </thead>
                                        <tbody id='crabe-container'>
                                        ";
                                        }else{
                                            echo "
                                        <div class='col-md-4'>
                                        <table class='table table-bordered table-sm'>
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Taille (mm)</th>
                                                <th>Sexe(M/F)</th>
                                            </tr>
                                        </thead>
                                        <tbody id='crabe-container'>
                                        ";
                                        }
                                        $point+=40;
                                    }

                                    echo "
                                    <tr>
                                        <td>".($keyCrabe+1)."</td>
                                        <td>".(($crabe['taille'] == 0) ? "Non mésuré" : $crabe['taille'])."</td>
                                        <td>".$crabe['sexe']."</td>
                                    </tr> 
                                    ";

                                    if($keyCrabe+1 == count($value['crabes']) || $keyCrabe == $point-2){
                                        echo "
                                                </tbody>
                                            </table>
                                        </div>
                                        ";
                                    }
                                }?>
                        </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            </div>
        </div>
    </section>
</div>
