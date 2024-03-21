


const form = {
cargaison: $(`[name=js-cargaison]`).val(),
provenance: [],
lots: {
    numFiche: '',
    village: null,
    poids: null,
    crabes: []
},
bacs: []

}
const action = {

corps: $('#js-formulaire'),
boutonAjouterBac: $('#js-ajouter-bac'),
inputProvenance: $('#js-villages'),
inputNumFiche: $('#js-numFiche'),
enregistrer: $('#js-enregistrer'),
inputCrabe: $('#add-input-crabe'),
nbCrabe: $('#crabe-nb'),
inputCrabeContainer: $('#input-crabe-container'),
reinitializeInputCrabe: $('#reinitialize-input-crabe'),
add_crabe: $('#btn-add-crabe'),
list_crabes: $('#conteneur-crabe'),
nbCrabeEchantillonne: $('#nbCrabeEchantillonne'),
}


function format_crabe(){
    form.lots.crabes = []
    afficher_crabes()
}


function afficher_crabes(){
    if(form.lots.crabes.length > 0){

        action.nbCrabeEchantillonne.html(`${form.lots.crabes.length} crabes échantillonnés 
        <button type="button" onclick="format_crabe()" class="btn btn-link"><i class="fa fa-minus-circle"></i>Vider la liste</button>`)
        var liste = ""
        var  point = 1
        $.map(form.lots.crabes, function(x,y){
            if(y == point-1){
                if(form.lots.crabes.length/40 > 0 && form.lots.crabes.length/40 <= 1){
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
                            <tbody id="crabe-container">
                                <tr>
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
                                </tr>                
                    `;
                }else if(form.lots.crabes.length/40 <= 2 && form.lots.crabes.length/40 > 1){
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
                            <tbody id="crabe-container">
                                <tr>
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
                                </tr>                
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
                            <tbody id="crabe-container">
                                <tr>
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
                                </tr>                
                    `;
                }
                
                point+=40;
            }else{
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
            }

            if(y+1 > form.lots.crabes.length || y == point-2 ){
                liste+=`</tbody>
                    </table>
                </div>`;
            }
        })
        action.list_crabes.html(liste)
    }else{
        action.nbCrabeEchantillonne.html("")
        action.list_crabes.html("")
    }
}

$('.select2').select2({

    theme: 'bootstrap4'

  })



action.reinitializeInputCrabe.click(function(){
    action.reinitializeInputCrabe.attr('disabled','disabled')
    action.add_crabe.attr('disabled','disabled')
    action.inputCrabe.removeAttr('disabled')
    action.nbCrabe.removeAttr('readonly')
    action.inputCrabeContainer.html("");
})



