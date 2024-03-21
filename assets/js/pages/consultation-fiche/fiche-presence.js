const nouveauFicheLien = `${BASE_URL}/saisie-de-fiche-presence/saisie-enquete/`
var dateAujourdhui = new Date();
var anneeAujourdui = dateAujourdhui.getFullYear();
var moisAujourdui = dateAujourdhui.getMonth()+1;
var moisDebut=1
var anneeDebut=2021
var moisNombre = (anneeAujourdui-anneeDebut)*12 + moisAujourdui 
var moisString = moisAujourdui.toString();
var moisCorrect=''
    if ( moisString.length < 2 )
    {
        moisCorrect = "0" + moisAujourdui;
    }
    else{
        moisCorrect= moisAujourdui
    }
    var dateString = dateAujourdhui.getDate().toString();
    var dateCorrect=''
        if ( dateString.length < 2 )
        {
            dateCorrect = "0" + dateString;
        }
        else{
            dateCorrect= dateString
        }

var dateFormat= anneeAujourdui+'-'+moisCorrect+'-'+dateCorrect

var opt='<option value="">Choix mois</option>'
$('#js-date').val(dateFormat)
for(var i=0; i<moisNombre;i++){
    var tempMois=moisDebut
    var tempAnnee=anneeDebut
    var nom_m = nom_mois(tempMois)
    opt += `<option value='${tempAnnee}-${tempMois}'>${nom_m} ${tempAnnee}</option>`
    if(moisDebut==12){
        moisDebut = 1
        anneeDebut = anneeDebut + 1
    }
    else{
        moisDebut = moisDebut + 1
    }
}
$('#mois1').html(opt)
$('#mois2').html(opt)
var aColumns = [
{ sTitle: "Aucune colonne dynamique"}];

var table = $('#example').DataTable();

table_dynamic(aColumns)

const form = {
    enquete:[],
    date:null,
    village:null,
    mois1:null,
    mois2:null
}
const formMod ={
    pecheur:null,
    enquetes:[
        {mois:null,
        annee:null,
        crabe:null}
    ]
}

form.date=dateFormat
const actualisationVillage = $('#actualisation-village')
const champInsertionVillage = $('#champ-insertion-village')
let pecheurs = []
const action = {
  
    corps: $('#js-formulaire'),

    zoneCorecrabe: $('[name=js-zone-corecrabe]'),

    village: $('[name=js-village]'),

    date:$('[name=js-date]'),

    enregistrer_modification: $('#modification-presence'),


  };

  action.zoneCorecrabe.on('change', e => {
    var zone = action.zoneCorecrabe.val();
    let optionTags = '<option value="" hidden selected></option>';
    while (action.village.children().length > 0) {
      action.village.children().eq(0).remove();
    }
    actualisationVillage.show()
    champInsertionVillage.hide()
    $.ajax({

      url: BASE_URL + '/edition-de-zone/village/selection-par-zone-corecrabe_suivi/' + zone ,

      method: 'post',

      data:{zone:zone},

      dataType: 'json',

      success: villages => {
       console.log(villages)
        for (var village of villages) {

          optionTags += `<option value="${village['id']}">${village['nom']}</option>`

        }

        action.village.html(optionTags)

      }

    }).always(() => {

      actualisationVillage.hide()
      champInsertionVillage.show()
      action.village.trigger('change')
    })
    pecheurs = [];
  })
  action.village.on('change', e => {
    var village = action.village.val();
    form.village=village
    pecheurs=[]
    

    var d=creerDonnee()
    pecheurs = ListePecheurFiche(village,d);
    
    form.enquete=[...pecheurs]
    var cl = creer_colonne_table(d)
    
    table=table_dynamic(cl)
    // // creer_donnees_form(pecheurs)
    creer_table(0);
  })
  function erreur(message){
    $.alert({
            title: "Erreur",
            content: message
        })
}
  action.date.on('change',function(){
    var date = action.date.val();
    form.date = null;
    if(date != ''){
      form.date = date;
    }
    
    
  });

  action.enregistrer_modification.on('click',function(){
    var enq = []
    enq=[...enq,formMod]
      var dataPost = {
        village:form.village,
        date:form.date,
        enquete:[...enq]
      }

      $.ajax({
        url: `${BASE_URL}/fiche-presence/insertion-enquete`,
        data: dataPost,
        type: 'post',
        dataType: 'json'
    }).done(function (response){
        if(response.result){
            var d=creerDonnee()
            pecheurs = ListePecheurFiche(form.village,d);
            form.enquete=[...pecheurs]
            creer_table(1);
            $("#modalEdit").modal('hide');
            $('html, body').animate({
                scrollTop: $("#table_pecheur_id").offset().top
            }, 1);

        }else{
            $.alert({
                title: response.title,
                content: response.message
            })
        }
    }).fail(function() {
        self.setContent('Une erreur a été rencontré, veuillez vérifier vos entrées ou contactez l\'administrateur')
        self.setTitle('Erreur!')
    })
      
  })

  
  function creer_table(bool){
    table.clear().draw();
    var count = 0;
    $.map(form.enquete,function(a,b){
        var row=[];
        var rows = [
        `${a.ligne}`,
        `<b>${a.nom}</b>`];
        
         for(var i=0;i<a.enquetes.length;i++){
            rows.push(form.enquete[count].enquetes[i].crabe)
         }
         rows.push(`<button id="btn-${count}" class="btn btn-xs btn-warning" onclick="edit_enquete(${count})" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i></button>`)
        
        table.row.add(rows)
        
        count++
    
    });
    if(bool != 0){
    table.columns.adjust().draw();
    }
  }


  function ListePecheurFiche(village,colonne){

    var pecheurss = [];
    $.ajax({

        method: 'post',

        data: {village:village,colonne:colonne},

        url: `${BASE_URL}/fiche-presence/existe_json`,

        dataType: 'json',

        async: false ,

      }).done(function(data){
        pecheurss= [...data]
        // for(var i=0;i<data.length;i++){
            
        //     pecheurss.push({id:data[i].id,sexe:data[i].sexe,nom:data[i].nom,selected:false});
        // }

      }).fail(function(f){})
      return pecheurss;
      

}

