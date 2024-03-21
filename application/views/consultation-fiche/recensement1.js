

    const nouveauFicheLien = `${BASE_URL}/saisie-de-fiche-recensement/saisie-enquete/`

    const actualisationCommune = $('#actualisation-commune')
  
    const champInsertionCommune = $('#champ-insertion-commune')

    const actualisationFokontany = $('#actualisation-fokontany')
  
    const champInsertionFokontany = $('#champ-insertion-fokontany')

    const actualisationVillage = $('#actualisation-village')
  
    const champInsertionVillage = $('#champ-insertion-village')

    const actualisationEnqueteur = $('#actualisation-enqueteur')
  
    const champInsertionEnqueteur = $('#js-enqueteur')

    

    
  
  
  
    const form={
        zoneCorecrabe: null,

        commune: null,

        nouveau_commune:null,

        fokontany: null,

        nouveau_fokontany:null,

        village: null,

        nouveau_village: null,

        date : null,

        numero_fiche:null,

        enqueteur:null,

        enquete:[],
    }

    const action = {
        ajouter_fiche: $('#nouveau_fiche'),
        conteneur_fiche: $('#conteneur_fiche'),
        zoneCorecrabe:$('#js-zone-corecrabe'),
        commune:$('#champ-insertion-commune'),
        fokontany:$('#champ-insertion-fokontany'),
        village:$('#champ-insertion-village'),
        enqueteur:$('#js-enqueteur'),
        date:$('#js-date-enquete'),
        enregistrer: $('#enregistrer'),
        enregistrer_nouvelle: $('#enregistrer-nouvelle'),
      }
      action.enregistrer.on('click',function(){
        if(check_info_fiche().result){
            if(form.enquete.length>0){
                result = {"result": check_info_enquete().result, "message": check_info_enquete().message};
                if(result.result){
                    result1= {"result": doublant().result, "message": doublant().message};
                    if(result1.result){

                        $.alert({
                            content: function () {
                                var self = this;
                                return $.ajax({
                                    url: `${BASE_URL}/recensement/saisie-enquete/insertion`,
        
                                    data: form,
        
                                    type: 'post',
        
                                    dataType: 'json'
                                }).done(function (response){
                                    if(response.result){
                                        self.setContent(response.message)
                                        self.setTitle(response.title)
                                        setTimeout(() => location.href = `${BASE_URL}/consultation-de-recensement/detail-et-action/${response.fiche}.html`, 1000);
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
                        erreur(result1.message);
                    }
                }
                else{
                    erreur(result.message)
                }

            }
            else{
                erreur("Il faut renseigner au moins une enquête")
            }
        }
        else{
            erreur(check_info_fiche().message)
        }
      });
      function erreur(message){
        $.alert({
                title: "Erreur",
                content: message
            })
    }
      action.enregistrer_nouvelle.on('click',function(){
        if(check_info_fiche().result){
            if(form.enquete.length>0){
                result = {"result": check_info_enquete().result, "message": check_info_enquete().message};
                if(result.result){
                    result1= {"result": doublant().result, "message": doublant().message};
                    if(result1.result){

                        $.alert({
                            content: function () {
                                var self = this;
                                return $.ajax({
                                    url: `${BASE_URL}/recensement/saisie-enquete/insertion`,
        
                                    data: form,
        
                                    type: 'post',
        
                                    dataType: 'json'
                                }).done(function (response){
                                    if(response.result){
                                        self.setContent(response.message)
                                        self.setTitle(response.title)
                                        setTimeout(() => location.href = `${BASE_URL}/recensement-ajout.html`, 1000);
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

                        erreur(result1.message);

                    }
                    

                }
                else{
                    erreur(result.message)
                }

            }
            else{
                erreur("Il faut renseigner au moins une enquête")
            }
        }
        else{
            erreur(check_info_fiche().message)
        }
      });
      function erreur(message){
        $.alert({
                title: "Erreur",
                content: message
            })
    }
    
    $('.select-add').select2({
        tags:true,
        theme: 'bootstrap4',
        width: null,
        "language": {
            "noResults": function(){
                return "Aucun résultat";
            }
        },
    });

    

    action.zoneCorecrabe.on('change',function(){

    var zone = action.zoneCorecrabe.val() ;
    if(zone !=''){
        form.zoneCorecrabe = action.zoneCorecrabe.val();
    }
    else{
        form.zoneCorecrabe =null;
    }


    actualisationCommune.show();
  
      champInsertionCommune.hide();
  
      actualiserListeCommune(zone, 3).then(communes => {
  
        let chaineCommune = '<option value="" selected >--sélectionner une commune--</option>'
        let chainefokontany = '<option value="0" selected >--sélectionner une fokontany--</option>'
        let chainevillage = '<option value="0" selected >--sélectionner une village--</option>';
        action.fokontany.html(chainefokontany);
        action.village.html(chainevillage);
        
        for (let commune of communes) {
  
          chaineCommune += `<option value="${commune['id']}">${commune['nom']}</option>`
  
        }
  
        action.commune.html(chaineCommune)
  
      }).finally(() => {
  
        actualisationCommune.hide()
  
        champInsertionCommune.show()
  
      });

      form.commune=null;
        form.fokontany=null;
        form.village=null;

      verificationFiche();

      if(form.enquete.length>0){
          for(var i=0;i<form.enquete.length;i++){
            delete_enquete_default(i);
          }
      }
      action.conteneur_fiche.html('');
      
    });
    function delete_enquete_default(key){
        form.enquete.splice(key,1);
        
    }

    action.commune.on('change',function(){
        var commune = action.commune.val();
        var isInteger = parseInt(commune);
        form.fokontany=null;
        form.village=null;

    actualisationFokontany.show();
  
    champInsertionFokontany.hide();

        if(isInteger !=0){
            form.commune= action.commune.val();
            if(isInteger>0){
                
                
                
             

             form.nouveau_commune=0;

                actualiserListeFokontanyParCommune(commune, 3).then(fokontanys => {
  
                    let chainefokontany = '<option value="0" selected >--sélectionner une fokontany--</option>'
                    let chainevillage = '<option value="0" selected >--sélectionner une village--</option>';
                    action.village.html(chainevillage);
              
                    for (let fokontany of fokontanys) {
              
                      chainefokontany += `<option value="${fokontany['id']}">${fokontany['nom']}</option>`
              
                    }
              
                    action.fokontany.html(chainefokontany)
              
                  }).finally(() => {
              
                    actualisationFokontany.hide()
              
                    champInsertionFokontany.show()
              
                  })




            }
            else{
                form.nouveau_commune=1;
                actualisationFokontany.hide();
              
                champInsertionFokontany.show();

                let chainefokontany = '<option value="0" selected >--Saisir un fokontany--</option>';
                action.fokontany.html(chainefokontany)

            }
        }
        else{
            form.commune= null;
            
        }
        
        if(form.enquete.length>0){
            for(var i=0;i<form.enquete.length;i++){
              delete_enquete_default(i);
            }
        }

        action.conteneur_fiche.html('');
        verificationFiche();
        
        
        
         
    })

    action.fokontany.on('change',function(){
        var fokontany = action.fokontany.val();
        var isInteger = parseInt(fokontany);
        form.village=null;

        actualisationVillage.show();
  
    champInsertionVillage.hide();

        if(isInteger !=0){
            form.fokontany = action.fokontany.val();
            if(isInteger>0){
                form.nouveau_fokontany=0;
                actualiserListeVillageParFokontany(fokontany, 3).then(villages => {
  
                    let chainevillage = '<option value="0" selected >--sélectionner une village--</option>'
              
                    for (let village of villages) {
              
                      chainevillage += `<option value="${village['id']}">${village['nom']}</option>`
              
                    }
              
                    action.village.html(chainevillage)
              
                  }).finally(() => {
              
                    actualisationVillage.hide()
              
                    champInsertionVillage.show()
              
                  })








            }
            else{
                 
                form.nouveau_fokontany=1;

                actualisationVillage.hide();
              
                champInsertionVillage.show();

                let chainevillage = '<option value="0" selected >--Saisir une village--</option>';
                action.village.html(chainevillage)
            }
        }
        else{
            
            form.fokontany = null;
        }
        
        if(form.enquete.length>0){
            for(var i=0;i<form.enquete.length;i++){
              delete_enquete_default(i);
            }
        }
        action.conteneur_fiche.html('');
        verificationFiche();

    })

    action.village.on('change',function(){
        var village = action.village.val();
        form.enqueteur=null;
        if(village==0){
            form.village=null;
            form.nouveau_village=null;
        } 
        else{
            
            form.village=village;
            var isInteger = parseInt(village);
            let chaineEnqueteur='<option value="" hidden></option>';
            if(isInteger>0){
                form.nouveau_village=0;


                actualisationEnqueteur.show()
  
               champInsertionEnqueteur.hide()
  
      actualiserListeEnqueteurVillageSeulement(village, 3).then(enqueteurs => {
  
  
        for (let enqueteur of enqueteurs) {
  
          chaineEnqueteur += `<option value="${enqueteur['id']}">${enqueteur['code']}</option>`
  
        }
        action.enqueteur.html(chaineEnqueteur);
  
  
      }).finally(() => {
  
        actualisationEnqueteur.hide()
  
        champInsertionEnqueteur.show()
  
      })
      action.enqueteur.html(chaineEnqueteur);
            }
            else{
                form.nouveau_village=1;
                
            }
            
            
        }
        
        if(form.enquete.length>0){
            for(var i=0;i<form.enquete.length;i++){
              delete_enquete_default(i);
            }
        }
        action.conteneur_fiche.html('');
        verificationFiche();
       
    })

    action.enqueteur.on('change',function(){
        form.enqueteur=action.enqueteur.val(); 
        verificationFiche();
    })

    action.date.on('change',function(){
        var date = action.date.val();
        if(date !=''){
            form.date = date;
        }
        else{
            form.date = null;
        }
         
        verificationFiche()
    })

    function verificationFiche(){
        if(form.zoneCorecrabe !=null && form.commune !=null && form.fokontany !=null && form.village !=null && form.date !=null){
            
            action.ajouter_fiche.removeAttr('disabled') ;
        }
        else{
            action.ajouter_fiche.attr('disabled','disabled');
        }
    }

    action.ajouter_fiche.on('click',e=>{
        
        form.enquete= [...form.enquete,{
            pecheur:null,
            resident:1,
            village_origine:null,
            nouveau_village_origine:null,
            nouveau_pecheur:null,
            sexe:null,
            age:null,
            pirogue:null,
            toute_annee:0,
            periode_mare:null,
            type_mare:null,
            periode_mois:null,
            engins:{
                engin1:null,
                annee1:null,
                engin2:null,
                annee2:null
            },
            activite:{
                activite1:null,
                pourcentage1:null,
                activite2:null,
                pourcentage2:null,
                activite3:null,
                pourcentage3:null
            },
        }];
        checktype()
        
        afficherCardFiches();
       
       
    })

    function afficherCardFiches(){
        var engins = ListeEngins();
        
        var activites = ListeActivites();
        var annees = annee();
        
        var enquetesInverse = [];
        for(var i=form.enquete.length;i>0;i--){
            enquetesInverse = [...enquetesInverse,form.enquete[i-1]]
        }
        action.conteneur_fiche.html('');
        $.map(enquetesInverse, function(x,y){
            
            var collapsed = ""
            var minus = "minus"
            if(y>0){
                collapsed = "collapsed-card"
                minus = "plus"
            }
            recuperation_pecheurs=[];
            recuperation_village_origines=[];

            if(form.enquete[enquetesInverse.length-y-1].resident !=null){

                if(form.enquete[enquetesInverse.length-y-1].resident==1)
            {
                recuperation_village_origines = [];
                if(form.enquete[enquetesInverse.length-y-1].pecheur != null){
                    if(form.nouveau_village ==1){
                        recuperation_pecheurs.push({id:form.enquete[enquetesInverse.length-y-1].pecheur,nom:form.enquete[enquetesInverse.length-y-1].pecheur});
                    }
                    else{
                        var village_current = form.village;
                        var pecheurs = ListePecheur(village_current);
                        
                        if(parseInt(form.enquete[enquetesInverse.length-y-1].pecheur)>0){
                            
                            recuperation_pecheurs =[...pecheurs];

                            
                        }
                        else{
                            recuperation_pecheurs =[{id:form.enquete[enquetesInverse.length-y-1].pecheur,nom:form.enquete[enquetesInverse.length-y-1].pecheur,nom:form.enquete[enquetesInverse.length-y-1].pecheur,nom:form.enquete[enquetesInverse.length-y-1].pecheur},...pecheurs];
                        }
                    }
                }
                else{
                   if(form.nouveau_village==0){
                    var village_current = form.village;
                    var pecheurs = ListePecheur(village_current);
                    recuperation_pecheurs =[{idpecheur:'',nom:''},...pecheurs];
                   } 
                }
                
            }

            //else non resident

            else{

                if(form.enquete[enquetesInverse.length-y-1].village_origine != null){
                    if(parseInt(form.enquete[enquetesInverse.length-y-1].village_origine)>0){

                        var origines = ListeVillageParZone(form.zoneCorecrabe);
                        recuperation_village_origines=[...origines];
                        
                        var pecheurs_org= ListePecheur(form.enquete[enquetesInverse.length-y-1].village_origine);
                        
                       
                        if(parseInt(form.enquete[enquetesInverse.length-y-1].pecheur)>0){

                            
                            recuperation_pecheurs=[...pecheurs_org];
                            
                        }
                        else{
                            recuperation_pecheurs=[{idpecheur:form.enquete[enquetesInverse.length-y-1].pecheur,nom:form.enquete[enquetesInverse.length-y-1].pecheur},...pecheurs_org];
                        }

                    }
                    else{
                        recuperation_pecheurs=[{idpecheur:form.enquete[enquetesInverse.length-y-1].pecheur,nom:form.enquete[enquetesInverse.length-y-1].pecheur}];
                        if(form.nouveau_commune==1){
                            recuperation_village_origines.push({id:form.enquete[enquetesInverse.length-y-1].village_origine,nom:form.enquete[enquetesInverse.length-y-1].village_origine});
                                
                            
                        }
                        else{
                            var origines = ListeVillageParZone(form.zoneCorecrabe);
                            recuperation_village_origines=[{id:form.enquete[enquetesInverse.length-y-1].village_origine,nom:form.enquete[enquetesInverse.length-y-1].village_origine},...origines]
                        }
                    }
                }

            }

            }
            

            action.conteneur_fiche.append(`<div class="card ${collapsed}">
            <div class="card-header" >
                <h3 class="card-title"><span id="warning${enquetesInverse.length-y-1}"></span> Enquête N° ${enquetesInverse.length-y}</h3>
                <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-${minus}"></i></button>
                        <button type="button" onclick="delete_enquete(${enquetesInverse.length-y-1})" class="btn btn-default btn-sm" id="fermer${enquetesInverse.length-y-1}">
                            <i class="fas fa-window-close"></i>
                        </button>
                 </div>
            </div>
            <div class="card-body">
                <div class="row">
                 


                <div class="col-md-12 mb-2" >
                    <label>Résident:       </label>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-secondary `+(form.enquete[enquetesInverse.length-y-1].resident == '0' ? `active`:``)+`">
                            
                                <input type="radio" value="0"  name="js-resident${enquetesInverse.length-y-1}" onclick="change_resident(${enquetesInverse.length-y-1})" > Non
    
                                </label>
                                <label class="btn btn-outline-secondary `+(form.enquete[enquetesInverse.length-y-1].resident == '1' ?`active`:``)+`">
                            
                                <input type="radio" value="1"  name="js-resident${enquetesInverse.length-y-1}"  onclick="change_resident(${enquetesInverse.length-y-1})" > Oui
    
                                </label>
    
                    </div>

                </div>

                <div class="col-md-3" `+(form.enquete[enquetesInverse.length-y-1].resident==1?`style='display:none'`:`style='display:block'`)+` id="div-village-origine${enquetesInverse.length-y-1}" >
                    <div class="form-group" >
                        <label>Village d'origine</label>
                        <select name="js-village-origine${enquetesInverse.length-y-1}" id="js-village-origine${enquetesInverse.length-y-1}" class="custom-select select-add" onchange="change_village_orgine(${enquetesInverse.length-y-1})">

                                    `+$.map(recuperation_village_origines,function(a,b){
                                        if(a.id==form.enquete[enquetesInverse.length-y-1].village_origine){
                                            return `<option value="${a.id}" selected>${a.nom}</option>`
                                        }
                                        else{
                                            return `<option value="${a.id}" >${a.nom}</option>`
                                        }
                                    } )+`

                        </select>
                       <input type='number' hidden name='nouveau-village-origine${enquetesInverse.length-y-1}"' id="nouveau-village-origine${enquetesInverse.length-y-1}">
                    </div>
                </div>

                <div class="col-md-3" >
                    <div class="form-group">
                        <label>Pecheur(s)</label>
                        <select name="js-pecheur${enquetesInverse.length-y-1}" id="js-pecheur${enquetesInverse.length-y-1}" class="custom-select append-select" onchange="change_pecheur(${enquetesInverse.length-y-1})" >
                                `+$.map(recuperation_pecheurs,function(a,b){
                                    
                                    if(a.idpecheur==form.enquete[enquetesInverse.length-y-1].pecheur){
                                        return `<option value="${a.idpecheur}" selected>${a.nom}</option>`
                                    }
                                    else{
                                        return `<option value="${a.idpecheur}" >${a.nom}</option>`
                                    }
                                } )+`
                        </select>
                        <input type='number' hidden name='nouveau-pecheur${enquetesInverse.length-y-1}"' id="nouveau-pecheur${enquetesInverse.length-y-1}">
                    </div>
                </div>

                <div class="col-md-3">
                
                  <label>Sexe</label>
                  <div >

                    <input   type="radio" value="H" id="homme${enquetesInverse.length-y-1}"  name="js-sexe${enquetesInverse.length-y-1}" `+(form.enquete[enquetesInverse.length-y-1].sexe=='H'?`checked`:``)+` onclick="change_sexe(${enquetesInverse.length-y-1})"  >
                    <label class="form-check-label" for="homme${enquetesInverse.length-y-1}">Homme </label>
                    <input  class="ml-1" type="radio" value="F" id="femme${enquetesInverse.length-y-1}"  name="js-sexe${enquetesInverse.length-y-1}" onclick="change_sexe(${enquetesInverse.length-y-1})" `+(form.enquete[enquetesInverse.length-y-1].sexe=='F'?`checked`:``)+`  > 
                    <label class="form-check-label" for="femme${enquetesInverse.length-y-1}" >Femme</label>
                  
                  </div>

                </div>

                <div class="col-md-3">
                    <div class="form-group" >
                    <label >Age</label>
                    <input type="number" id="js-age${enquetesInverse.length-y-1}" name="js-age${enquetesInverse.length-y-1}" class="custom-select" onkeyup="change_age(${enquetesInverse.length-y-1})" value="${form.enquete[enquetesInverse.length-y-1].age}"/>
                    </div>
                </div>


                <div class="col-md-3" >
                <div><label>Pirogue</label></div>

                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            
                            <label class="btn btn-outline-secondary `+(form.enquete[enquetesInverse.length-y-1].pirogue == '0'?`active`:``)+`">
                        
                            <input type="radio" value="0"  name="js-pirogue${enquetesInverse.length-y-1}" onclick="change_pirogue(${enquetesInverse.length-y-1})" > Non

                            </label>
                            <label class="btn btn-outline-secondary `+(form.enquete[enquetesInverse.length-y-1].pirogue == '1'?`active`:``)+`">
                        
                            <input type="radio" value="1"  name="js-pirogue${enquetesInverse.length-y-1}" onclick="change_pirogue(${enquetesInverse.length-y-1})" > Oui

                            </label>
                            <label class="btn btn-outline-secondary  `+(form.enquete[enquetesInverse.length-y-1].pirogue == '2'?`active`:``)+`">
                        
                            <input type="radio" value="2"  name="js-pirogue${enquetesInverse.length-y-1}" onclick="change_pirogue(${enquetesInverse.length-y-1})" > Parfois

                            </label>
                                <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
    
                                </div>

                </div>

                <div class="col-md-3" `+(form.enquete[enquetesInverse.length-y-1].resident==0?`style='display:none'`:`style='display:block'`)+` id="div-crabe-toute-annee${enquetesInverse.length-y-1}" >

                    <div><label>Crabe toute l'année</label></div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    
                    <label class="btn btn-outline-secondary `+(form.enquete[enquetesInverse.length-y-1].toute_annee == '0'?`active`:``)+`">
                            
                    <input type="radio" value="0"  name="js-toute-annee${enquetesInverse.length-y-1}" onclick="change_toute_annee(${enquetesInverse.length-y-1})" > Non

                    </label>  
                    
                    <label class="btn btn-outline-secondary `+(form.enquete[enquetesInverse.length-y-1].toute_annee == '1'?`active`:``)+`">
                            
                    <input type="radio" value="1"  name="js-toute-annee${enquetesInverse.length-y-1}" onclick="change_toute_annee(${enquetesInverse.length-y-1})" > Oui

                    </label> 
                    
                    <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

                    </div>
                
                </div>

                <div class="col-md-3" id="div-periode${enquetesInverse.length-y-1}" `+(form.enquete[enquetesInverse.length-y-1].toute_annee==1?`style='display:none'`:`style='display:block'`)+` >
                  <div class="form-group" >
                  <label>Période</label> 
                  <div >
                  `+
                                (form.enquete[enquetesInverse.length-y-1].periode_mare == 'mare' ? `
                    <input  type="radio" value="mare" id="js-mare${enquetesInverse.length-y-1}" name="js-mare${enquetesInverse.length-y-1}" onclick="change_periode(${enquetesInverse.length-y-1})" checked>
                    <label class="form-check-label" for="flexCheckDefault">
                        Marée
                    </label>`:`
                    <input  type="radio" value="mare" id="js-mare${enquetesInverse.length-y-1}" name="js-mare${enquetesInverse.length-y-1}" onclick="change_periode(${enquetesInverse.length-y-1})">
                    <label class="form-check-label" for="flexCheckDefault">
                        Marée
                    </label>`)+ (form.enquete[enquetesInverse.length-y-1].periode_mare == 'mois' ? `
                    <input class="ml-2" type="radio" value="mois" id="js-mare1${enquetesInverse.length-y-1}" name="js-mare${enquetesInverse.length-y-1}" onclick="change_periode(${enquetesInverse.length-y-1})" checked>
                    <label class="form-check-label" for="flexCheckDefault">
                        Mois
                    </label>`:`
                    <input class="ml-2" type="radio" value="mois" id="js-mare1${enquetesInverse.length-y-1}" name="js-mare${enquetesInverse.length-y-1}" onclick="change_periode(${enquetesInverse.length-y-1})">
                    <label class="form-check-label" for="flexCheckDefault">
                        Mois
                    </label>`)+`
                    </div>
                  </div>
                </div>
                <div class="col-md-3" id='div-periode-mois${enquetesInverse.length-y-1}' `+ (form.enquete[enquetesInverse.length-y-1].periode_mare == null || form.enquete[enquetesInverse.length-y-1].periode_mare == 'mare'  ? ` style="display:none"`:`style="display:block"`)+` id="div-periode-mois${enquetesInverse.length-y-1}"  >
                  <div class="form-group " >
                  <label>Mois</label>
                  <select onchange="change_valeur_periode_mois(${enquetesInverse.length-y-1})" multiple="multiple" class="custom-select append-select " id="js-periode-mois${enquetesInverse.length-y-1}" name="js-periode-mois${enquetesInverse.length-y-1}">
                  `+(form.enquete[enquetesInverse.length-y-1].periode_mois == null?
                    `<option value='' hidden></option>
                    <option value="1">Janvier</option>
                    <option value="2">Février</option>
                    <option value="3">Mars</option>
                    <option value="4">Avril</option>
                    <option value="5">Mai</option>
                    <option value="6">Juin</option>
                    <option value="7">Juillet</option>
                    <option value="8">Aout</option>
                    <option value="9">Septembre</option>
                    <option value="10">Octobre</option>
                    <option value="11">Novembre</option>
                    <option value="12">Décembre</option>`
                    :`<option value='' hidden></option>
                    <option value="1" `+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==1){
                            return `selected`
                        }
                    })+`>Janvier</option>
                    <option value="2"`+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==2){
                            return `selected`
                        }
                    })+` >Février</option>
                    <option value="3"`+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==3){
                            return `selected`
                        }
                    })+` >Mars</option>
                    <option value="4" `+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==4){
                            return `selected`
                        }
                    })+`>Avril</option>
                    <option value="5" `+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==5){
                            return `selected`
                        }
                    })+`>Mai</option>
                    <option value="6" `+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==6){
                            return `selected`
                        }
                    })+`>Juin</option>
                    <option value="7" `+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==7){
                            return `selected`
                        }
                    })+`>Juillet</option>
                    <option value="8" `+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==8){
                            return `selected`
                        }
                    })+`>Aout</option>
                    <option value="9" `+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==9){
                            return `selected`
                        }
                    })+`>Septembre</option>
                    <option value="10" `+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==10){
                            return `selected`
                        }
                    })+`>Octobre</option>
                    <option value="11" `+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==11){
                            return `selected`
                        }
                    })+`>Novembre</option>
                    <option value="12" `+$.map(form.enquete[enquetesInverse.length-y-1].periode_mois,function(a,b){
                        if(a==12){
                            return `selected`
                        }
                    })+`>Décembre</option>`
                    
                    )+`
                  </select>
                  </div>
                </div>

                <div class="col-md-3" id='div-periode-mare${enquetesInverse.length-y-1}' `+ (form.enquete[enquetesInverse.length-y-1].periode_mare == null || form.enquete[enquetesInverse.length-y-1].periode_mare == 'mois'  ? ` style="display:none"`:`style="display:block`)+` id="div-periode-mare${enquetesInverse.length-y-1}" style="display:none" >
                  <div class="form-group"  >
                  <label>Marée</label>
                  <select onchange="change_valeur_periode_mare(${enquetesInverse.length-y-1})"  class="custom-select append-select " id="js-periode-mare${enquetesInverse.length-y-1}" name="js-periode-mare${enquetesInverse.length-y-1}">
                  `+(form.enquete[enquetesInverse.length-y-1].type_mare == null?
                    `<option value='' hidden></option>
                    <option value="Vives eaux" >Vives eaux</option><option value="Mortes eaux" >Mortes eaux</option>`:`
                    <option value='' hidden></option>
                    <option value="Vives eaux"`+(form.enquete[enquetesInverse.length-y-1].type_mare=='Vives eaux'?`selected`:``) +` >Vives eaux</option>
                    <option value="Mortes eaux" `+(form.enquete[enquetesInverse.length-y-1].type_mare=='Mortes eaux'?`selected`:``) +` >Mortes eaux</option>`)+`
                  </select>
                  </div>
                </div>
    
    
                <!-- </div>


            <div class="row mt-4">
              -->
                
                <div class="col-md-3" >
                   <div class="form-group">
                        <label>Engin1</label>
                        <select class="custom-select" name="js-engin1${enquetesInverse.length-y-1}" id="js-engin1${enquetesInverse.length-y-1}" onchange="change_engin1(${enquetesInverse.length-y-1})" >
                            <option value=''></option> 

                            `+
                            $.map(engins,function(a,b){
                                if(form.enquete[enquetesInverse.length-y-1].engins.engin1==a.id){
                                return `<option value="${a.id}" selected>${a.nom}</option>`
                                }
                                else{
                                    return `<option value="${a.id}">${a.nom}</option>`
                                }
                            })
                            +`

                        </select>
                     </div>
                </div> 
                   
                <div class="col-md-3">
                    <div class="form-goup">
                        <label>Année1</label>

                        <select class="custom-select" id="js-annee1${enquetesInverse.length-y-1}" name="js-annee1${enquetesInverse.length-y-1}" onchange="change_annee1(${enquetesInverse.length-y-1})">
                            <option value=''></option>

                            `+
                            $.map(annees,function(a,b){
                                if(form.enquete[enquetesInverse.length-y-1].engins.annee1==a){
                                    return `<option value="${a}" selected>${a}</option>`
                                }
                                else{
                                    return `<option value="${a}">${a}</option>`
                                }
                                
                            })
                            +`
                        
                        </select>
                    </div>
                   
                </div>

                <div class="col-md-3">
                    <div class="form-group"> 
                        <label>Engin2</label>

                        <select class="custom-select" id="js-engin2${enquetesInverse.length-y-1}" name="js-engin2${enquetesInverse.length-y-1}" onchange="change_engin2(${enquetesInverse.length-y-1})">
                        <option value=''></option>
                        `+
                        $.map(engins,function(a,b){
                            if(form.enquete[enquetesInverse.length-y-1].engins.engin2==a.id){
                                return `<option value="${a.id}" selected>${a.nom}</option>`
                            }
                            else{
                                return `<option value="${a.id}">${a.nom}</option>`
                            }
                            
                        })
                        +`
                        </select>
                     </div>
                   
                </div>

                <div class="col-md-3">
                   
                    <div class="form-group">
                        <label>Année2</label>
                        <select class="custom-select" id="js-annee2${enquetesInverse.length-y-1}" name="js-annee2${enquetesInverse.length-y-1}" onchange="change_annee2(${enquetesInverse.length-y-1})">
                            <option value=''></option>
                            `+
                            $.map(annees,function(a,b){
                                if(form.enquete[enquetesInverse.length-y-1].engins.annee2==a){
                                    return `<option value="${a}" selected>${a}</option>`
                                }
                                else{
                                    return `<option value="${a}">${a}</option>`
                                }
                                
                            })
                            +`
                         </select>
                    </div>
                   
                </div>

               <div class="col-md-3">

                    <div class="form-group">
                        <label>Activité1</label>
                        <select id="js-activite1${enquetesInverse.length-y-1}" name="js-activite1${enquetesInverse.length-y-1}" class="custom-select" onchange="change_activite1(${enquetesInverse.length-y-1})">
                            <option value='' hidden  ></option>
                            `+
                            $.map(activites,function(a,b){
                                if(form.enquete[enquetesInverse.length-y-1].activite.activite1==a.id){
                                return `<option value="${a.id}" selected>${a.nom}</option>`
                                }
                                else{
                                    return `<option value="${a.id}">${a.nom}</option>` 
                                }
                            })
                            +`
                            </select>
                    </div>
               
               </div>

               <div class="col-md-3" >
                    <div class="form-group">
                        <label>Pourcentage</label>
                        <input type="number" id="js-activite1-pourcent${enquetesInverse.length-y-1}" name="js-activite1-pourcent${enquetesInverse.length-y-1}" class="form-control" onkeyup="change_pourcentage1(${enquetesInverse.length-y-1})" value="${form.enquete[enquetesInverse.length-y-1].activite.pourcentage1}" step="any"/>
                    </div>
               </div>

               <div class="col-md-3">
                    <div class="form-group">
                            <label>Activité2</label>
                            <select class="custom-select" id="js-activite2${enquetesInverse.length-y-1}" name="js-activite2${enquetesInverse.length-y-1}" onchange="change_activite2(${enquetesInverse.length-y-1})">
                                <option value='' hidden></option>
                                `+ 
                                $.map(activites,function(a,b){
                                    if(form.enquete[enquetesInverse.length-y-1].activite.activite2==a.id){
                                        return `<option value="${a.id}" selected>${a.nom}</option>`
                                        }
                                        else{
                                            return `<option value="${a.id}">${a.nom}</option>` 
                                        }
                                })
                                +`
                            </select>

                    </div>
                    
               </div>

               <div class="col-md-3">
                    <div class="form-group">
                        <label>Pourcentage</label>
                        <input type="number" name="js-activite2-pourcent${enquetesInverse.length-y-1}" id="js-activite2-pourcent${enquetesInverse.length-y-1}" class="form-control" onkeyup="change_pourcentage2(${enquetesInverse.length-y-1})" value="${form.enquete[enquetesInverse.length-y-1].activite.pourcentage2}" step="any"/>
                    </div>
               </div>

               <div class="col-md-3 ">
                    <div class="form-group">
                            <label>Activité3</label>
                            <select class="custom-select" id="js-activite3${enquetesInverse.length-y-1}" name="js-activite3${enquetesInverse.length-y-1}" onchange="change_activite3(${enquetesInverse.length-y-1})">
                                <option value='' hidden></option>
                                `+ 
                                $.map(activites,function(a,b){
                                    if(form.enquete[enquetesInverse.length-y-1].activite.activite3==a.id){
                                        return `<option value="${a.id}" selected>${a.nom}</option>`
                                        }
                                        else{
                                            return `<option value="${a.id}">${a.nom}</option>` 
                                        }
                                })
                                +`
                            </select>

                    </div>
                    
               </div>

               <div class="col-md-3">
                    <div class="form-group">
                        <label>Pourcentage</label>
                        <input type="number" name="js-activite3-pourcent${enquetesInverse.length-y-1}" id="js-activite3-pourcent${enquetesInverse.length-y-1}" class="form-control" onkeyup="change_pourcentage3(${enquetesInverse.length-y-1})" value="${form.enquete[enquetesInverse.length-y-1].activite.pourcentage3}" step="any" />
                    </div>
               </div>

            </div>

            </div>
        </div>`);
        warning(enquetesInverse.length-y-1)
        $('.append-select').select2({
            tags:true,
            theme: 'bootstrap4',
            width: null,
            "language": {
                "noResults": function(){
                    return "Aucun résultat";
                }
            },
        });
        })

        

    }


   function delete_enquete(key){
    form.enquete.splice(key,1);
    checktype()
    afficherCardFiches()
    warning(index)
   }

   function check_info_enquete(){
    result = true;
    message ="Informations complètes";
    for(index=0;index<form.enquete.length;index++){

        if( form.enquete[index].resident ==null || form.enquete[index].pecheur ==null||form.enquete[index].sexe ==null ||form.enquete[index].age ==null||form.enquete[index].age ==''|| form.enquete[index].pirogue ==null || form.enquete[index].activite.activite1==null || form.enquete[index].engins.engin1 ==null || form.enquete[index].engins.annee1 ==null||form.enquete[index].activite.pourcentage1==null||(form.enquete[index].resident ==0 && form.enquete[index].village_origine ==null)||(form.enquete[index].resident ==1 && form.enquete[index].toute_annee ==null)||(form.enquete[index].resident ==0 && form.enquete[index].periode_mare ==null) ||(parseInt(form.enquete[index].activite.activite2)>0 && (form.enquete[index].activite.pourcentage2==null||form.enquete[index].activite.pourcentage2=='') )||(parseInt(form.enquete[index].activite.activite3)>0 && (form.enquete[index].activite.pourcentage3==null||form.enquete[index].activite.pourcentage3 =='') )||(parseFloat(form.enquete[index].activite.pourcentage3)>0 && (form.enquete[index].activite.activite3==null||form.enquete[index].activite.activite3=='') )||(parseInt(form.enquete[index].engins.engin2)>0 && (form.enquete[index].engins.annee2==null||form.enquete[index].activite.annee2 =='') )||(parseInt(form.enquete[index].engins.annee2)>0 && (form.enquete[index].engins.engin2==null||form.enquete[index].engins.engin2 =='') )){
            result = false;
            message = "Veuillez vérifier vos entrées! il faut renseigner les champs obligatoires...";
        }

    }
    return {"result":result, "message": message}
   }

   function checktype(){
    if(form.enquete.length>0){
        if(form.enquete.length >=5){
            action.ajouter_fiche.attr('disabled','disabled');
        }
        else{
            action.ajouter_fiche.removeAttr('disabled')
        }
    }
   }
