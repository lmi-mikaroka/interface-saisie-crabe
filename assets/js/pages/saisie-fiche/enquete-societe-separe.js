$('.select2').select2({

    theme: 'bootstrap4'

})

const form = {
cargaison: $(`[name=js-cargaison]`).val(),
provenance: [],
lots: []
}

const action = {
corps: $('#js-formulaire'),
boutonAjouterLot: $('#js-ajouter-lot'),
inputProvenance: $('#js-villages'),
conteneurLots: $('#lots'),
enregistrer: $('#js-enregistrer'),
}

//Renseignement des données de provenance
action.inputProvenance.change(function(){
   var provenance = []
    $('option:selected', $(this)).each(function(){
        provenance = [...provenance,{
            id: $(this).val(),
            nom: $(this).text(),
        }]
    })
    form.provenance = provenance
    if(form.provenance.length > 0){
        action.boutonAjouterLot.removeAttr('disabled')
    }else{
        action.boutonAjouterLot.attr('disabled','disabled')
    }
})

//Click sur le bouton ajouter bac
action.boutonAjouterLot.on('click', e => {
    form.lots= [...form.lots,{
        numFiche: null,
        village: {
            id:null,
            nom:null
        },
        poids: 0,
        crabes: [],
        bacs: []
    }];

    if(form.lots.length>0){
        action.inputProvenance.attr("disabled", "disabled");
    }else{
        action.inputProvenance.removeAttr('disabled')
    }
    afficherCardLots();
})

function add_bac(index){
    form.lots[index].bacs = [...form.lots[index].bacs,{
        type: 'bac',
        poidsBac: 0
    }]

    afficherCardBacs(index)
}

function afficherCardLots(){
    var lotsInverse = []
    for(var i=form.lots.length;i>0;i--){
        lotsInverse = [...lotsInverse,form.lots[i-1]]
    }
    action.conteneurLots.html("")
    $.map(lotsInverse, function(x,y){
        var collapsed = ""
        var minus = "minus"
        if(y>0){
            collapsed = "collapsed-card"
            minus = "plus"
        } 
        action.conteneurLots.append(`
        <div class="card ${collapsed}">
            <div class="card-header  align-middle">
                <h1 class="card-title">LOT/FICHE N° ${lotsInverse.length-y}</h1>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-${minus}"></i></button>
                    <button type="button" onclick="delete_lot(${lotsInverse.length-y-1})" class="btn btn-danger btn-sm" id="js-fermer${lotsInverse.length-y-1}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="js-numFiche${lotsInverse.length-y-1}">Numéro de la fiche<span class="text text-red">*</span></label>
                            <div class="input-group">
                            <input type="number" class="form-control" value="${lotsInverse.length-y}" readonly name="js-numFiche${lotsInverse.length-y-1}" max="999" min="1" required>
                            </div>
                            <small>de 1 à 999</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="js-village-lot${lotsInverse.length-y-1}">Village de provenance du lot<span class="text text-red">*</span></label>
                            <div class="select2-purple">
                                <select class="form-control select2" data-dropdown-css-class="select2-purple" onchange="change_village_lot(this,${lotsInverse.length-y-1})" id="js-villages" name="js-village-lot${lotsInverse.length-y-1}" required>
                                <option value="">Choisir le village</option>`+
                                $.map(form.provenance, function(a,b){
                                    return (a.id == x.village.id ? `<option value="${a.id}" selected>${a.nom}</option>`:`<option value="${a.id}">${a.nom}</option>`)
                                })
                                +`</select>
                            </div>
                            <small>*Unique pour tous les villages</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="js-poids-lot${lotsInverse.length-y-1}">Poids Total du lot<span class="text text-red">*</span></label>
                            <div class="input-group">
                            <input type="number" class="form-control" onkeyup="change_poids_lot(this,${lotsInverse.length-y-1})" name="js-poids-lot${lotsInverse.length-y-1}" step="0.1" value="${x.poids}" required>
                            </div>
                            <small>*en kg</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <label>Echantillons (bacs/crabes)</label>
                    <div id="js-donnees-bac${lotsInverse.length-y-1}">
                        <div class="row">
                            <div class="col-md-6 d-flex align-items-stretch flex-column" id="js-bac-ajouter">
                                <div type="button" class="card d-flex flex-fill">
                                    <button type="button" class="btn btn-default btn-block" onclick="add_bac(${lotsInverse.length-y-1})" id="js-ajouter-bac${lotsInverse.length-y-1}" style="height: 100%;">
                                        <i class="fa fa-plus"></i><br>
                                        <span>Ajouter un bac au lot N°${lotsInverse.length-y}</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-stretch flex-column" id="js-crabe-ajouter${lotsInverse.length-y-1}">
                                <div type="button" class="card d-flex flex-fill">
                                    <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modal-add-crabe${lotsInverse.length-y-1}" id="js-ajouter-crabe${lotsInverse.length-y-1}" style="height: 100%;">
                                        <i class="fa fa-plus"></i><br>
                                        <span>Ajouter des crabes à l'échantillon du lot N°${lotsInverse.length-y}</span>
                                    </button>
                                </div>
                                <div class="modal" id="modal-add-crabe${lotsInverse.length-y-1}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" class="form-control" placeholder="Entrez le nombre de crabes à ajouter" id="crabe-nb${lotsInverse.length-y-1}">
                                                    <span class="input-group-append">
                                                    <button type="button" class="btn btn-warning btn-flat" onclick="add_input_crabe(${lotsInverse.length-y-1})" id="add-input-crabe${lotsInverse.length-y-1}">Renseigner les données biométriques des crabes</button>
                                                    </span>
                                                    <span class="input-group-append">
                                                    <button type="button" class="btn btn-danger btn-flat" onclick="reinitialize_input_crabe(${lotsInverse.length-y-1})" id="reinitialize-input-crabe${lotsInverse.length-y-1}" disabled>Effacer</button>
                                                    </span>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body" style="padding: 30px">
                                                <div class="container-fluid pt-1" style="height: 450px; overflow: auto">
                                                    <div class="row" id="input-crabe-container${lotsInverse.length-y-1}"></div>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="padding: 30px">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                <button type="button" onclick="add_crabe(${lotsInverse.length-y-1})" disabled id="btn-add-crabe${lotsInverse.length-y-1}" class="btn btn-warning">Ajouter les crabes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="conteneur-bacs${lotsInverse.length-y-1}">
                        
                    </div>
                </div>
                <div class="col-md-12">
                    <label id="nbCrabeEchantillonne${lotsInverse.length-y-1}"></label>
                    <div class="row" id="conteneur-crabe${lotsInverse.length-y-1}"></div>
                </div>
            </div>
        </div>
        `)

        afficherCardBacs(lotsInverse.length-y-1)
        afficher_crabes(lotsInverse.length-y-1)
    })
}