function ajout_seule_enquete(data){
         
           var data_non_valide=data.non_valide
           
           var dataPost={
            village:data.village,
            date:data.date,
            enquete:data.enquete
        }
        
        var pecheursTemp = [];
        countIndex =0;
        $.map(data_non_valide,function(a,b){
            pecheursTemp=[...pecheursTemp,{
                id:a.pecheur,
                nom:a.nom
            }]
            data_non_valide[countIndex].ligne = countIndex + 1
            countIndex++
        })
        
       
            $.ajax({
                url: `${BASE_URL}/fiche-presence/insertion-enquete`,
                data: dataPost,
                type: 'post',
                dataType: 'json'
            }).done(function (response){
                if(response.result){
                    // self.setContent(response.message)
                    // self.setTitle(response.title)
                    pecheurs = [...pecheursTemp]

                    // creer_donnees_form(pecheurs)
                    form.enquete=[...data_non_valide]
                    creer_table(1);
                    $('html, body').animate({
                        scrollTop: $("#table_pecheur_id").offset().top
                    }, 1);
                    verifier_tous()

                }else{
                    $.alert({
                        title: response.title,
                        content: response.message
                    })
                    // self.setContent(response.message)
                    // self.setTitle(response.title)
                }
            }).fail(function() {
                self.setContent('Une erreur a été rencontré, veuillez vérifier vos entrées ou contactez l\'administrateur')
                self.setTitle('Erreur!')
            })
            
            
}