function change_sexe(key){
    
    form.enquete[key].sexe = $(`[name=js-sexe${key}]:checked`).val();
    warning(key);

    
    
    
}

function change_resident(key){
    
    form.enquete[key].resident = $(`[name=js-resident${key}]:checked`).val();
    
    if(form.enquete[key].resident>0){
        $(`#div-village-origine${key}`).hide();
        $(`#div-crabe-toute-annee${key}`).show();
        form.enquete[key].village_origine=null;
        let chainePecheur = '<option value="" selected hidden></option>';
        if(parseInt(form.village)>0){
            var pecheurs_liste = ListePecheur(form.village);
            
            $.map(pecheurs_liste,function(a,b){
                chainePecheur += `<option value="${a.idpecheur}">${a.nom}</option>`
            })
            
            
        }
        else{
            
        }
        let chainevillage = '<option value=""  >--saisir village---</option>';
        $(`#js-village-origine${key}`).html(chainevillage);
        $(`#js-pecheur${key}`).html(chainePecheur);
    }
    else if(form.enquete[key].resident==0)
    {
        $(`#div-village-origine${key}`).show();
        let chainevillage = '<option value=""  ></option>';
        let chainePecheur = '<option value="" selected hidden></option>';
        $(`#div-crabe-toute-annee${key}`).hide();
        if(parseInt(form.commune)>0){
            var origines=ListeVillageParZone(form.zoneCorecrabe);
            $.map(origines,function(village,b){
                if(form.nouveau_village==0){
                    if(village.id != form.village){
                        chainevillage += `<option value="${village.id}">${village.nom}</option>`
                    }
                   
                }
                else{
                    chainevillage += `<option value="${village.id}">${village.nom}</option>`
                }
                
            })
            
        }
        $(`#js-pecheur${key}`).html(chainePecheur);
        $(`#js-village-origine${key}`).html(chainevillage);
        $(`#js-village-origine${key}`).select2({
            tags:true,
            theme: 'bootstrap4',
            width: null,
            "language": {
                "noResults": function(){
                    return "Aucun résultat";
                }
            },
        }); 

    }

    warning(key);
    
    
}