// Affichage des donées de bacs renseignés et par défaut
function afficherCardBacs(index){
    $(`#conteneur-bacs${index}`).html("");
    var bacsInverse = []
    for(var i=form.lots[index].bacs.length;i>0;i--){
        bacsInverse = [...bacsInverse,form.lots[index].bacs[i-1]]
    }
    // let biometrie = []
    $.map(bacsInverse, function(x,y){
        $(`#conteneur-bacs${index}`).append(`
        <div class="col-md-2">
            <div class="card">
            <div class="card-header border-0"><label class="text">
                ♦ BAC N°${bacsInverse.length-y}</label>
                <div class="card-tools">
                    <button type="button" onclick="delete_bac(${bacsInverse.length-y-1}, ${index})" class="btn btn-danger btn-sm" id="fermer-lot${index}bac${bacsInverse.length-y-1}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
                <div class="row px-2">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="lot${index}bac${bacsInverse.length-y-1}type">Type<span class="text text-red">*</span></label>
                            <div class="select2-purple">
                                <select class="custom-select" onchange="change_type(this,${bacsInverse.length-y-1}, ${index})" data-live-search="true" id="lot${index}bac${bacsInverse.length-y-1}type" style="width: 100%;" name="lot${index}bac${bacsInverse.length-y-1}type" required>`+
                                    (x.type == 'bac' ? `<option value="bac" selected>Bac</option>`:`<option value="bac">Bac</option>`)+
                                    (x.type == 'gony' ? `<option value="gony" selected>Gony</option>`:`<option value="gony">Gony</option>`)+
                                `</select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="lot${index}-bac${bacsInverse.length-y-1}-poids">Poids<span class="text text-red">*</span></label>
                                <div class="input-group">
                                <input type="number" onkeyup="change_poids(this,${bacsInverse.length-y-1}, ${index})" class="form-control" id="lot${index}-bac${bacsInverse.length-y-1}-poids" value="${x.poidsBac}" name="lot${index}-bac${bacsInverse.length-y-1}-poids" step="0.1" required>
                            </div>
                            <small>en kg</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>`
        )
    })
}

function change_poids(field,key,lot){
form.lots[lot].bacs[key].poidsBac = field.value
}

