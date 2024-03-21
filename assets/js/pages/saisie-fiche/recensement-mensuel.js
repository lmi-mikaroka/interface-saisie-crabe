
   
    $('.custom-select').select2({
      theme:'bootstrap4',
      width: null,
      "language": {
                "noResults": function(){
                    return "Aucun résultat";
                }
            },
    });
    var table = $('#example').DataTable({
      language: {url: BASE_URL + '/assets/datatable-fr.json'},
      
      processing: true,
  
      paging: true,
  
      lengthChange: true,
  
      searching: true,
  
      ordering: true,
  
      info: true,
  
      autoWidth: true,
  
      responsive: true,
      columnDefs: [
          {  
              orderable: false,
              targets: [1, 2, 3,4,5,6,7,8,9],
          },
      ],
      
  });

    const nouveauFicheLien = `${BASE_URL}/saisie-de-fiche-recensement-mensuel/saisie-enquete/`
  
  
    const actualisationFokontany = $('#actualisation-fokontany')
  
    const champInsertionFokontany = $('#champ-insertion-fokontany')

    const actualisationVillage = $('#actualisation-village')
  
    const champInsertionVillage = $('#champ-insertion-village')
  
    const actualisationEnqueteur = $('#actualisation-enqueteur')
  
    const champInsertionEnqueteur = $('#champ-insertion-enqueteur')

    let pecheurs = []

    let activite_pecheurs =ListeActivites();
  
   const form={
     zoneCorecrabe:null,
     fokontany:null,
     village:null,
     annee:null,
     mois:null,
     date:null,
     enqueteur:null,
     enquete:[]
  };
  
    const action = {
  
      corps: $('#js-formulaire'),
  
      zoneCorecrabe: $('[name=js-zone-corecrabe]'),

      fokontany: $('[name=js-fokontany]'),
  
      village: $('[name=js-village]'),

      mois: $('[name=js-annee-mois]'),
  
      date:$('[name=js-date]'),
  
      enqueteur: $('[name=js-enqueteur]'),
  
      enregistrer: $('#enregistrer'),

      enregistrer_nouvelle: $('#enregistrer-nouvelle'),

      ajout_fiche: $('#nouveau_fiche'),

      conteneur_fiche: $('#conteneur_fiche'),
  
    };
    action.enregistrer_nouvelle.attr('disabled','disabled');
        
    action.enregistrer.attr('disabled','disabled');

  
   action.enregistrer.on('click',function(){

    var donnees = verification_button().donnees;
      if(donnees.enquete.length>0){

        $.alert({
          content: function () {
              var self = this;
              return $.ajax({
                  url: `${BASE_URL}/recensement-mensuel/insertion-enquete`,

                  data: donnees,

                  type: 'post',

                  dataType: 'json'
              }).done(function (response){
                  if(response.result){
                      self.setContent(response.message)
                      self.setTitle(response.title)
                      setTimeout(() => location.href = `${BASE_URL}/consultation-de-recensement-mensuel/detail-et-action/${response.fiche}.html`, 1000);
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
        erreur('Il faut saisir au moins une enquete');
      }

   })
    action.enregistrer_nouvelle.on('click',function(){

      var donnees = verification_button().donnees;
      if(donnees.enquete.length>0){

        $.alert({
          content: function () {
              var self = this;
              return $.ajax({
                  url: `${BASE_URL}/recensement-mensuel/insertion-enquete`,

                  data: donnees,

                  type: 'post',

                  dataType: 'json'
              }).done(function (response){
                  if(response.result){
                      self.setContent(response.message)
                      self.setTitle(response.title)
                      verificationFiche()
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
        erreur('Il faut saisir au moins une enquete');
      }
      
    })

    
  
  
   
    // Ecoute de changement de zone corecrabe
  
    action.zoneCorecrabe.on('change', e => {
      form.zoneCorecrabe=null;
      
      var zone = action.zoneCorecrabe.val();
      if(zone !=''){
        form.zoneCorecrabe =zone;
      }
      

      let optionTags = '<option value="" hidden selected></option>';
  
      // Vider la liste déroulante pour faire place à la nouvelle liste
  
      while (action.fokontany.children().length > 0) {
  
        action.fokontany.children().eq(0).remove();
  
      }
  
      actualisationFokontany.show()
  
      champInsertionFokontany.hide()
  
      $.ajax({
  
        url: BASE_URL + '/fokontany/liste-par-zone',
  
        method: 'post',

        data:{zone:zone},
  
        dataType: 'json',
  
        success: fokontanys => {
         
          for (var fokontany of fokontanys) {
  
            optionTags += `<option value="${fokontany['id']}">${fokontany['nom']}</option>`
  
          }
  
          action.fokontany.html(optionTags)
  
        }
  
      }).always(() => {
  
        actualisationFokontany.hide()
  
        champInsertionFokontany.show()
  
        action.fokontany.trigger('change')
  
      })
      pecheurs = [];
      form.fokontany=null;
      form.village=null;
      verificationFiche();
  
    })


    action.fokontany.on('change',function(){
      var fokontany = action.fokontany.val();
      form.village=null
      form.fokontany=null
      if(fokontany !=''){
        form.fokontany=fokontany;
      }
      
      actualiserListeVillageParFokontany(fokontany, 3).then(villages => {
  
        let chainevillage = '<option value="" hidden ></option>'
  
        for (let village of villages) {
  
          chainevillage += `<option value="${village['id']}">${village['nom']}</option>`
  
        }
  
        action.village.html(chainevillage)
  
      }).finally(() => {
  
        actualisationVillage.hide()
  
        champInsertionVillage.show()
  
      })
      pecheurs = [];
      verificationFiche()
    });
  
  
  
    action.village.on('change', e => {
  
      actualisationEnqueteur.show()
  
      champInsertionEnqueteur.hide()
       var village = action.village.val();
       form.village=null;
       if(village !=''){
         form.village = village;
       }
       
       

      actualiserListeEnqueteurVillageSeulement(action.village.val(), 3).then(enqueteurs => {
  
        let chaineEnqueteur = '<option value="" selected hidden></option>'
  
        for (let enqueteur of enqueteurs) {
  
          chaineEnqueteur += `<option value="${enqueteur['id']}">${enqueteur['code']}</option>`
  
        }
  
        action.enqueteur.html(chaineEnqueteur)
  
      }).finally(() => {
  
        actualisationEnqueteur.hide()
  
        champInsertionEnqueteur.show()
  
      })
      verificationFiche()

      
      
  
    })

    action.mois.on('change',function(){
      var mois = new Date(action.mois.val());
      form.mois = null;
      form.annee=null;
      if(mois != null){
        form.annee = mois.getFullYear();
        form.mois = mois.getMonth() +1;
      }
      verificationFiche()
      
    })

    action.date.on('change',function(){
      var date = action.date.val();
      form.date = null;
      if(date != null){
        form.date = date;
      }
      verificationFiche() 
      
      
    });

    action.enqueteur.on('change',function(){
      var enqueteur =  action.enqueteur.val();
      form.enqueteur = null;
      if(enqueteur != ''){
        form.enqueteur = enqueteur;
      }
      
    })
    function donnees(pecheurs,village,annee,mois,date){
      $(`#warning`).html('');
      if(village ==null,annee == null || mois ==null || date==null || date ==''){
        $(`#warning`).html(`<span class="badge badge-danger"><i class="fa fa-times"></i> veuillez saisir ou corriger toutes les informations</badge>`)
      }
      else{
        if(pecheurs.length<1 ){
          if(village == null){
            $(`#warning`).html(`<span class="badge badge-danger"><i class="fa fa-times"></i> veuillez saisir ou corriger toutes les informations</badge>`)
          }
          else{
            $(`#warning`).html(`<span class="badge badge-danger"><i class="fa fa-times"></i> Aucun pecheur(s) dans cette village ou fiche est déja complète</badge>`)
          }
          
        }
        
      }
    }

    function verificationFiche(){
      pecheurs = ListePecheurFiche(form.village,form.annee,form.mois);
      donnees(pecheurs,form.village,form.annee,form.mois,form.date)
      if( pecheurs.length<1 || form.annee == null || form.annee==null || form.date==null || form.date =='' ){
        action.ajout_fiche.attr('disabled','disabled');
        form.enquete=[];
        $('#table_pecheur').hide();
      }
      else{
        
        $('#table_pecheur').show();
        action.ajout_fiche.removeAttr('disabled');
        var trbody = '';
        form.enquete=[];
        $.map(pecheurs,function(a,b){
          var sexe_status = 1;
          if(a.sexe == '' || a.sexe == null){
            sexe_status=0;
          }
          form.enquete=[...form.enquete,{
            pecheur:a.id,
            nom:a.nom,
            sexe:a.sexe,
            sexe_status:sexe_status,
            crabe:0,
            activite:{
              activite1:null,
              pourcentage1:null,
              activite2:null,
              pourcentage2:null,
              activite3:null,
              pourcentage3:null
            }
          }]});
          console.log(form)
          creer_table();
          validation_button()
      }
    }
    function creer_table(){
      var chaineActivites = '';
        var count = 0;
        var activites = ListeActivites();
        
      table.clear().draw();
      $.map(form.enquete,function(a,b){
         table.row.add([
          `${a.nom}`,
         ` <input type="number" hidden id="js-pecheur${a.pecheur}" name="js-pecheur${a.pecheur}" >
               <input id="js-sexe-homme${count}" name="js-sexe${count}" type="radio"  value="H" `+(a.sexe=='H'?`checked`:``)+` onclick="change_sexe(${count})" `+(a.sexe !=null && a.sexe=='F'?`disabled`:``)+` >
                   H <br>
               
                   <input id="js-sexe-femme${count}" name="js-sexe${count}" type="radio" value="F" `+(a.sexe=='F'?`checked`:``)+` onclick="change_sexe(${count})" `+(a.sexe !=null && a.sexe=='H'?`disabled`:``)+`>
                   F     
           `,
         `<div class="btn-group btn-group-toggle" data-toggle="buttons">
           <label class="btn btn-xs btn-outline-secondary `+(form.enquete[count].crabe=='0'?`active`:``)+`  ">
       
           <input type="radio" value="0" name="js-crabe${count}" onclick="change_crabe(${count})"  `+(form.enquete[count].crabe=='0'?`checked`:``)+`   > Non
     
           </label>
           <label class="btn btn-xs btn-outline-secondary `+(form.enquete[count].crabe=='1'?`active`:``)+`  ">
       
           <input type="radio" value="1"   name="js-crabe${count}" onclick="change_crabe(${count})"   > Oui
     
           </label>
     
          </div>`,
         `             <select size="1" class="custom-select" name="js-activite1${count}" id="js-activite1${count}" onchange="change_activite1(${count})" style="width:110px">
                          <option value=""></option>
                               `+$.map(activites,function(act,bact){
                                if(act.id==form.enquete[count].activite.activite1){
                                  return `<option value="${act.id}" selected>${act.nom}</option>`;
                                }
                                else{
                                  if(form.enquete[count].crabe == 0){
                                    if(act.id != 1){
                                      return `<option value="${act.id}">${act.nom}</option>`;
                                    }
                                  }
                                  else{
                                    return `<option value="${act.id}">${act.nom}</option>`;
                                  }
                                }
                                
                              })+`
                           </select>`,
                          `<input class="form-control"  type="number" style="width:60px" name="js-activite1-pourcent${count}" id="js-activite1-pourcent${count}" onkeyup="change_pourcentage1(${count})" value="${form.enquete[count].activite.pourcentage1}" >`,
                            `<select class="custom-select" size="1" name="js-activite2${count}" id="js-activite2${count}" style="width:110px" onchange="change_activite2(${count})">
                                                  <option value=""></option>
                                                        `+$.map(activites,function(act,bact){
                                                          if(act.id==form.enquete[count].activite.activite2){
                                                            return `<option value="${act.id}" selected>${act.nom}</option>`;
                                                          }
                                                          else{
                                                            if(form.enquete[count].crabe == 0){
                                                              if(act.id != 1){
                                                                return `<option value="${act.id}">${act.nom}</option>`;
                                                              }
                                                            }
                                                            else{
                                                              return `<option value="${act.id}">${act.nom}</option>`;
                                                            }
                                                          }
                                                        })+`
                            </select>`,
                          `<input  type="number" class="form-control"  name="js-activite2-pourcent${count}" id="js-activite2-pourcent${count}" style="width:60px" onkeyup="change_pourcentage2(${count})" value="${form.enquete[count].activite.pourcentage2}" >`,
                          `<select size="1" class="custom-select " name="js-activite3${count}" id="js-activite3${count}" onchange="change_activite3(${count})" style="width:110px">
                                <option value=""></option>
                                `+$.map(activites,function(act,bact){
                                  if(act.id==form.enquete[count].activite.activite3){
                                    return `<option value="${act.id}" selected>${act.nom}</option>`;
                                  }
                                  else{
                                    if(form.enquete[count].crabe == 0){
                                      if(act.id != 1){
                                        return `<option value="${act.id}">${act.nom}</option>`;
                                      }
                                    }
                                    else{
                                      return `<option value="${act.id}">${act.nom}</option>`;
                                    }
                                  }
                                })+`
                            </select>`,
                          `<input class="form-control"  type="number"  name="js-activite3-pourcent${count}" id="js-activite3-pourcent${count}" onkeyup="change_pourcentage3(${count})" style="width:60px" value="${form.enquete[count].activite.pourcentage3}" >`,

                          `<button name="btn-enregistrer${count}" id="btn-enregistrer${count}" class="btn btn-sm btn-default" onclick="enregistrer_enquete(${count})" >Enregistrer</button>`]).draw(false);
         count++;
      });
      table.columns.adjust().draw();
      
    }
    function enregistrer_enquete(key){
      if(form.enquete[key].crabe == null || form.enquete[key].activite.activite1 ==null ||form.enquete[key].activite.pourcentage1==null||(form.enquete[key].activite.activite2 != null && form.enquete[key].activite.pourcentage2==null)||(form.enquete[key].activite.pourcentage2 != null && form.enquete[key].activite.activite2 == null)||(form.enquete[key].activite.activite3 !=null && form.enquete[key].activite.pourcentage3==null)||(form.enquete[key].activite.pourcentage3 != null && form.enquete[key].activite.activite3 == null))
      {
        erreur('Les donées sont incomplètes')
      }
      else{
        
        $.alert({
          content: function () {
              var self = this;
              return $.ajax({
                  url: `${BASE_URL}/recensement-mensuel/insertion-enquete`,

                  data: {village:form.village,annee:form.annee,mois:form.mois,date:form.date,enqueteur:form.enqueteur,enquete:[form.enquete[key]]},

                  type: 'post',

                  dataType: 'json'
              }).done(function (response){
                  if(response.result){
                      self.setContent(response.message)
                      self.setTitle(response.title)
                      form.enquete.splice(key,1)
                      creer_table()
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
    function validation_button(){
      var btn_verification = verification_button();
      if(btn_verification.result){

        action.enregistrer_nouvelle.text("Enregistrer et nouvelle enquête");
        action.enregistrer_nouvelle.removeAttr('disabled');
        action.enregistrer.removeAttr('disabled');

      }
      else{
        
        action.enregistrer_nouvelle.text("Enregistrer les données validés");
        if(btn_verification.donnees.enquete.length>0){
          action.enregistrer_nouvelle.removeAttr('disabled');
        }
        else{
          action.enregistrer_nouvelle.attr('disabled','disabled');
        }
        
        action.enregistrer.attr('disabled','disabled');
      }
    }
    function verification_button(){
      var result = true;
      var donnees = {
        village:form.village,
        annee:form.annee,
        mois:form.mois,
        date:form.date,
        enqueteur:form.enqueteur,
        enquete:[]};

      for(index=0;index<form.enquete.length;index++){
        
        if(form.enquete[index].crabe == null || form.enquete[index].activite.activite1 ==null ||form.enquete[index].activite.pourcentage1==null||(form.enquete[index].activite.activite2 != null && form.enquete[index].activite.pourcentage2==null)||(form.enquete[index].activite.pourcentage2 != null && form.enquete[index].activite.activite2==null)||(form.enquete[index].activite.activite3 !=null && form.enquete[index].activite.pourcentage3==null)||(form.enquete[index].activite.pourcentage3 != null && form.enquete[index].activite.activite3 == null))
      {
        result = false;
        
      }
      else{
        donnees.enquete=[...donnees.enquete,form.enquete[index]]
      }

      }
      return {'result':result,'donnees':donnees};

    }
    function change_sexe(key){
      var sexe = $(`[name=js-sexe${key}]:checked`).val();
      form.enquete[key].sexe= sexe;
    }

    function change_crabe(key){
      var crabe = $(`[name=js-crabe${key}]:checked`).val();
      form.enquete[key].crabe= crabe;
      var activites = ListeActivites();
      var chaineActivites = '<option value=""></option>';
      

      if(crabe==1){
        $.map(activites,function(a,b){
          chaineActivites +=`<option value="${a.id}">${a.nom}</option>`;
        })
      }
      else{
        $.map(activites,function(a,b){
          if(a.id !=1){
            chaineActivites +=`<option value="${a.id}">${a.nom}</option>`;
          }
        })
      }
      $(`#js-activite1${key}`).html(chaineActivites);
      $(`#js-activite2${key}`).html(chaineActivites);
      $(`#js-activite3${key}`).html(chaineActivites);

    }
    function change_activite1(key){
      var activite1 = $(`[name=js-activite1${key}]`).val();
      form.enquete[key].activite.activite1=null;
      if(activite1 !=''){
        form.enquete[key].activite.activite1=activite1;
        $(`[name=js-activite2${key}] option`).prop('disabled',false).trigger('change');
        $(`[name=js-activite3${key}] option`).prop('disabled',false).trigger('change');
        $(`[name=js-activite2${key}]  option[value="${activite1}"]`).attr('disabled',true);
        $(`[name=js-activite3${key}]  option[value="${activite1}"]`).attr('disabled',true);
      }
      
      validation_button()
     
    }

    function change_activite2(key){
      var activite2 = $(`[name=js-activite2${key}]`).val();
      var activite1 = $(`[name=js-activite1${key}]`).val();
      form.enquete[key].activite.activite2=null;
      if(activite2 !=''){
        form.enquete[key].activite.activite2=activite2;
        $(`[name=js-activite3${key}] option`).prop('disabled',false).trigger('change');
        $(`[name=js-activite3${key}]  option[value="${activite1}"]`).attr('disabled',true);
        $(`[name=js-activite3${key}]  option[value="${activite2}"]`).attr('disabled',true);
      }
      
      validation_button()
     
    }
    function change_activite3(key){
      var activite3 = $(`[name=js-activite3${key}]`).val();
      form.enquete[key].activite.activite3=null;
      if(activite3 !=''){
        form.enquete[key].activite.activite3=activite3;
      }
      validation_button()
     
    }

    function change_pourcentage1(key){
      var pourcentage1 = $(`[name=js-activite1-pourcent${key}]`).val();
      form.enquete[key].activite.pourcentage1=null;
      if(pourcentage1 !=''){
        form.enquete[key].activite.pourcentage1=pourcentage1;
      }
      validation_button()
     
    }
    function change_pourcentage2(key){
      var pourcentage2 = $(`[name=js-activite2-pourcent${key}]`).val();
      form.enquete[key].activite.pourcentage2=null;
      if(pourcentage2 !=''){
        form.enquete[key].activite.pourcentage2=pourcentage2;
      }
      validation_button()
     
    }
    function change_pourcentage3(key){
      var pourcentage3 = $(`[name=js-activite3-pourcent${key}]`).val();
      form.enquete[key].activite.pourcentage3=null;
      if(pourcentage3 !=''){
        form.enquete[key].activite.pourcentage3=pourcentage3;
      }
      validation_button()
     
    }

  function erreur(message){
        $.alert({
                title: "Erreur",
                content: message
            })
    }

    function warning(index){
      $(`#warning`).html("");
      if( form.enquete[index].resident ==null || form.enquete[index].pecheur ==null||form.enquete[index].sexe ==null ||form.enquete[index].age ==null||form.enquete[index].age ==''|| form.enquete[index].pirogue ==null||(form.enquete[index].toute_annee==0 && form.enquete[index].periode_mare==null) || form.enquete[index].activite.activite1==null || form.enquete[index].engins.engin1 ==null || form.enquete[index].engins.annee1 ==null||form.enquete[index].activite.pourcentage1==null||(form.enquete[index].resident ==0 && form.enquete[index].village_origine ==null)||( form.enquete[index].activite.pourcentage2 !=null && (form.enquete[index].activite.activite2==null) )||(form.enquete[index].resident ==1 && form.enquete[index].toute_annee ==null)||(form.enquete[index].resident ==0 && form.enquete[index].periode_mare ==null) ||(parseInt(form.enquete[index].activite.activite2)>0 && (form.enquete[index].activite.pourcentage2==null||form.enquete[index].activite.pourcentage2=='') )||(parseInt(form.enquete[index].activite.activite3)>0 && (form.enquete[index].activite.pourcentage3==null||form.enquete[index].activite.pourcentage3 =='') )||(parseFloat(form.enquete[index].activite.pourcentage3)>0 && (form.enquete[index].activite.activite3==null||form.enquete[index].activite.activite3=='') )||(parseInt(form.enquete[index].engins.engin2)>0 && (form.enquete[index].engins.annee2==null||form.enquete[index].activite.annee2 =='') )||(parseInt(form.enquete[index].engins.annee2)>0 && (form.enquete[index].engins.engin2==null||form.enquete[index].engins.engin2 =='') ) || (form.enquete[index].periode_mare=='mare') && (form.enquete[index].type_mare ==null)||(form.enquete[index].periode_mare=='mois') && (form.enquete[index].periode_mois ==null)){
          $(`#warning${index}`).html(`<span class="badge badge-danger"><i class="fa fa-times"></i> veuillez saisir ou corriger toutes les informations</badge>`)
      }

      
      
  }

    function ListeActivites(){
    
      let activites = [] ;
      $.ajax({
  
          method: 'post',
  
          data: {},
  
          url: `${BASE_URL}/activite/liste_tous`,
  
          dataType: 'json',
  
          async: false 
  
        }).done(function(data){
  
          for(let act of data){
              activites.push({id:act.id,nom:act.nom})
          }
  
        }).fail(function(f){
  
        });
      return activites; 
  
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
              
              pecheurss.push({id:data[i].id,sexe:data[i].sexe,nom:data[i].nom,selected:false});
          }
  
        }).fail(function(f){})
  
        return pecheurss;
  
  }

  function ListePecheurFiche(village,annee,mois){


    var pecheurss = [];
    
    $.ajax({

        method: 'post',

        data: {village:village,annee:annee,mois:mois},

        url: `${BASE_URL}/recensement-mensuel/fiche-existe`,

        dataType: 'json',

        async: false ,

      }).done(function(data){
        
        
        for(var i=0;i<data.length;i++){
            
            pecheurss.push({id:data[i].id,sexe:data[i].sexe,nom:data[i].nom,selected:false});
        }

      }).fail(function(f){})
      
      return pecheurss;
      

}
  
 

