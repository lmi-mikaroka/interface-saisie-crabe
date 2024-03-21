$('.select2').select2({

    theme: 'bootstrap4'

})

const form = {
datedebarquement: null,
dateexpedition: null,
zone: null,
societe: null,
transport: 'bateau',
enqueteur: null,
poidstotalcargaison: null,
provenance: [],
lots: []
}

const action = {
  debarquement: $('#debarquement'),
  expedition: $('#expedition'),
  zone: $('#zone'),
  societe: $('#societe'),
  transport: $('#transport'),
  enqueteur: $('#enqueteur'),
  poidstotalcargaison: $('#poids'),
  villages: $('#villages'),
  ajouter_fiche: $('#ajouter_fiche'),
  conteneur_lot: $('#conteneur_lot'),
  enregistrer: $('#enregistrer'),
  enregistrer_nouvelle: $('#enregistrer-nouvelle'),
}


action.enregistrer.on('click', function(){
    if(check_info_cargaison().result){
        if(form.lots.length>0){
            result = {"result": check_info_lot().result, "message": check_info_lot().message}
            if(result.result){
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
                                setTimeout(() => location.href = `${BASE_URL}/consultation-suivi-societe/detail-et-action/${response.cargaison}`, 1000);
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
                erreur(result.message)
            }
        }else{
            erreur("Il faut renseigner au moins un lot de données")
        }
    }else{
        erreur(check_info_cargaison().message)
    }
})
action.enregistrer_nouvelle.on('click', function(){
    if(check_info_cargaison().result){
        if(form.lots.length>0){
            result = {"result": check_info_lot().result, "message": check_info_lot().message}
            if(result.result){
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
                                setTimeout(() => location.href = `${BASE_URL}/suivi-societe-ajout.html`, 1000);
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
                erreur(result.message)
            }
        }else{
            erreur("Il faut renseigner au moins un lot de données")
        }
    }else{
        erreur(check_info_cargaison().message)
    }
})

function erreur(message){
    $.alert({
            title: "Erreur",
            content: message
        })
}

function check_info_cargaison(){
    if(form.datedebarquement != null && form.datedebarquement != ""){
        if(form.zone !=null && form.zone != ""){
            if(form.societe != null && form.societe != ""){
                    if(form.poidstotalcargaison != null && form.poidstotalcargaison >= 100 && form.poidstotalcargaison <= 20000){
                        if(form.provenance.length >= 1){
                            return {'result':true, 'message':'Informations complètes'}
                        }else return {'result':false, 'message':'Il faut au moins un village de provenance!'}
                    }else return {'result':false, 'message':'Le poids total de la cargaison doit être compris entre 100kg à 20000kg!'}
            }else return {'result':false, 'message':'Il faut choisir une société de collecte!'}
        }else return {'result':false, 'message':'Il faut choisir une zone biogéographique'}
    }else return {'result':false, 'message':'Il faut renseigner la date de débarquement!'}
}

function check_info_lot(){
        result = true
        message ="Informations complètes"
    for(index=0;index<form.lots.length;index++){
        if(form.lots[index].crabes.length < 20 || form.lots[index].bacs.length < 1){
            result = false
            message = "Veuillez vérifier vos entrées! il faut renseigner au moins un bac et échantillonner au minimum 20 crabes par fiche"
        }else{
            $.map(form.lots[index].bacs, function(x,y){
            if(x.poidsbac < 10 || x.poidsbac > 100){
                result = false
                message = "Veuillez vérifier vos entrées! Le poids d'un bac doit être compris entre 10 à 100kg"
            }
        })
        $.map(form.lots[index].crabes, function(x,y){
            if(x.checked != "checked" && (x.taille==""||x.taille<110||x.taille>220)){
                result = false
                message = "Veuillez vérifier vos entrées! La taille d'un crabe doit être compris entre 110 à 220mm! cocher la case à gauche du champ si la taille est inférieur à 110"
            }
        })
        }
    }
    return {"result":result, "message": message}
}

//Renseignement des données de la cargaison
action.debarquement.change(function(){
  form.datedebarquement = action.debarquement.val()
})
action.expedition.change(function(){
  form.dateexpedition = action.expedition.val()
})
action.zone.change(function(){
  form.zone = action.zone.val()
})
action.societe.change(function(){
  form.societe = action.societe.val()
})
action.transport.change(function(){
  form.transport = action.transport.val()
})
action.enqueteur.change(function(){
  form.enqueteur = action.enqueteur.val()
})
action.poidstotalcargaison.keyup(function(){
  form.poidstotalcargaison = action.poidstotalcargaison.val()
})