function change_type(field,key,lot){
form.lots[lot].bacs[key].type = field.value
}

function delete_lot(key){
    form.lots.splice(key,1);
    if(form.lots.length>0){
        action.inputProvenance.attr("disabled", "disabled");
    }else{
        action.inputProvenance.removeAttr('disabled')
    }
    afficherCardLots()
}

function delete_bac(key, index){
    form.lots[index].bacs.splice(key,1);
    
    afficherCardBacs(index)
}

function change_village_lot(field,key){
    form.lots[key].village = {
        id: field.value,
        nom: field.text
    }
    //afficherCardBacs()
}
function change_poids_lot(field,key){
    form.lots[key].poids = field.value
    //afficherCardBacs()
}

function add_input_crabe(index){
    var nbCrabe = $(`#crabe-nb${index}`).val()
    if(isNaN(nbCrabe) || nbCrabe <= 0){
        $(`#crabe-nb${index}`).addClass('is-invalid');
    }else{
        $(`#add-input-crabe${index}`).attr('disabled','disabled')
        $(`#crabe-nb${index}`).attr('readonly','readonly')
        $(`#reinitialize-input-crabe${index}`).removeAttr('disabled')
        $(`#btn-add-crabe${index}`).removeAttr('disabled')
        $(`#crabe-nb${index}`).removeClass('is-invalid');
        var biometrie = ""
        var  point = 1
        for(let iteration = 0; iteration < nbCrabe; iteration++){
            if(iteration == point-1){
                if(nbCrabe/40 > 0 && nbCrabe/40 <= 1){
                biometrie+=`
                <div class="col-md-12">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Taille (mm)</th>
                                <th>Sexe(M/F)</th>
                            </tr>
                        </thead>
                        <tbody id="input-crabe-container${index}">               
                `;}else if(nbCrabe/40 > 1 && nbCrabe/40 <= 2){
                    biometrie+=`
                <div class="col-md-6">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Taille (mm)</th>
                                <th>Sexe(M/F)</th>
                            </tr>
                        </thead>
                        <tbody id="input-crabe-container${index}">               
                `;
                }else{
                    biometrie+=`
                <div class="col-md-4">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Taille (mm)</th>
                                <th>Sexe(M/F)</th>
                            </tr>
                        </thead>
                        <tbody id="input-crabe-container${index}">               
                `;
                }
                point+=40;
            }
            biometrie+=`<tr>
                            <td>${form.lots[index].crabes.length+iteration+1}</td>
                            <td><input type="number"class="form-control" name="lot${index}crabe${iteration}taille" id="lot${index}crabe${iteration}taille">
                                <br>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="lot${index}checkST${iteration}" name="lot${index}checkST${iteration}">
                                        <label for="lot${index}checkST${iteration}">Sous Taille</label>
                                    </div>
                                </div>
                            </td>
                            <td><div class="icheck-primary d-inline">
                                    <input type="radio" id="lot${index}radio1Crabe${iteration}" value="M" name="lot${index}crabe${iteration}sexe" checked>
                                    <label for="lot${index}radio1Crabe${iteration}">Mâle</label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="lot${index}radio2Crabe${iteration}" value="F" name="lot${index}crabe${iteration}sexe">
                                    <label for="lot${index}radio2Crabe${iteration}">Femelle</label>
                                </div>
                            </td>
                        </tr> `;

            if(iteration+1 >= nbCrabe || iteration == point-2 ){
                biometrie+=`</tbody>
                    </table>
                </div>`;
            }
        }

        $(`#input-crabe-container${index}`).html(biometrie);
    }
}

function reinitialize_input_crabe(index){
    $(`#reinitialize-input-crabe${index}`).attr('disabled','disabled')
    $(`#btn-add-crabe${index}`).attr('disabled','disabled')
    $(`#add-input-crabe${index}`).removeAttr('disabled')
    $(`#crabe-nb${index}`).removeAttr('readonly')
    $(`#input-crabe-container${index}`).html("");
}