action.inputCrabe.click(function(){
    var nbCrabe = action.nbCrabe.val()
    if(isNaN(nbCrabe) || nbCrabe <= 0){
        action.nbCrabe.addClass('is-invalid');
    }else{
        action.inputCrabe.attr('disabled','disabled')
        action.nbCrabe.attr('readonly','readonly')
        action.reinitializeInputCrabe.removeAttr('disabled')
        action.add_crabe.removeAttr('disabled')
        action.nbCrabe.removeClass('is-invalid');
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
                        <tbody id="input-crabe-container">
                            <tr>
                                <td>${form.lots.crabes.length+iteration+1}</td>
                                <td><input type="number"class="form-control" name="crabe${iteration}taille" id="crabe${iteration}taille">
                                    <br>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkST${iteration}" name="checkST${iteration}">
                                            <label for="checkST${iteration}">Sous Taille</label>
                                        </div>
                                    </div>
                                </td>
                                <td><div class="icheck-primary d-inline">
                                        <input type="radio" id="radio1Crabe${iteration}" value="M" name="crabe${iteration}sexe" checked>
                                        <label for="radio1Crabe${iteration}">Mâle</label>
                                    </div>
                                    <div class="icheck-success d-inline">
                                        <input type="radio" id="radio2Crabe${iteration}" value="F" name="crabe${iteration}sexe">
                                        <label for="radio2Crabe${iteration}">Femelle</label>
                                    </div>
                                </td>
                            </tr>                
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
                        <tbody id="input-crabe-container">
                            <tr>
                                <td>${form.lots.crabes.length+iteration+1}</td>
                                <td><input type="number"class="form-control" name="crabe${iteration}taille" id="crabe${iteration}taille">
                                    <br>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkST${iteration}" name="checkST${iteration}">
                                            <label for="checkST${iteration}">Sous Taille</label>
                                        </div>
                                    </div>
                                </td>
                                <td><div class="icheck-primary d-inline">
                                        <input type="radio" id="radio1Crabe${iteration}" value="M" name="crabe${iteration}sexe" checked>
                                        <label for="radio1Crabe${iteration}">Mâle</label>
                                    </div>
                                    <div class="icheck-success d-inline">
                                        <input type="radio" id="radio2Crabe${iteration}" value="F" name="crabe${iteration}sexe">
                                        <label for="radio2Crabe${iteration}">Femelle</label>
                                    </div>
                                </td>
                            </tr>                
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
                        <tbody id="input-crabe-container">
                            <tr>
                                <td>${form.lots.crabes.length+iteration+1}</td>
                                <td><input type="number"class="form-control" name="crabe${iteration}taille" id="crabe${iteration}taille">
                                    <br>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkST${iteration}" name="checkST${iteration}">
                                            <label for="checkST${iteration}">Sous Taille</label>
                                        </div>
                                    </div>
                                </td>
                                <td><div class="icheck-primary d-inline">
                                        <input type="radio" id="radio1Crabe${iteration}" value="M" name="crabe${iteration}sexe" checked>
                                        <label for="radio1Crabe${iteration}">Mâle</label>
                                    </div>
                                    <div class="icheck-success d-inline">
                                        <input type="radio" id="radio2Crabe${iteration}" value="F" name="crabe${iteration}sexe">
                                        <label for="radio2Crabe${iteration}">Femelle</label>
                                    </div>
                                </td>
                            </tr>                
                `;
                }
                point+=40;
            }else{
                biometrie+=`<tr>
                                <td>${form.lots.crabes.length+iteration+1}</td>
                                <td><input type="number"class="form-control" name="crabe${iteration}taille" id="crabe${iteration}taille">
                                    <br>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkST${iteration}" name="checkST${iteration}">
                                            <label for="checkST${iteration}">Sous Taille</label>
                                        </div>
                                    </div>
                                </td>
                                <td><div class="icheck-primary d-inline">
                                        <input type="radio" id="radio1Crabe${iteration}" value="M" name="crabe${iteration}sexe" checked>
                                        <label for="radio1Crabe${iteration}">Mâle</label>
                                    </div>
                                    <div class="icheck-success d-inline">
                                        <input type="radio" id="radio2Crabe${iteration}" value="F" name="crabe${iteration}sexe">
                                        <label for="radio2Crabe${iteration}">Femelle</label>
                                    </div>
                                </td>
                            </tr>`;
            }

            if(iteration+1 >= nbCrabe || iteration == point-2 ){
                biometrie+=`</tbody>
                    </table>
                </div>`;
            }
        }

        action.inputCrabeContainer.html(biometrie);
    }
})


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
})

//Renseignement du numero de fiche du lot
function change_numFiche(field){
    form.lots.numFiche = field.value
}
//Renseignement du poids du lot
function change_poids_lot(field){
    form.lots.poids = field.value
}

//Click sur le bouton ajouter bac
action.boutonAjouterBac.on('click', e => {
    form.bacs= [...form.bacs,{
        type: 'bac',
        poidsBac: 0
    }];

    afficherCardBacs();
})

function delete_bac(key){
    form.bacs.splice(key,1);
    afficherCardBacs()
}

// Ecoute sur l'évènement changement de poids de bac
function change_poids(field,key){
    form.bacs[key].poidsBac = field.value
    //afficherCardBacs()
}

// Ecoute sur l'évènement changement de type de bac
function change_type(field,key){
    form.bacs[key].type = field.value
    //afficherCardBacs()
}

// Fonction de renseignement de données de crabe
function add_crabe(){
    
    let nbCrabe = action.nbCrabe.val()
    var crabes = []
    var success = true
    for(let iteration = 0; iteration<nbCrabe;iteration++){
        $(`[name=crabe${iteration}taille]`).removeClass('is-invalid');
        if($(`[name=crabe${iteration}taille]`).val() > 0){
            crabes = [
                ...crabes,
                {
                    taille: $(`[name=crabe${iteration}taille]`).val(),
                    sexe: $(`[name=crabe${iteration}sexe]:checked`).val()
                }
            ]
        }else{
            if($(`[name=checkST${iteration}]`).is(":checked")){
                crabes = [
                ...crabes,
                {
                    taille: 0,
                    sexe: $(`[name=crabe${iteration}sexe]:checked`).val()
                }
            ]
            }else{
                success = false
                $(`[name=crabe${iteration}taille]`).addClass('is-invalid');
            }
        }
    }

    if(!success){
        crabes = []
    }else{
        // Fermeture du formulaire d'ajout de crabe
        $(`#modal-add-crabe`).modal('hide')
        $.map(crabes, function(x,y){
            form.lots.crabes = [...form.lots.crabes,{
                taille: x.taille,
                sexe: x.sexe
            }]
        })
        action.reinitializeInputCrabe.attr('disabled','disabled')
        action.add_crabe.attr('disabled','disabled')
        action.inputCrabe.removeAttr('disabled')
        action.nbCrabe.removeAttr('readonly')
        action.inputCrabeContainer.html("");
        afficher_crabes()

    }
    console.log(form.lots.crabes)
    
}

// Affichage des donées de bacs renseignés et par défaut
function afficherCardBacs(){
    $('#conteneur-bacs').html("");
    var bacsInverse = []
    for(var i=form.bacs.length;i>0;i--){
        bacsInverse = [...bacsInverse,form.bacs[i-1]]
    }
    // let biometrie = []
    $.map(bacsInverse, function(x,y){
        $('#conteneur-bacs').append(`
        <div class="col-md-2">
            <div class="card">
            <div class="card-header border-0"><label class="text">
                ♦ BAC N°${bacsInverse.length-y}</label>
                <div class="card-tools">
                    <button type="button" onclick="delete_bac(${bacsInverse.length-y-1})" class="btn btn-danger btn-sm" id="js-fermer${bacsInverse.length-y-1}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
                <div class="row px-2">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="js-bac-type${bacsInverse.length-y-1}">Type<span class="text text-red">*</span></label>
                            <div class="select2-purple">
                                <select class="custom-select" onchange="change_type(this,${bacsInverse.length-y-1})" data-live-search="true" id="js-bac-type${y}" style="width: 100%;" name="js-bac-type${y}" required>`+
                                    (x.type == 'bac' ? `<option value="bac" selected>Bac</option>`:`<option value="bac">Bac</option>`)+
                                    (x.type == 'gony' ? `<option value="gony" selected>Gony</option>`:`<option value="gony">Gony</option>`)+
                                `</select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="js-bac-poids${bacsInverse.length-y-1}">Poids<span class="text text-red">*</span></label>
                                <div class="input-group">
                                <input type="number" onkeyup="change_poids(this,${bacsInverse.length-y-1})" class="form-control" id="js-bac-poids${bacsInverse.length-y-1}" value="${x.poidsBac}" name="js-bac-poids${bacsInverse.length-y-1}" step="0.1" required>
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

//Enregistrement des données et envoi vers la base de données
action.enregistrer.on('click', e =>{

    if(form.provenance.length && form.lots.numFiche != '' && form.lots.poids != null){
            $.alert({
            content: function () {
                var self = this;
                return $.ajax({
                    url: `${BASE_URL}/suivi-societe/saisie-enquete/insertion`,

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
            content: "Les données sont manquantes, veuillez vérifier les données de provenance, numéro de la fiche et le poids du lot!"
        })
    }
})