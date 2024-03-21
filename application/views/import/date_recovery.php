<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->

  <section class="content-header">

<div class="container-fluid">

  <div class="row mb-2">

    <div class="col-sm-6">

      <h1>DATE RECOVERY</h1>

    </div>

  </div>

</div><!-- /.container-fluid -->

</section>
<!-- Main content -->

  <section class="content">

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form  accept-charset="utf-8" accept=".xls, .xlsx" enctype="multipart/form-data" role="form" method="post" id="upload_form">
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="type1" name="type" value="csv" disabled>
                    <label class="custom-control-label" for="type1">csv</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="type2" name="type" value="excel" checked>
                    <label class="custom-control-label" for="type2">excel</label>
                </div>
                <input type="file" name="fichier" id="fichier" accept=".xls, .xlsx" required/>
                <span id="delimiteur">
                    <label for="delimiter">Choisir le délimiteur</label>
                    <select id="delimiter" disabled>
                        <option id="comma" value=",">,</option>
                        <option id="comma" value=";">;</option>
                        <option id="pipe" value="|">|</option>
                    </select>
                </span>

                <button id="verifier" class="btn btn-default" type="button" disabled><i class="fa fa-retweet"></i> Convertir</button>
                <button id="upload" class="btn btn-warning" type="button"><i class="fa fa-upload"></i> Téléverser</button>
            </form>
        </div>
        <div class="col-12"><br></div>
        <div class="col-12">
            <img src="<?= img_url('excel.png') ?>" style="width: 400px;height: 200px;"/>
        </div>
    </div>
</div>
</section>
</div>