// Fonction de renseignement de données de crabe
function add_crabe(index){
    
    let nbCrabe = $(`#crabe-nb${index}`).val()
    var crabes = []
    var success = true
    for(let iteration = 0; iteration<nbCrabe;iteration++){
        $(`[name=lot${index}crabe${iteration}taille]`).removeClass('is-invalid');
        if($(`[name=lot${index}crabe${iteration}taille]`).val() > 0){
            crabes = [
                ...crabes,
                {
                    taille: $(`[name=lot${index}crabe${iteration}taille]`).val(),
                    sexe: $(`[name=lot${index}crabe${iteration}sexe]:checked`).val()
                }
            ]
        }else{
            if($(`[name=lot${index}checkST${iteration}]`).is(":checked")){
                crabes = [
                ...crabes,
                {
                    taille: 0,
                    sexe: $(`[name=lot${index}crabe${iteration}sexe]:checked`).val()
                }
            ]
            }else{
                success = false
                $(`[name=lot${index}crabe${iteration}taille]`).addClass('is-invalid');
            }
        }
    }

    if(!success){
        crabes = []
    }else{
        // Fermeture du formulaire d'ajout de crabe
        $(`#modal-add-crabe${index}`).modal('hide')
        $.map(crabes, function(x,y){
            form.lots[index].crabes = [...form.lots[index].crabes,{
                taille: x.taille,
                sexe: x.sexe
            }]
        })
        reinitialize_input_crabe(index)
        afficher_crabes(index)

    }
    console.log(form.lots[index].crabes)
    
}

function afficher_crabes(index){
    if(form.lots[index].crabes.length > 0){

        $(`#nbCrabeEchantillonne${index}`).html(`${form.lots[index].crabes.length} crabes échantillonnés 
        <button type="button" onclick="format_crabe(${index})" class="btn btn-link"><i class="fa fa-minus-circle"></i>Vider la liste</button>`)
        var liste = ""
        var  point = 1
        $.map(form.lots[index].crabes, function(x,y){
            if(y == point-1){
                if(form.lots[index].crabes.length/40 > 0 && form.lots[index].crabes.length/40 <= 1){
                    liste+=`
                    <div class="col-md-12">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Taille (mm)</th>
                                    <th>Sexe(M/F)</th>
                                </tr>
                            </thead>
                            <tbody id="crabe${y}-container${index}">              
                    `;
                }else if(form.lots[index].crabes.length/40 <= 2 && form.lots[index].crabes.length/40 > 1){
                    liste+=`
                    <div class="col-md-6">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Taille (mm)</th>
                                    <th>Sexe(M/F)</th>
                                </tr>
                            </thead>
                            <tbody id="crabe${y}-container${index}">                
                    `;
                }else{
                    liste+=`
                    <div class="col-md-4">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Taille (mm)</th>
                                    <th>Sexe(M/F)</th>
                                </tr>
                            </thead>
                            <tbody id="crabe${y}-container${index}">               
                    `;
                }
                
                point+=40;
            }
            liste+=`<tr>
                        <td>${y+1}</td>
                        <td>`+
                        (x.taille == 0 ? `Sous taille`:`${x.taille}`)
                        +  
                        `</td>
                        <td>`+
                        (x.sexe == "M" ? `Mâle`:`Femelle`)
                        +  
                        `
                        </td>
                    </tr>`;

            if(y+1 > form.lots[index].crabes.length || y == point-2 ){
                liste+=`</tbody>
                    </table>
                </div>`;
            }
        })
        $(`#conteneur-crabe${index}`).html(liste)
    }else{
        $(`#nbCrabeEchantillonne${index}`).html("")
        $(`#conteneur-crabe${index}`).html("")
    }
}

//Enregistrement des données et envoi vers la base de données
action.enregistrer.on('click', e =>{

    if(check_contrainte()){
            $.alert({
            content: function () {
                var self = this;
                return $.ajax({
                    url: `${BASE_URL}/suivi-societe/saisie-enquete/insertion_separe`,

                    data: form,

                    type: 'post',

                    dataType: 'json'
                }).done(function (response){
                    if(response.result){
                        self.setContent(response.message)
                        self.setTitle(response.title)
                        setTimeout(() => location.href = `${BASE_URL}/consultation-suivi-societe/detail-et-action/${form.cargaison}`, 1000);
                    }else{
                        self.setContent(response.message)
                        self.setTitle(response.title)
                    }
                }).fail(function() {
                    self.setContent('Une erreur a été rencontré, veuillez vérifier vos entrées ou contactez l\'administrateur')
                    self.setTitle('Erreur!')
                })
            }
        })
    }else{
        $.alert({
            title: "Erreur!",
            content: "Les données sont manquantes, veuillez vérifier les données de provenance et les poids de chaque lot!"
        })
    }
})

function check_contrainte(){
    var contrainte = true
    if(form.provenance.length<=0) contrainte=false
    if(form.lots.length<=0) contrainte=false
    $.map(form.lots, function(x,y){
        if(x.poids <= 0 || x.poids == null) contrainte=false
        if(x.village.id == null || x.village.id =="") contrainte=false
    })
    return contrainte
}