function change_village_orgine(key){

    var origine = $(`#js-village-origine${key}`).val();
    if(origine !=''){
        form.enquete[key].village_origine=origine;
        let chainePecheur = '<option value="" selected hidden></option>';
        if(parseInt(origine)>0){
            form.enquete[key].nouveau_village_origine=0;
            var pecheurs = ListePecheur(origine);
            $.map(pecheurs,function(pecheur,b){
                chainePecheur += `<option value="${pecheur.idpecheur}">${pecheur.nom}</option>`
            })
        
        }
        else{
            form.enquete[key].nouveau_village_origine=1;
        }
        $(`#js-pecheur${key}`).html(chainePecheur);
    }
    else{

    }

    warning(key);

}

function change_pecheur(key){
    form.enquete[key].pecheur=$(`[name=js-pecheur${key}]`).val();
    var val_pecheur = $(`[name=js-pecheur${key}]`).val();
    const  date_aujourdhui = new Date();
    if(val_pecheur !=''){
        if(parseInt(val_pecheur)>0){
            form.enquete[key].nouveau_pecheur=0;
            detail_pecheur(val_pecheur).then(pecheur => {
             
                $(`[name=js-sexe${key}]`).prop('checked',false).trigger('change');
                if(pecheur['sexe']!=null){
                    form.enquete[key].sexe=pecheur['sexe'];
                }
                else{
                    form.enquete[key].sexe=null; 
                }
                $(`[name=js-sexe${key}]`).filter('[value='+ pecheur['sexe'] +']').prop('checked', true);

                if(parseInt(pecheur['datenais'])!=null){
                    form.enquete[key].age=date_aujourdhui.getFullYear()- parseInt(pecheur['datenais']);
                    $(`[name=js-age${key}]`).val( date_aujourdhui.getFullYear()- parseInt(pecheur['datenais']));
                }
                else{
                    $(`[name=js-age${key}]`).val(null);
                    form.enquete[key].age=null;
                }
               
                
           
               }).finally(() => {
           
                 
           
               })
        }
        else{
            form.enquete[key].nouveau_pecheur=1;
            form.enquete[key].sexe=null;
            form.enquete[key].age=null;
            $(`[name=js-sexe${key}]`).prop('checked',false).trigger('change');
            $(`[name=js-age${key}]`).val(null);


        }
    }

    warning(key);
    
}

