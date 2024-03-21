const nouveauFicheLien = `${BASE_URL}/saisie-de-fiche-presence/saisie-enquete/`

// var a = "2022";
// console.log(a.substring(a.length-2, a.length));
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
{ sTitle: "Aucun mois choisi"}];

var table = $('#example').DataTable();

table_dynamic(aColumns)

const form = {
    enquete:[],
    date:null,
    village:null,
    mois1:null,
    mois2:null,
    ingoreValidation:null
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

    enregistrer_nouvelle: $('#enregistrer-nouvelle'),


  };

  action.zoneCorecrabe.on('change', e => {
    // form.zoneCorecrabe=null;
    var zone = action.zoneCorecrabe.val();
    // if(zone !=''){
    //   form.zoneCorecrabe =zone;
    // }
    let optionTags = '<option value="" hidden selected></option>';
    // Vider la liste déroulante pour faire place à la nouvelle list
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
    // form.fokontany=null;
    // form.village=null;


  })
  action.village.on('change', e => {
    var village = action.village.val();
    form.village=village
    pecheurs=[]
    var d=creerDonnee()
    pecheurs = ListePecheurFiche(village,d);
    var cl = creer_colonne_table(d)
    creer_donnees_form(pecheurs)
    var donnee_prime = dataTable()
    table = donnee_table(cl,donnee_prime)
    // table=table_dynamic(cl)
    // creer_donnees_form(pecheurs)
    // creer_table(0);
    // var donneesMois= creerDonnee()
    // console.log(donneesMois)
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
  action.enregistrer_nouvelle.on('click',function(){
    if(form.village != null && form.date != null){
        var donnees = verification_donnees().donnees;
        var dataPost={
            village:donnees.village,
            date:donnees.date,
            enquete:donnees.enquete
        }
        if(donnees.non_valide.length>0){
            if(donnees.enquete.length>0){
                $('#ckeckignoreSpan').show();
                var info = '';
                for(var i=0;i<donnees.non_valide.length;i++){
                info +=donnees.non_valide[i].ligne
                if(i<donnees.non_valide.length-1){
                info +=','
                }
                }
                var infohtml = 'Veuillez verifier ou ignorer le(s) ligne(s) '+info;
                $('#info-validation').html(infohtml)
                if(form.ingoreValidation != null){
                    $.alert({
                        content: function () {
                            var self = this;
                            return $.ajax({
                                url: `${BASE_URL}/fiche-presence/insertion-enquete`,
                                data: dataPost,
                                type: 'post',
                                dataType: 'json'
                            }).done(function (response){
                                if(response.result){
                                    self.setContent(response.message)
                                    self.setTitle(response.title)
                                    $("#checkIgnore").prop('checked', false);
                                    form.ingoreValidation=null

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
                    
                }
                else{
                erreur('veuillez ignorer ou verifier les enquêtes manquant si vous souhaite d\'enregistrer ...')
                }
            }
            else{
                erreur('Aucun enquête valide')
            }

            
            
        }
        else{
            $('#ckeckignoreSpan').hide();
            $.alert({
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: `${BASE_URL}/fiche-presence/insertion-enquete`,
                        data: dataPost,
                        type: 'post',
                        dataType: 'json'
                    }).done(function (response){
                        if(response.result){
                            self.setContent(response.message)
                            self.setTitle(response.title)
                            setTimeout(() => location.href = `${BASE_URL}/fiche-presence/saisie_enquete`, 1000);
                            
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
        }
        
    }
    else{
        erreur('Verifier le champ village et date d\'enquête...')
        
    }
  })

  function valide_one_enquete(index){
    var valide=true;
    for(var i = 0;i<form.enquete[index].enquetes.length;i++){
        if(form.enquete[index].enquetes[i].crabe==null){
            valide = false
        }
    }
    return valide
  }
  function change_ignore(){
    var ignore = $('#checkIgnore').is(':checked');
    if(ignore){
        form.ingoreValidation=1
    }
    else{
        form.ingoreValidation=null
    }
    

  }
  

  function verification_donnees(){
    var result = true;
    var donnees = {
      village:form.village,
      date:form.date,
      enquete:[],
      non_valide:[]
    };

    for(index=0;index<form.enquete.length;index++){

        var enquetes = form.enquete[index].enquetes;
        var valide = true;
        for (var i = 0;i < enquetes.length;i++) {
            if(enquetes[i].crabe==null){
                valide=false
            }   
        }
        if(valide){
            donnees.enquete=[...donnees.enquete,form.enquete[index]]
        }
        else{
            donnees.non_valide=[...donnees.non_valide,form.enquete[index]]
        }


    }
    return {'result':result,'donnees':donnees};

  }
  

  function creer_donnees_form(pecheurs){
    form.enquete=[]
    var ligne=0;
    var d = creerDonnee()
    $.map(pecheurs,function(a,b){
        // var  colonneEnquete =[];
        // $.map(d,function(x,y){
        //    colonneEnquete=[...colonneEnquete,{
        //      mois:x.mois,
        //     annee:x.annee,
        //     crabe:null
        // }]
        // })
        form.enquete=[...form.enquete,{
          pecheur:a.id,
          nom:a.nom,
          valide:0,
          ligne:ligne + 1,
	  enquetes:a.enquetes
          // enquetes:colonneEnquete
        }]
        ligne++
    }
        );
        
  }
  function creer_table(bool){
    table.clear().draw();
    var count = 0;
    $.map(form.enquete,function(a,b){
        var row=[];
        var rows = [`<input type="checkbox" name="valide${count}" id="valide${count}" `+(a.valide=='1'?'checked':'')+` onclick="change_valide(${count})">`,
        `${a.ligne}`,
        `<b>${a.nom}</b>`];
         for(var i=0;i<a.enquetes.length;i++){
            rows.push(`<div class="btn-group btn-group-toggle " data-toggle="buttons" >
                         <label id="js-crabe-non-${count}-${i}" class="btn btn-xs btn-outline-secondary   `+(form.enquete[count].enquetes[i].crabe =='0'?'active':'')+`  ">
                             <input type="radio" value="0" name="js-crabe" onclick="change_crabe(${count},${i},0)"       > 0
                         </label>
                         <label id="js-crabe-oui-${count}-${i}" class="btn btn-xs btn-outline-secondary `+(form.enquete[count].enquetes[i].crabe =='1'?'active':'')+`   ">
                             <input type="radio" value="1"   name="js-crabe" onclick="change_crabe(${count},${i},1)"   > 1
                        </label>
                   </div>`)
         }
         rows.push(`<Button  id="enregistrer${count}" class="btn  btn-default  btn-xs   disabled" onclick="enregistrement(${count})"><i class="fa fa-check-circle "></i></Button>`)

        
        table.row.add(rows)
        
        count++
    
    });
    if(bool != 0){
    table.columns.adjust().draw();
    }
  }
  function change_crabe(index,mois,valeur){
    
    form.enquete[index].enquetes[mois].crabe=valeur
    
    if(valeur==1){
        $(`#js-crabe-oui-${index}-${mois}`).removeClass('btn-outline-secondary')
        $(`#js-crabe-oui-${index}-${mois}`).addClass('btn-secondary disabled')
        $(`#js-crabe-non-${index}-${mois}`).addClass('btn-outline-secondary disabled')
    }
    else{
        $(`#js-crabe-non-${index}-${mois}`).removeClass('btn-outline-secondary')
        $(`#js-crabe-non-${index}-${mois}`).addClass('btn-secondary disabled')
        $(`#js-crabe-oui-${index}-${mois}`).addClass('btn-outline-secondary disabled')
    }
    var valide=valide_one_enquete(index)
    console.log(form)
    if(valide){
        $(`#enregistrer${index}`).removeClass('disabled')
        $(`#enregistrer${index}`).removeClass('btn-default')
        $(`#enregistrer${index}`).addClass('btn-success')
    }
    else{
        $(`#enregistrer${index}`).addClass('disabled')
        $(`#enregistrer${index}`).removeClass('btn-success')
        $(`#enregistrer${index}`).addClass('btn-default')
    }
    
//    if(valide){
//     var donnees = verification_donnees().donnees;
//     ajout_seule_enquete(donnees)
//    }
    
    
  }
  function change_valide(index){
    var valide = $(`#valide${index}`).is(':checked');
    if(valide){
        form.enquete[index].valide =1
    } 
    else{
        form.enquete[index].valide =0 
    }
    active_boutton(index,valide)
    
  }
  function active_boutton(index,valide){
    if(valide=='1'){
        for(var i=0;i<form.enquete[index].enquetes.length;i++){
            if(form.enquete[index].enquetes[i].crabe != null){
             if(form.enquete[index].enquetes[i].crabe == '0'){
                 
                 $(`#js-crabe-non-${index}-${i}`).removeClass('btn-secondary')
                 $(`#js-crabe-non-${index}-${i}`).removeClass('disabled')
                 $(`#js-crabe-oui-${index}-${i}`).removeClass('disabled')
                 $(`#js-crabe-oui-${index}-${i}`).addClass('btn-outline-secondary')
                 $(`#js-crabe-non-${index}-${i}`).addClass('btn-outline-secondary active')
                 
             }
             else{
                 $(`#js-crabe-oui-${index}-${i}`).removeClass('btn-secondary ')
                 $(`#js-crabe-oui-${index}-${i}`).removeClass('disabled ')
                 $(`#js-crabe-non-${index}-${i}`).removeClass('disabled')
                 $(`#js-crabe-oui-${index}-${i}`).addClass('btn-outline-secondary active')
                 $(`#js-crabe-non-${index}-${i}`).addClass('btn-outline-secondary')
                
             }
             
     
            }
     
         }
    }
    else{
        for(var i=0;i<form.enquete[index].enquetes.length;i++){
            if(form.enquete[index].enquetes[i].crabe != null){
             if(form.enquete[index].enquetes[i].crabe == '0'){

                $(`#js-crabe-non-${index}-${i}`).removeClass('btn-outline-secondary active ')
                $(`#js-crabe-non-${index}-${i}`).addClass('btn-secondary disabled')
                $(`#js-crabe-oui-${index}-${i}`).removeClass('btn-secondary active')
                $(`#js-crabe-oui-${index}-${i}`).addClass('btn-outline-secondary disabled')   
             }
             else{
                $(`#js-crabe-oui-${index}-${i}`).removeClass('btn-outline-secondary active ')
                $(`#js-crabe-oui-${index}-${i}`).addClass('btn-secondary disabled')
                $(`#js-crabe-non-${index}-${i}`).removeClass('btn-secondary active')
                $(`#js-crabe-non-${index}-${i}`).addClass('btn-outline-secondary disabled')
             }
             
            }
     
         }
    }
    
  }

  function ListePecheurFiche(village,colonne){

    var pecheurss = [];
    $.ajax({

        method: 'post',

        data: {village:village,colonne:colonne},

        url: `${BASE_URL}/fiche-presence/pecheur-existe-presence`,

        dataType: 'json',

        async: false ,

      }).done(function(data){
         
        for(var i=0;i<data.length;i++){
            
            //pecheurss.push({id:data[i].id,sexe:data[i].sexe,nom:data[i].nom,selected:false});
	     pecheurss.push({id:data[i].id,sexe:data[i].sexe,nom:data[i].nom,enquetes:data[i].enquetes,selected:false});
        }

      }).fail(function(f){})
      return pecheurss;
      

}

function ajout_seule_enquete(index){
         
           var enq =[]
           enq = [...enq,form.enquete[index]]
           var dataPost={
            village:form.village,
            date:form.date,
            enquete:enq
        }
        
        form.enquete.splice(index,1);
        countIndex =0;
        $.map(form.enquete,function(a,b){
            form.enquete[countIndex].ligne = countIndex + 1
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
                    // pecheurs = [...pecheursTemp]

                    // creer_donnees_form(pecheurs)
                    // var d=creerDonnee()
                    // var cl = creer_colonne_table(d)
                    // var donnee_prime = dataTable()
                    // table = donnee_table(cl,donnee_prime)
		    table.row(index).remove().draw(false);
                    var info = table.page.info();
                    creer_table(1);
		    table.page(info.page).draw('page'); 
                    $('html, body').animate({
                        scrollTop: $("#table_pecheur_id").offset().top
                    }, 1);
                    // nouveau_table()
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
                erreur('Une erreur a été rencontré, veuillez vérifier vos entrées ou contactez l\'administrateur')
            })
            verifier_tous()
            
            
}
function verifier_tous(){
    for(var i= 0;i<form.enquete.length;i++){
        active_boutton(i,form.enquete[i].valide)
        var valide =valide_one_enquete(i);
        if(valide){
            $(`#enregistrer${i}`).removeClass('disabled')
            $(`#enregistrer${i}`).removeClass('btn-default')
            $(`#enregistrer${i}`).addClass('btn-success')
        }
        else{
            
            $(`#enregistrer${i}`).addClass('disabled')
            $(`#enregistrer${i}`).removeClass('btn-success')
            $(`#enregistrer${i}`).addClass('btn-default')
            
        }

    }

}

function nom_mois(mois){
    switch (mois) {
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
    var mtemp = form.mois1
    form.mois1 = null
    if(mois !=''){
        form.mois1 = mois
        if(mtemp != null){
            donnee_table(aColumns,null)
            $('#mois2').val('');
            action.zoneCorecrabe.val('')
            action.village.val('')
            form.mois2 = null
        }

    }
}
function change_mois2(){
    var mois = $('#mois2').val();
    var mtemp = form.mois2
    form.mois2 = null
    if(mois !=''){
        form.mois2 = mois
        if(mtemp != null){
            var nb = nombre_du_mois(mtemp,mois)
                add_colonne(nb)

        }
        
    }
    // var d=creerDonnee()
    //  var cl = creer_colonne_table(d)
     
    
    
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
                left: 3
            },

            // responsive: true,

            ordering:false,

            lengthMenu: [
                [7, 10, 25, -1],
                [7, 10, 25, 'Tous'],
            ],
            "initComplete": function(settings, json) {
                table.columns.adjust().draw();
            }
        } );
    return table
}
function creer_colonne_table(d){
    var colonne=[{sTitle: ''},{sTitle: '#'},{sTitle: 'Pecheur'}]
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
   colonne=[...colonne,{
    sTitle:'Actions'
   }]
   return colonne
}
function enregistrement(index){
    var valide=valide_one_enquete(index)

   if(valide){
    // var donnees = verification_donnees().donnees;
    ajout_seule_enquete(index)

   }
}

function dataTable(){
    var res = []
    var count = 0
    
    if(form.enquete.length>0){
        $.map(form.enquete,function(a,b){
            var valide = valide_one_enquete(count)
            
            var row=[];
            var rows = [`<input type="checkbox" name="valide${count}" id="valide${count}" `+(a.valide=='1'?'checked':'')+` onclick="change_valide(${count})">`,
            `${a.ligne}`,
            `<b>${a.nom}</b>`];
            for(var i=0;i<a.enquetes.length;i++){
                
                
                rows.push(`<div class="btn-group btn-group-toggle " data-toggle="buttons" >
                            <label id="js-crabe-non-${count}-${i}" class="btn btn-xs    `+(form.enquete[count].enquetes[i].crabe =='0'?'btn-secondary':'btn-outline-secondary')+` `+((form.enquete[count].enquetes[i].crabe !=null?'disabled':''))+`  ">
                                <input type="radio" value="0" name="js-crabe" onclick="change_crabe(${count},${i},0)"       > 0
                            </label>
                            <label id="js-crabe-oui-${count}-${i}" class="btn btn-xs  `+(form.enquete[count].enquetes[i].crabe =='1'?'btn-secondary':'btn-outline-secondary')+` `+((form.enquete[count].enquetes[i].crabe !=null?'disabled':''))+`  ">
                                <input type="radio" value="1"   name="js-crabe" onclick="change_crabe(${count},${i},1)"   > 1
                            </label>
                    </div>`)
            }
            rows.push(`<Button  id="enregistrer${count}" class="btn   btn-xs `+(valide ? 'btn-success':'btn-default  disabled')+`" onclick="enregistrement(${count})"><i class="fa fa-check-circle "></i></Button>`)
            res.push(rows)
            count++
        })
    }
    
    return res
}

function donnee_table(colonne,data){
        table.destroy();
        $('#example').empty();
        table = $('#example').DataTable({

            language: {url: BASE_URL + '/assets/datatable-fr.json'},

            columns: colonne,

            data:data,
            
            processing: true,

            paging: true,

            lengthChange: true,

            searching: true,

            ordering: false,

            info: true,

            autoWidth: true,

            scrollCollapse: true,

            scrollX:true,

            
            fixedColumns:   {
                left: 3
            },
            // responsive: true,

            ordering:false,

            lengthMenu: [
                [7, 10, 25, -1],
                [7, 10, 25, 'Tous'],
            ],
            
            
        })
        return table
}

function nouveau_table(){
    var d=creerDonnee()
    var cl = creer_colonne_table(d)
    var donnee_prime = dataTable()
    table = donnee_table(cl,donnee_prime)
    // creer_table(1);
    $('html, body').animate({
        scrollTop: $("#table_pecheur_id").offset().top
        // scrollTop: $("#d-scroll").offset().top
    }, 0);
}
function nombre_du_mois(mois1,mois2){
    var mois1Splt = mois1.split("-")
    var moisDebut = parseInt(mois1Splt[1])
    var anneeDebut = parseInt(mois1Splt[0])
    var mois2Splt = mois2.split("-")
    var moisFin = parseInt(mois2Splt[1])
    var anneeFin = parseInt(mois2Splt[0])
    var moisNombre = (anneeFin-anneeDebut)*12 + (moisFin -moisDebut)
    return moisNombre
}
function add_colonne(nb){
    if(form.enquete.length>0){
    var dernier = form.enquete[0].enquetes.length -1
     if(nb>0){
             var dernier = form.enquete[0].enquetes.length -1
             var annee =parseInt(form.enquete[0].enquetes[dernier].annee)
             var mois = parseInt(form.enquete[0].enquetes[dernier].mois)
             var count =0
             var donneeMois = []
             var moisDebut = null
             var anneeDebut = null
             if(mois == 12){
                 moisDebut = 1
                 anneeDebut = annee + 1
             }
             else{
                 moisDebut = mois + 1
                 anneeDebut=annee
             }
             for(var i=0;i<nb;i++){
                 var tempMois=moisDebut
                 var tempAnnee=anneeDebut
                 donneeMois =[...donneeMois,{
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
 
         $.map(form.enquete,function(a,b){
            var donneeMoisTemp = []
            // $.map(donneeMois,function(a,b){
            //     donneeMoisTemp =[...donneeMoisTemp,{annee:a.annee,mois:a.mois,crabe:null}]
            // })
            pecheurTemp = ListePecheurFiche(form.village,donneeMois);
            $.map(pecheurTemp,function(x,y){
                if(x.id==form.enquete[count].pecheur){
                    form.enquete[count].enquetes = [...form.enquete[count].enquetes,...x.enquetes]
                }
            })
             count++
         })
         
         
     }
     else {
        var depart = 0;
           $.map(form.enquete,function(a,b){
            var dernierTemp = dernier
            var index = dernierTemp
            var iteration = nb * (-1)
            var departIter = 0
            while(departIter<iteration){
                form.enquete[depart].enquetes.splice(index,1)
                index--
                departIter++
            }
            depart++
            
        })


     }
     nouveau_table()
     
    }
 }