//Renseignement des données de provenance
action.villages.change(function(){
   var provenance = []
    $('option:selected', $(this)).each(function(){
        provenance = [...provenance,{
            id: $(this).val(),
            nom: $(this).text(),
            selected: false
        }]
    })
    form.provenance = provenance
    if(form.provenance.length > 0 && form.lots.length == 0){
        action.ajouter_fiche.removeAttr('disabled')
    }else{
        action.ajouter_fiche.attr('disabled','disabled')
    }
    afficherCardLots()
})

//clic sur le bouton nouvelle fiche
action.ajouter_fiche.on('click', e => {
    form.lots= [...form.lots,{
        village:  {
          id: null,
          nom: null
        },
        poids: 0,
        crabes: [],
        bacs: []
    }];

    checktype()
    console.log(form.lots)
    afficherCardLots();
})

function afficherCardLots(){
    var lotsInverse = []
    for(var i=form.lots.length;i>0;i--){
        lotsInverse = [...lotsInverse,form.lots[i-1]]
    }
    action.conteneur_lot.html("")
    $.map(lotsInverse, function(x,y){
        var collapsed = ""
        var minus = "minus"
        var min = 20
        if(y>0){
            collapsed = "collapsed-card"
            minus = "plus"
        } 
        action.conteneur_lot.append(`
        <div class="col-md-12">
            <div class="card ${collapsed}">
                <div class="card-header  align-middle">
                    <h1 class="card-title"><span id="warning${lotsInverse.length-y-1}"></span> LOT/FICHE N° ${lotsInverse.length-y}</h1>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-${minus}"></i></button>
                        <button type="button" onclick="delete_lot(${lotsInverse.length-y-1})" class="btn btn-danger btn-sm" id="fermer${lotsInverse.length-y-1}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9" style="border-right: 1px solid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h6 style="font-weight: bold">Informations sur chaque bac/gony (kg)</h6>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-default btn-block" onclick="add_bac(${lotsInverse.length-y-1})">Nouveau bac</button>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group">`+
                                            (x.crabes.length == 0 ? `<input type="number" class="form-control" step="1" name="nb_crabe${lotsInverse.length-y-1}" min="20" placeholder="nbr de crabe à ajouter à l'échantillon"/>`:`<input type="number" class="form-control" step="1" name="nb_crabe${lotsInverse.length-y-1}" min="1" placeholder="nbr de crabe à ajouter à l'échantillon"/>`)
                                            +`
                                                <span class="input-group-append">
                                                    <button type="button" onclick="add_crabe(${lotsInverse.length-y-1})" class="btn btn-warning btn-flat">Ajouter les mesures de crabes</button>
                                                </span>
                                                <span class="input-group-append">
                                                    <button type="button" onclick="vider_crabe(${lotsInverse.length-y-1})" class="btn btn-danger btn-flat">Vider</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row" id="conteneur-bacs${lotsInverse.length-y-1}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="border-right: 1px solid">
                            <div class="row" style="display:flex; align-items: center">
                                <div class="col-md-4"><h6 style="font-weight: bold">Village</h6></div>
                                <div class="col-md-8 mb-1">
                                    <div class="select2-purple">
                                        <select class="form-control select2" data-dropdown-css-class="select2-purple" onchange="change_village_lot(this,${lotsInverse.length-y-1})" id="js-villages" name="village-lot${lotsInverse.length-y-1}" required>`+
                                            (form.lots.length <= 1 ? `<option value="">Lot unique pour les villages</option>`:`<option value="" disabled>Lot unique pour les villages</option>`)+
                                                $.map(form.provenance, function(a,b){

                                                    if(x.village.id && a.id==x.village.id){
                                                    return `<option value="${a.id}" selected>${a.nom}</option>`
                                                    }else{
                                                    if(a.selected){
                                                    return `<option value="${a.id}" disabled>${a.nom}</option>`
                                                    }else{
                                                        return `<option value="${a.id}">${a.nom}</option>`
                                                    }
                                                    }
                                                })+`
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4"><h6 style="font-weight: bold">Poids total du lot échantillonné</h6></div>
                                <div class="col-md-8 mb-1">
                                    <input type="number" class="form-control" readonly placeholder="en kg" name="js-poids-lot${lotsInverse.length-y-1}" step="0.1" value="${x.poids}" required>
                                    <small>en kg, &#8721poids des bacs du lot</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2" id="conteneur_crabe${lotsInverse.length-y-1}">

                    </div>
                </div>
            </div>
        </div>
        `)

        if(x.village.id==null){
            form.lots[lotsInverse.length-y-1].village = {
                id: $(`[name=village-lot${lotsInverse.length-y-1}]`).val(),
                nom: ""
            }     
            
            $.map(form.provenance, function(a,b){
                if(a.id == $(`[name=village-lot${lotsInverse.length-y-1}]`).val()){
                  form.provenance[b].selected = true
                }
              })
        }

        afficherCardBacs(lotsInverse.length-y-1)
        afficher_crabes(lotsInverse.length-y-1)
        warning(lotsInverse.length-y-1)
    })
}