function change_age(key){
    form.enquete[key].age= $(`[name=js-age${key}]`).val();
    warning(key);
}

function change_toute_annee(key){
    
    form.enquete[key].toute_annee = $(`[name=js-toute-annee${key}]:checked`).val();
    var toute_annee= $(`[name=js-toute-annee${key}]:checked`).val();
    if(toute_annee==1){
        $(`#div-periode${key}`).hide();
        $(`#div-periode-mois${key}`).hide();
        $(`#div-periode-mare${key}`).hide();
        form.enquete[key].periode_mare=null;
        form.enquete[key].type_mare=null;
        form.enquete[key].periode_mois=null;
        

    }
    else{
        $(`#div-periode${key}`).show();
    }

    warning(key);
    
    
}

function change_pirogue(key){
    
    form.enquete[key].pirogue = $(`[name=js-pirogue${key}]:checked`).val();
    warning(key);
    
    
}

function change_engin1(key){
    
    form.enquete[key].engins.engin1 = $(`[name=js-engin1${key}]`).val();
    var x = $(`[name=js-engin1${key}]`).val();
    $(`[name=js-js-engin2${key}] option`).prop('disabled',false).trigger('change');
    $(`[name=js-engin2${key}]  option[value="${x}"]`).attr('disabled',true);
    warning(key);
    
    
}
function change_engin2(key){
    
    form.enquete[key].engins.engin2 = $(`[name=js-engin2${key}]`).val();
    warning(key);
  
}
function change_annee1(key){
    
    form.enquete[key].engins.annee1 = $(`[name=js-annee1${key}]`).val();
    warning(key);
  
}