function nom_mois(mois){
    switch (parseInt(mois)) {
        case 1:
            return 'Janv'
            break
        case 2:
            return 'Fev'
            break
        case 3:
            return 'Mars'
            break
        case 4:
            return 'Avril'
            break
        case 5:
            return 'Mai'
            break
        case 6:
            return 'Juin'
            break
        case 7:
            return 'Juil'
            break
        case 8:
            return 'Août'
            break
        case 9:
            return 'Sept'
            break
        case 10:
            return 'Oct'
            break
        case 11:
            return 'Nov'
            break
        case 12:
            return 'Dec'
            break
            
        default:
            return ''
            break
    }
}
function change_mois1(){
    var mois = $('#mois1').val()
    form.mois1 = null
    if(mois !=''){
        form.mois1 = mois
    }
    form.mois2 = null
    $('#mois2').val('')
    action.zoneCorecrabe.val('')
    form.village=null
    action.village.val('')
}
function change_mois2(){
    var mois = $('#mois2').val();
    form.mois2 = null
    if(mois !=''){
        form.mois2 = mois
    }
    action.zoneCorecrabe.val('')
    var d=creerDonnee()
     var cl = creer_colonne_table(d)
     
    
    
}
function creerDonnee()
{
    var mois1Splt = form.mois1.split("-")
    var moisDebut = parseInt(mois1Splt[1])
    var anneeDebut = parseInt(mois1Splt[0])
    var mois2Splt = form.mois2.split("-")
    var moisFin = parseInt(mois2Splt[1])
    var anneeFin = parseInt(mois2Splt[0])
    var moisNombre = (anneeFin-anneeDebut)*12 + (moisFin -moisDebut)+1
    var donnees=[]
if(form.mois1==form.mois2){
    donnees =[...donnees,{
        annee:anneeDebut,
        mois:moisDebut,
        crabe:null
    }]
}
else{
    for(var i=0; i<moisNombre;i++){
        var tempMois=moisDebut
        var tempAnnee=anneeDebut
        donnees =[...donnees,{
            annee:tempAnnee,
            mois:tempMois,
            crabe:null
        }]
       
        if(tempMois == 12){
            moisDebut = 1
            anneeDebut = anneeDebut + 1
        }
        else{
            moisDebut = moisDebut + 1
        }
        
       
    }
}


return donnees
    
}

function table_dynamic(colonne){
    
    table.destroy();
    $('#example').empty(); // empty in case the columns change
    table = $('#example').DataTable( {
            columns: colonne,
                language: {url: BASE_URL + '/assets/datatable-fr.json'},
    
    processing: true,

    paging: true,

    lengthChange: true,

    searching: true,

    ordering: true,

    info: true,

    autoWidth: true,

    scrollCollapse: true,

    scrollX:true,

            
    fixedColumns:   {
                left: 2
            },

    

    // responsive: true,
    ordering:false,
    lengthMenu: [
        [10, 20, 50, -1],
        [10, 20, 50, 'Tous'],
    ],
        } );
    return table
}
function creer_colonne_table(d){
    var colonne=[{sTitle: '#'},{sTitle: 'Pecheur'}]
   $.map(d,function(a,b){
    var dataAnnee = a.annee.toString()
    var annee = dataAnnee.substring(dataAnnee.length-2, dataAnnee.length)
    var mois=''
    var moisString = a.mois.toString()
    if ( moisString.length < 2 )
    {
        mois= "0" + moisString;
    }
    else{
        mois= moisString
    }
    colonne = [...colonne,{
         sTitle: mois+'/'+annee
    }]
   
   })
   colonne=[...colonne,{sTitle: 'Actions'}]
   return colonne
}
function edit_enquete(index){
    $('#index-pecheur').val(index)
    var opt = '<option value="" hidden selected></option>';
    count=0
    $('#nom-pecheur').val(form.enquete[index].nom)
    $.map(form.enquete[index].enquetes,function(a,b){
      var m = nom_mois(a.mois)
        opt += `<option value="${count}">${m} ${a.annee}</option>`
        count++
    })
    $('#mois-edit').html(opt)
    re_intiale_modification()
    formMod.pecheur=form.enquete[index].id
    $('#js-crabe').val('')
    

        
}
function re_intiale_modification(){
    formMod.pecheur=null
    formMod.enquetes[0].annee=null
    formMod.enquetes[0].mois=null
    formMod.enquetes[0].crabe=null
}

function change_mois_edit(){
    var indexPecheur= $('#index-pecheur').val()
    var indexMois = $('#mois-edit').val();
    formMod.enquetes[0].annee = form.enquete[indexPecheur].enquetes[indexMois].annee
    formMod.enquetes[0].mois = form.enquete[indexPecheur].enquetes[indexMois].mois
    formMod.enquetes[0].crabe = form.enquete[indexPecheur].enquetes[indexMois].crabe
    $('#js-crabe').val(formMod.enquetes[0].crabe )
    

}
function change_crabe_edit(){
    var crabe = $('#js-crabe').val()
    formMod.enquetes[0].crabe = null
    if(crabe != ''){
        formMod.enquetes[0].crabe = crabe
    }
    
}

function mois_correct(mois){
    var res =''
    var mois = mois.toString()
    if(mois.length<2){
        res = '0'+mois
    }
    else res = mois
    return res
}