function afficherCardBacs(index){
    $(`#conteneur-bacs${index}`).html("");
    var bacsInverse = []
    for(var i=form.lots[index].bacs.length;i>0;i--){
        bacsInverse = [...bacsInverse,form.lots[index].bacs[i-1]]
    }
    $.map(bacsInverse, function(x,y){
        $(`#conteneur-bacs${index}`).append(`
        <div class="col-md-4">
            <div class="card">
                <div class="card-header border-0">
                    <label class="text">♦ BAC N°${bacsInverse.length-y}</label>
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
                                    (x.type == 'bac planche' ? `<option value="bac planche" selected>Bac planche</option>`:`<option value="bac planche">Bac planche</option>`)+
                                    (x.type == 'bac plastique' ? `<option value="bac planche" selected>Bac plastique</option>`:`<option value="bac plastique">Bac plastique</option>`)+
                                    (x.type == 'gony' ? `<option value="gony" selected>Gony</option>`:`<option value="gony">Gony</option>`)+
                                    (x.type == 'autre' ? `<option value="autre" selected>Autre</option>`:`<option value="autre">Autre</option>`)+
                                `</select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="lot${index}-bac${bacsInverse.length-y-1}-poids">Poids<span class="text text-red">*</span></label>
                                <div class="input-group">
                                <input type="number" onkeyup="change_poids(this,${bacsInverse.length-y-1}, ${index})" class="form-control" id="lot${index}-bac${bacsInverse.length-y-1}-poids" value="${x.poidsbac}" name="lot${index}-bac${bacsInverse.length-y-1}-poids" step="0.1" required>
                            </div>
                            <small>en kg, [10,100]</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>`
        )
    })
}

function add_bac(index){
    form.lots[index].bacs = [...form.lots[index].bacs,{
        type: 'bac planche',
        poidsbac: 0
    }]

    afficherCardBacs(index)
    warning(index)
}

function delete_lot(key){
  $.map(form.provenance, function(x,y){
    if(form.lots[key].village.id == x.id){
      form.provenance[y].selected = false
    }
  })
    form.lots.splice(key,1);
    checktype()
    afficherCardLots()
}
function delete_bac(key, index){
    form.lots[index].bacs.splice(key,1);
    form.lots[index].poids = 0
    $.map(form.lots[index].bacs, function(x,y){
        form.lots[index].poids+=parseFloat(x.poidsbac)
    })
    $(`[name=js-poids-lot${index}]`).attr('value',form.lots[index].poids)
    afficherCardBacs(index)
    warning(index)
}

function change_village_lot(field,key){
  $.map(form.provenance, function(x,y){
    if(form.lots[key].village.id == x.id){
      form.provenance[y].selected = false
    }else if(x.id == field.value){
      form.provenance[y].selected = true
    }
  })
    form.lots[key].village = {
        id: field.value,
        nom: field.text
    }

    checktype()
    //afficherCardBacs()
}

function change_type(field,key,lot){
    form.lots[lot].bacs[key].type = field.value
}

function change_poids(field,key,lot){
    poidsbac = 0
    if(field.value != "") poidsbac = parseFloat(field.value)
    form.lots[lot].bacs[key].poidsbac = poidsbac
    form.lots[lot].poids = 0
    $.map(form.lots[lot].bacs, function(x,y){
        form.lots[lot].poids+=parseFloat(x.poidsbac)
    })
    warning(lot)
    $(`[name=js-poids-lot${lot}]`).attr('value',form.lots[lot].poids)
    
}

function checktype(){
        if(form.lots.length>0){
            if(form.lots.length == 1){
                if(form.lots[0].village.id == null || form.lots[0].village.id == ""){
                    action.ajouter_fiche.attr('disabled','disabled')
                    action.villages.removeAttr('disabled')
                }else{
                    if(form.lots.length === form.provenance.length){
                        action.ajouter_fiche.attr('disabled','disabled')
                    }else{
                        action.ajouter_fiche.removeAttr('disabled')
                    }
                    action.villages.attr("disabled", "disabled");
                }
            }else{
                if(form.lots.length === form.provenance.length){
                    action.ajouter_fiche.attr('disabled','disabled')
                }else{
                    action.ajouter_fiche.removeAttr('disabled')
                }
                action.villages.attr("disabled", "disabled");
            }
            
        }else{
            action.villages.removeAttr('disabled')
            action.ajouter_fiche.removeAttr('disabled')
        }
}

function checkfichevillage(){
    if(form.lots.length === form.provenance.length){
        action.ajouter_fiche.attr('disabled','disabled')
    }else{
        action.ajouter_fiche.removeAttr('disabled')
    }
}

// Fonction de renseignement de données de crabe
function add_crabe(index){
    
    let nbCrabe = parseInt($(`[name=nb_crabe${index}]`).val())
    if(isNaN(nbCrabe) || nbCrabe < $(`[name=nb_crabe${index}]`).attr('min')){
        $(`[name=nb_crabe${index}]`).addClass('is-invalid');
    }else{
        $(`[name=nb_crabe${index}]`).removeClass('is-invalid');
        for(iteration=0;iteration<nbCrabe;iteration++){
            form.lots[index].crabes = [
                ...form.lots[index].crabes,
                {
                    taille: "",
                    sexe: "M",
                    checked: ""
                }
            ]
        }
        afficher_crabes(index)
    }
    warning(index)
}
function vider_crabe(index){
    $(`[name=nb_crabe${index}]`).removeClass('is-invalid');
    $(`[name=nb_crabe${index}]`).attr('min',20);
    form.lots[index].crabes = []
    afficher_crabes(index)
    warning(index)
}

function afficher_crabes(index){
    $(`#conteneur_crabe${index}`).html("")
    if(form.lots[index].crabes.length > 0){
        var liste = ""
        var  point = 1
        $.map(form.lots[index].crabes, function(x,y){
            if(y == point-1){
                if(form.lots[index].crabes.length/40 > 0 && form.lots[index].crabes.length/40 <= 1){
                    liste+=`
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped table-sm">
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
                        <table class="table table-bordered table-striped table-sm">
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
                        <table class="table table-bordered table-striped table-sm">
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
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <input type="checkbox" ${x.checked} onchange="change_check_taille(${index},${y})" name="lot${index}crabe${y}checked">
                                    </span>
                                </div>`+
                                (x.checked == "checked" ? `<input type="number" onkeyup="change_taille(${index},${y})" step="0.1" min="110" max="220" value="${x.taille}" name="lot${index}crabe${y}taille"  class="form-control form-control-sm" readonly>` : (x.taille == "" || x.taille == 0 ? `<input type="number" step="0.1" min="110" max="220" onkeyup="change_taille(${index},${y})" value="${x.taille}" name="lot${index}crabe${y}taille"  class="form-control form-control-sm is-invalid">` : `<input type="number" step="0.1" onkeyup="change_taille(${index},${y})" min="110" max="220" value="${x.taille}" name="lot${index}crabe${y}taille"  class="form-control form-control-sm">`))
                            +`</div>
                        </td>
                        <td>`+

                        (x.sexe == 'M' ? `<input type="radio" name="lot${index}crabe${y}sexe" onchange="change_sexe(${index},${y})" id="lot${index}crabe${y}sexe" value="M" checked><label>M</label>`:`<input type="radio" onchange="change_sexe(${index},${y})" name="lot${index}crabe${y}sexe" id="lot${index}crabe${y}sexe" value="M"><label>M</label>`)+
                        (x.sexe == 'F' ? `<input type="radio" onchange="change_sexe(${index},${y})" name="lot${index}crabe${y}sexe" id="lot${index}crabe${y}sexe" value="F" checked><label>F</label>`:`<input onchange="change_sexe(${index},${y})" type="radio" name="lot${index}crabe${y}sexe" id="lot${index}crabe${y}sexe" value="F"><label>F</label>`)+
                        (form.lots[index].crabes.length > 20 ? `<button type="button" onclick="delete_crabe(${index},${y})" class="btn btn-link text-danger"><i class="fa fa-times"></i></button>`:`<button type="button" onclick="delete_crabe(${index},${y})" class="btn btn-link text-danger" disabled><i class="fa fa-times"></i></button>`)
                        +`</td>
                    </tr>`;

            if(y+1 > form.lots[index].crabes.length || y == point-2 ){
                liste+=`</tbody>
                    </table>
                </div>`;
            }
        })
        $(`#conteneur_crabe${index}`).html(liste)
        $(`[name=nb_crabe${index}]`).attr('min',1)
    }
}

function change_check_taille(index,y){
    if(form.lots[index].crabes[y].checked == "checked"){
        form.lots[index].crabes[y].checked = ""
        if(form.lots[index].crabes[y].taille == "" || parseInt(form.lots[index].crabes[y].taille) < parseInt($(`[name=lot${index}crabe${y}taille]`).attr('min')) || parseInt(form.lots[index].crabes[y].taille) > parseInt($(`[name=lot${index}crabe${y}taille]`).attr('max'))){
            $(`[name=lot${index}crabe${y}taille]`).addClass('is-invalid')
            $(`[name=lot${index}crabe${y}taille]`).removeAttr('readonly','readonly')
        }else{
            $(`[name=lot${index}crabe${y}taille]`).removeClass('is-invalid')
            $(`[name=lot${index}crabe${y}taille]`).removeAttr('readonly','readonly')
        }
        
    }else{
        form.lots[index].crabes[y].checked = "checked"
        $(`[name=lot${index}crabe${y}taille]`).removeClass('is-invalid')
        form.lots[index].crabes[y].taille = ""
        $(`[name=lot${index}crabe${y}taille]`).val(form.lots[index].crabes[y].taille)
        $(`[name=lot${index}crabe${y}taille]`).attr('readonly','readonly')

    }
    warning(index)
}

function change_taille(index,y){
    if($(`[name=lot${index}crabe${y}taille]`).val() == "" || parseInt($(`[name=lot${index}crabe${y}taille]`).val()) < parseInt($(`[name=lot${index}crabe${y}taille]`).attr('min')) || parseInt($(`[name=lot${index}crabe${y}taille]`).val()) > parseInt($(`[name=lot${index}crabe${y}taille]`).attr('max'))){
        $(`[name=lot${index}crabe${y}taille]`).addClass('is-invalid')
    }else{
        $(`[name=lot${index}crabe${y}taille]`).removeClass('is-invalid')
    }
    form.lots[index].crabes[y].taille = parseInt($(`[name=lot${index}crabe${y}taille]`).val())
    warning(index)
}

function change_sexe(index,y){
    form.lots[index].crabes[y].sexe = $(`[name=lot${index}crabe${y}sexe]:checked`).val()
    warning(index)
}

function warning(index){
    $(`#warning${index}`).html("")
    if(form.lots[index].crabes.length < 20 || form.lots[index].bacs.length < 1){
        $(`#warning${index}`).html(`<span class="badge badge-danger"><i class="fa fa-times"></i> aucune données de crabe(s) et/ou bac(s)</badge>`)
    }
    $.map(form.lots[index].bacs, function(x,y){
        if(x.poidsbac < 10 || x.poidsbac > 100 || x.poidsbac == "") $(`#warning${index}`).html(`<span class="badge badge-danger"><i class="fa fa-times"></i> poids de bac</badge>`)
    })

    $.map(form.lots[index].crabes, function(x,y){
        if(x.checked != "checked" && (x.taille==""||x.taille<110||x.taille>220)){
            $(`#warning${index}`).html(`<span class="badge badge-danger"><i class="fa fa-times"></i> données de crabes</badge>`)
        }
    })
}

function delete_crabe(index,y){
    form.lots[index].crabes.splice(y,1);
    afficher_crabes(index)
    warning(index)
}