function change_annee2(key){
    
    form.enquete[key].engins.annee2 = $(`[name=js-annee2${key}]`).val();
    warning(key);
  
}
function change_activite1(key){
    
    form.enquete[key].activite.activite1 = $(`[name=js-activite1${key}]`).val();
    
    var x = $(`[name=js-activite1${key}]`).val();
      $(`[name=js-activite2${key}] option`).prop('disabled',false).trigger('change');
      $(`[name=js-activite3${key}] option`).prop('disabled',false).trigger('change');
      $(`[name=js-activite2${key}]  option[value="${x}"]`).attr('disabled',true);
      $(`[name=js-activite3${key}]  option[value="${x}"]`).attr('disabled',true);
      warning(key);
      console.log(form)
     
  
}

function change_activite2(key){
    
    form.enquete[key].activite.activite2 = $(`[name=js-activite2${key}]`).val();
    var x = $(`[name=js-activite1${key}]`).val();
    var x2 = $(`[name=js-activite2${key}]`).val();
    $(`[name=js-activite3${key}] option`).prop('disabled',false).trigger('change');
    $(`[name=js-activite3${key}]  option[value="${x}"]`).attr('disabled',true);
    $(`[name=js-activite3${key}]  option[value="${x2}"]`).attr('disabled',true);
    warning(key);
  
}

