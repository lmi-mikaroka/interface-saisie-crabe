$(() => {

  const  date_aujourdhui = new Date();
  const form = {

    corps: $('#js-formulaire'),

    sexe: $('[name=pecheur-sexe]'),

    datenais: $('[name=pecheur-datenais]'),
    
    fiche: $('[name=js-fiche]'),

    enquete: $('[name=js-enquete]'),

    date: $('[name=js-date]'),

    jour: $('[name=js-jour]'),

    village_origine: $('[name=js-village-origine]'),

    village_activite: $('[name=js-village-activite]'),

    pecheur: $('[name=js-pecheur]'),

    resident: $('[name=js-resident]'),

    pirogue: $('[name=js-pirogue]'),

    toute_annee: $('[name=js-toute-annee]'),

    date_debut: $('[name=js-date-debut]'),

    date_fin: $('[name=js-date-fin]'),
    engins: [

      {

        nom: $('[name=js-engin-de-peche-nom1]'),

        annee: $('[name=js-engin-de-peche-annee1]'),

      },

      {

        nom: $('[name=js-engin-de-peche-nom2'),

        annee: $('[name=js-engin-de-peche-annee2]'),

      },
      {

        nom: $('[name=js-engin-de-peche-nom3'),

        annee: $('[name=js-engin-de-peche-annee3]'),

      },

    ],
    activite :[
      {
        id: $('[name=js-activite-primaire]'),
        pourcent: $('[name=js-activite-primaire-pourcent]'),
      },
      {
        id: $('[name=js-activite-secondaire]'),
        pourcent: $('[name=js-activite-secondaire-pourcent]'),
      },
      {
        id: $('[name=js-activite-tertiaire]'),
        pourcent: $('[name=js-activite-tertiaire-pourcent]'),
      },
    ],

  }
  const boutons = {

    enregistrerEtListe: $('#js-bouton-enregistrer'),

  }



 
  const control_div = {
    div_village_origine : $('#div-village-origine'),
    div_toute_annee : $('#div-toute-annee'),
    div_periode : $('#div-periode'),
  
  }
  

  
  
  form.resident.on('click',e=>{
    var value = form.resident.filter(':checked').val();
    if(value == 1)
    {
      control_div.div_village_origine.hide();
      control_div.div_toute_annee.show();
      var valeur = form.toute_annee.filter(':checked').val();
      boolDivDate(valeur);
      form.village_origine.val('');
      //affichepecheur()
      var village = form.village_activite.val();
   liste_par_origine_pecheur(village).then(pecheurs => {
    
      let chainePecheur = '<option value="" selected hidden></option>';
    if(pecheurs.length>0){
      for (let pecheur of pecheurs) {
      
        chainePecheur += `<option value="${pecheur['id']}">${pecheur['nom']}</option>`
      
        
      
      }
    }
      
      form.pecheur.html(chainePecheur)

    }).finally(() => {

      

    })


    }
    else{
      control_div.div_village_origine.show();
      showDivdate();
      control_div.div_toute_annee.hide();
      let chainePecheur = '<option value="" selected hidden></option>';
      form.pecheur.html(chainePecheur)
      //affichePecheur vide => change_ville_origine => affichepecheur
    }
      
  });

  form.village_origine.on('change',()=>{
    var village = form.village_origine.val();
   liste_par_origine_pecheur(village).then(pecheurs => {
    
      let chainePecheur = '<option value="" selected hidden></option>'
    if(pecheurs.length>0){
      for (let pecheur of pecheurs) {
      
        chainePecheur += `<option value="${pecheur['id']}">${pecheur['nom']}</option>`
      
        
      
      }
    }
      
      form.pecheur.html(chainePecheur)

    }).finally(() => {

      

    })
  });

  form.toute_annee.on('click',e=>{
    var valeur = form.toute_annee.filter(':checked').val();
    boolDivDate(valeur);

  });

  form.jour.on('change', () => {

    const valeurDate = form.date.val();

    form.date.val(`${valeurDate.toString().substr(0, 8)}${('0' + form.jour.val()).substr(-2)}`);

    form.date.trigger('change');

  });



  form.activite[0].id.on('change',()=>{
    var x = form.activite[0].id.val();
    $("#js-activite-secondaire option").prop('disabled',false).trigger('change');
    $("#js-activite-tertiaire option").prop('disabled',false).trigger('change');
    $("#js-activite-secondaire option[value="+x+"]").attr('disabled',true);
    $("#js-activite-tertiaire option[value="+x+"]").attr('disabled',true);  

  });
  form.activite[1].id.on('change',()=>{
   
    var val1 = form.activite[0].id.val();
    var val2 = form.activite[1].id.val();
    $("#js-activite-tertiaire option").prop('disabled',false).trigger('change');
    $('#js-activite-tertiaire option[value="' + val1 + '"]').attr('disabled',true);
    $('#js-activite-tertiaire option[value="' + val2 + '"]').attr('disabled',true);
    

  });
  
  form.activite[2].id.on('change',()=>{
    
    
    
  });
  form.pecheur.on('change',function(){
    var val =  form.pecheur.val();
    if(val != ''){
      $('#information-pecheur').show();
    }

    detail_pecheur(val).then(pecheur => {
      

     $('#pecheur-nom').val(pecheur['nom']);
     form.sexe.prop('checked',false).trigger('change');
     form.sexe.filter('[value='+ pecheur['sexe'] +']').prop('checked', true);
     $('#pecheur-datenais').val(date_aujourdhui.getFullYear()- parseInt(pecheur['datenais']));
     
      
      
      

    }).finally(() => {

      

    })
    
  });
  function hiddenDivdate(){
    control_div.div_periode.hide();
  }
  function showDivdate(){
    control_div.div_periode.show();
  }
  function boolDivDate(valeur)
  {
    if(valeur==0){
      showDivdate();
    }
    else{
      
      hiddenDivdate();
      
    }
  }




  // Soumission du formulaire








boutons.enregistrerEtListe.on('click', e => {

  e.preventDefault();

  effacerValidationPrecedente();
  

  enregistrerFormulaire().then(() => {

    $.alert('L\'insertion du formulaire est un succès');

    setTimeout(() => location.href = `${BASE_URL}/consultation-de-fiche-recensement/detail-et-action/${form.fiche.val()}.html`, 1000);

  }).finally(() => {

    boutons.enregistrerEtListe.removeAttr('disabled');


  });

});



function enregistrerFormulaire() {
  
  return new Promise((resolve, reject) => {

    const formulaireValide = champNombreRespecteMinMax() && champObligatoireComplet();

    if (!boutons.enregistrerEtListe.is(':disabled')  && formulaireValide) {

      $('.js-formulaire-card .js-alerte-information-incorrecte').slideUp(100);

      boutons.enregistrerEtListe.attr('disabled', true);


      $.ajax({

        url: `${BASE_URL}/modification-de-fiche-recensement/enregistrer`,

        method: 'post',

        data: mettreAJourLesDonneesDePost(),

        dataType: 'json',

        success: reponse => {
          console.log(Response);
          resolve(reponse);

        },

        error: (arg1, arg2, arg3) => {
          reject([arg1, arg2, arg3]);

        }

      });

    } else {

      $('.js-formulaire-card .js-alerte-information-incorrecte').slideDown(100);

    }

  });

}

function mettreAJourLesDonneesDePost() {

  var residentvalue = form.resident.filter(':checked').val();

  var village_origine  ;

  if(residentvalue == 0){

    village_origine = form.village_origine.val();

  }
  else{

   village_origine = form.village_activite.val();
   
  }

  if(form.datenais.val() ==''){
    var datenais = null;
  }
  else{
    var datenais =  form.datenais.val();
  }
   
   const donnee = {

   enquete : form.enquete.val(),

   fiche: form.fiche.val(),

   sexe : form.sexe.filter(':checked').val(),

   datenais: ( date_aujourdhui.getFullYear()-form.datenais.val()),

   resident : form.resident.filter(':checked').val(), 

   village_activite: form.village_activite.val(),

   village_origine : village_origine,

   pecheur: form.pecheur.val(),

   date : form.date.val(),
   
   pirogue: form.pirogue.filter(':checked').val(),

   toute_annee: form.toute_annee.val(),

   date_debut: form.date_debut.val(),

   date_fin: form.date_fin.val(),
   engins: [

     {

       nom: form.engins[0].nom.val(),

       annee: form.engins[0].annee.val(),

     },

     {

       nom: form.engins[1].nom.val(),

       annee: form.engins[1].annee.val(),

     },
     {

       nom: form.engins[2].nom.val(),

       annee: form.engins[2].annee.val(),

     },

   ],
   activite : [
                 {
                   id: form.activite[0].id.val(),
                   pourcent: form.activite[0].pourcent.val(),
                 },
                 {
                   id: form.activite[1].id.val(),
                   pourcent: form.activite[1].pourcent.val(),
                 },
                 {
                   id: form.activite[2].id.val(),
                   pourcent: form.activite[2].pourcent.val(),
                 },

            ],

   };

  

   return donnee;

 }

    function champNombreRespecteMinMax() {

      let valide = true;
  
      $('input[type=number]').each((index, elementCible) => {
  
        const erreurTag = $(elementCible).parents('.form-group').find('.form-text');
  
        if ($(elementCible).attr('min') !== 'undefined' && parseFloat($(elementCible).attr('min')) > parseFloat($(elementCible).val())) {
  
          valide = false;
  
          erreurTag.text(`valeur inférieure ${$(elementCible).attr('min')}`);
  
          erreurTag.show();
  
          $(elementCible).addClass('is-invalid');
  
        } else if ($(elementCible).attr('max') !== 'undefined' && parseFloat($(elementCible).attr('max')) < parseFloat($(elementCible).val())) {
  
          valide = false;
  
          erreurTag.text(`valeur maximale ${$(elementCible).attr('max')}`);
  
          erreurTag.show();
  
          $(elementCible).addClass('is-invalid');
  
        }
  
      });
  
  
  
      return valide;
  
    }

    function champObligatoireComplet() {

      let valide = true;
  
      const erreurs = [];
  
      const requises = [
  
        form.resident,

        form.pecheur,
  
        form.pirogue,
  
        form.toute_annee,

        form.datenais,

        form.activite[0].id,

        form.activite[0].pourcent,

        form.engins[0].nom,
        
        form.engins[0].annee,
  
      ];
  
  
     var valueResident = form.resident.filter(':checked').val();
     var valueToute_annee = form.toute_annee.filter(':checked').val();
     var valuePourcentPrimaire = form.activite[0].pourcent.val();
      if (valueResident == 0) {
        
        requises.push(form.village_origine);
        
  
      }

      if (valueToute_annee==0) {
  
        requises.push(form.date_debut);
        requises.push(form.date_fin);
  
      }

      if(valuePourcentPrimaire<100)
      {
        requises.push(form.activite[1].id);
        requises.push(form.activite[1].pourcent);
      }

      if(form.engins[0].nom.val() !=''){
        requises.push(form.engins[1].annee);
      }

      if(form.engins[2].nom.val() !=''){
        requises.push(form.engins[2].annee);
      }
  
  
  
  
      let errorString = '';
  
      for (let erreur of erreurs) {
  
        errorString += `<li>${erreur}</li>`;
  
      }
  
  
  
      $('.js-formulaire-card .js-alerte-information-incorrecte-conteneur').html(errorString);
  
      if (erreurs.length === 0) {
  
        $('.js-formulaire-card .js-alerte-information-incorrecte').slideUp(100);
  
      }
  
  
  
      for (let requis of requises) {
  
        if (requis.val() === '') {
  
          valide = false;
  
          requis.parents('.form-group').find('.form-text').text('Ce champ est obligatoire');
  
          requis.parents('.form-group').find('.form-text').show();
  
          requis.addClass('is-invalid');
  
        }
  
      }

      if(!form.sexe.is(':checked')){
        valide = false;
        form.sexe.parents('.form-group').find('.form-text').show();
      }
  
  
  
      return valide;
  
    }


    function effacerValidationPrecedente() {

      $('.is-invalid').removeClass('is-invalid');
  
      $('.form-text').hide();
  
    }

    function getAge(date) { 
      var diff = Date.now() - date.getTime();
      var age = new Date(diff); 
      return Math.abs(age.getUTCFullYear() - 1970);
  }




});