function change_activite3(key){
    
    form.enquete[key].activite.activite3 = $(`[name=js-activite3${key}]`).val();
    warning(key);
  
}

function change_pourcentage1(key){
    form.enquete[key].activite.pourcentage1 = $(`[name=js-activite1-pourcent${key}]`).val();
    warning(key);   
}
function change_pourcentage2(key){
    form.enquete[key].activite.pourcentage2 = $(`[name=js-activite2-pourcent${key}]`).val();
    warning(key);   
}
function change_pourcentage3(key){
    var p3= $(`[name=js-activite3-pourcent${key}]`).val();
    if(p3 !=''){
        form.enquete[key].activite.pourcentage3 = $(`[name=js-activite3-pourcent${key}]`).val();
    }
    else{
        form.enquete[key].activite.pourcentage3 = null;
    }
     
    warning(key);  
}

function change_periode(key){
    var mare = $(`[name=js-mare${key}]:checked`).val();
    form.enquete[key].periode_mare=mare;
    var chainePeriodeMois='<option value="" hidden></option>';
    var chainePeriodeMare='<option value="" hidden></option>';
    if(mare=='mois')
    {
        chainePeriodeMois +='<option value="1">Janvier</option><option value="2">Février</option><option value="3">Mars</option><option value="4">Avril</option><option value="5">Mai</option><option value="6">Juin</option><option value="7">Juillet</option><option value="8">Aout</option><option value="9">Septembre</option><option value="10">Octobre</option><option value="11">Novembre</option><option value="12">Décembre</option>';
        $(`#js-periode-mois${key}`).html(chainePeriodeMois);
        $(`#js-periode-mare${key}`).html(chainePeriodeMare);
        $(`#div-periode-mois${key}`).show();
        $(`#div-periode-mare${key}`).hide();
        form.enquete[key].type_mare=null;
    }
    if(mare=='mare'){
        chainePeriodeMare +='<option value="Vives eaux" >Vives eaux</option><option value="Mortes eaux" >Mortes eaux</option>'
        $(`#js-periode-mare${key}`).html(chainePeriodeMare);
        $(`#js-periode-mois${key}`).html(chainePeriodeMois);
        $(`#div-periode-mois${key}`).hide();
        $(`#div-periode-mare${key}`).show();
        form.enquete[key].periode_mois=null;
    }
    warning(key);
   
}

function change_valeur_periode_mare(key){
    var valeur = $(`#js-periode-mare${key}`).val();
    form.enquete[key].type_mare=valeur;
    warning(key);
    
 }

function change_valeur_periode_mois(key){
   var valeur = $(`#js-periode-mois${key}`).val();
   form.enquete[key].periode_mois=valeur;
   warning(key);
   
}

function check_info_fiche()
{
    if( form.commune !=null && form.fokontany !=null && form.village !=null && form.date !=null){
          
        return {'result':true, 'message':'Informations complètes'}
        
    }
    else return {'result':false, 'message':'Il faut renseigner la fiche!'}

}


function warning(index){
    $(`#warning${index}`).html("");
    if( form.enquete[index].resident ==null || form.enquete[index].pecheur ==null||form.enquete[index].sexe ==null ||form.enquete[index].age ==null||form.enquete[index].age ==''|| form.enquete[index].pirogue ==null || form.enquete[index].activite.activite1==null || form.enquete[index].engins.engin1 ==null || form.enquete[index].engins.annee1 ==null||form.enquete[index].activite.pourcentage1==null||(form.enquete[index].resident ==0 && form.enquete[index].village_origine ==null)||(form.enquete[index].resident ==1 && form.enquete[index].toute_annee ==null)||(form.enquete[index].resident ==0 && form.enquete[index].periode_mare ==null) ||(parseInt(form.enquete[index].activite.activite2)>0 && (form.enquete[index].activite.pourcentage2==null||form.enquete[index].activite.pourcentage2=='') )||(parseInt(form.enquete[index].activite.activite3)>0 && (form.enquete[index].activite.pourcentage3==null||form.enquete[index].activite.pourcentage3 =='') )||(parseFloat(form.enquete[index].activite.pourcentage3)>0 && (form.enquete[index].activite.activite3==null||form.enquete[index].activite.activite3=='') )||(parseInt(form.enquete[index].engins.engin2)>0 && (form.enquete[index].engins.annee2==null||form.enquete[index].activite.annee2 =='') )||(parseInt(form.enquete[index].engins.annee2)>0 && (form.enquete[index].engins.engin2==null||form.enquete[index].engins.engin2 =='') )){
        $(`#warning${index}`).html(`<span class="badge badge-danger"><i class="fa fa-times"></i> veuillez saisir ou corriger toutes les informations</badge>`)
    }
    invalideChamp(index);
    
    
}

function invalideChamp(index){
    if(form.enquete[index].resident ==0){
        if(form.enquete[index].village_origine==null){
            $(`[name=js-village-origine${index}]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-village-origine${index}]`).removeClass('is-invalid');
        }
    }
    if(form.enquete[index].pecheur ==null){
        $(`[name=js-pecheur${index}]`).addClass('is-invalid');
    }
    else{
        $(`[name=js-pecheur${index}]`).removeClass('is-invalid');
    }
    if(form.enquete[index].age ==null){
        $(`[name=js-age${index}]`).addClass('is-invalid');
    }
    else{
        $(`[name=js-age${index}]`).removeClass('is-invalid');
    }
    if(form.enquete[index].engins.engin1 ==null){
        $(`[name=js-engin1${index}]`).addClass('is-invalid');
    }
    else{
        $(`[name=js-engin1${index}]`).removeClass('is-invalid');
    }
    if(form.enquete[index].engins.annee1 ==null){
        $(`[name=js-annee1${index}]`).addClass('is-invalid');
    }
    else{
        $(`[name=js-annee1${index}]`).removeClass('is-invalid');
    }
    if(( form.enquete[index].engins.engin2 !=null && form.enquete[index].engins.annee2 ==null)){
        $(`[name=js-annee2${index}]`).addClass('is-invalid');
    }else{
        $(`[name=js-annee2${index}]`).removeClass('is-invalid');
    }

    if(( form.enquete[index].engins.engin2 ==null && form.enquete[index].engins.annee2 !=null)){
        $(`[name=js-engin2${index}]`).addClass('is-invalid');
    }else{
        $(`[name=js-engin2${index}]`).removeClass('is-invalid');
    }
    
    if(form.enquete[index].activite.activite1 ==null){
        $(`[name=js-activite1${index}]`).addClass('is-invalid');
    }
    else{
        $(`[name=js-activite1${index}]`).removeClass('is-invalid');
    }
    if(form.enquete[index].activite.pourcentage1 ==null){
        $(`[name=js-activite1-pourcent${index}]`).addClass('is-invalid');
    }
    else{
        $(`[name=js-activite1-pourcent${index}]`).removeClass('is-invalid');
    }
    if(  parseInt(form.enquete[index].activite.activite2)>0 && form.enquete[index].activite.pourcentage2 ==null){
        $(`[name=js-activite2-pourcent${index}]`).addClass('is-invalid');
    }else{
        $(`[name=js-activite2-pourcent${index}]`).removeClass('is-invalid');
    }
    if(( form.enquete[index].activite.activite2 ==null && form.enquete[index].activite.pourcentage2 !=null)){
        $(`[name=js-activite2${index}]`).addClass('is-invalid');
    }else{
        $(`[name=js-activite2${index}]`).removeClass('is-invalid');
    }
    if(( parseInt(form.enquete[index].activite.activite3)>0  && form.enquete[index].activite.pourcentage3 ==null)){
        $(`[name=js-activite3-pourcent${index}]`).addClass('is-invalid');
    }else{
        $(`[name=js-activite3-pourcent${index}]`).removeClass('is-invalid');
    }
    if(( form.enquete[index].activite.activite3 ==null && form.enquete[index].activite.pourcentage3 !=null)){
        $(`[name=js-activite3${index}]`).addClass('is-invalid');
    }else{
        $(`[name=js-activite3${index}]`).removeClass('is-invalid');
    }
}




function annee(){
    var annees =[];
    var aujourdui = new Date();
    var year = aujourdui.getFullYear();
    var count = 70;
    annees.push(year);
    for(var i=count;i>0;i--){
        year = year -1;
        annees.push(year);
    }

    return annees;

}


function ListeActivites(){
    
    let test = [] ;
    $.ajax({

        method: 'post',

        data: {},

        url: `${BASE_URL}/activite/liste_tous`,

        dataType: 'json',

        async: false 

      }).done(function(data){

        for(let act of data){
            test.push({id:act.id,nom:act.nom})
        }

      }).fail(function(f){

      });
    return test; 

}
function ListeEngins(){
    
    let engins = [];
    $.ajax({

        method: 'post',

        data: {},

        url: `${BASE_URL}/engin/liste-engin`,

        dataType: 'json',

        async: false ,

      }).done(function(data){

        for(let engin of data){
            if(engin.nom !=''){
                engins.push({id:engin.id,nom:engin.nom})
            }
            
        }

      }).fail(function(f){})

      return engins; 

}

function ListePecheur(village){


    var pecheurss = [];
    
    $.ajax({

        method: 'post',

        data: {village:village},

        url: `${BASE_URL}/pecheur/liste-pecheur-village-origine`,

        dataType: 'json',

        async: false ,

      }).done(function(data){
        
        
        for(var i=0;i<data.length;i++){
            
            pecheurss.push({idpecheur:data[i].id,nom:data[i].nom});
        }

      }).fail(function(f){})

      return pecheurss;

}

function ListeVillage(commune){


    let villages = [];
    $.ajax({

        method: 'post',

        data: {commune:commune},

        url: `${BASE_URL}/village/liste-par-commune`,

        dataType: 'json',

        async: false ,

      }).done(function(data){

        for(let village of data){
            
                villages.push({id:village.id,nom:village.nom})
            
            
        }

      }).fail(function(f){})

      return villages;

}

function ListeVillageParZone(zone){


    let villages = [];
    $.ajax({

        method: 'get',

        url: BASE_URL+ '/edition-de-zone/village/selection-par-zone-corecrabe01/' + zone + '/?type=Pêcheur',

        dataType: 'json',

        async: false ,

      }).done(function(data){

        for(let village of data){
            
                villages.push({id:village.id,nom:village.nom})
              
        }

      }).fail(function(f){})

      return villages;

}

function doublant(){
    var result = true;
    var message='Information correcte';
    
    if(form.enquete.length>0){

        var pecheur = form.enquete[0].pecheur;
        var arret =form.enquete.length-1;

        for(var i=0;i<form.enquete.length;i++){
          for(var j=0;j<form.enquete.length;j++){
              if(j!=i){
                  if(form.enquete[j].pecheur==pecheur){
                    var result = false;
                    var message='Il y a des pecheurs doublant';
                  }
              }
          }
          if(i!=arret){
            pecheur = form.enquete[i+1].pecheur;
          }
          else{
            pecheur = form.enquete[arret].pecheur;  
          }
          
        }
       
    }

    return {'result':result, 'message':message};
}




    



  
  