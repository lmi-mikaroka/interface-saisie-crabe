const BASE_URL = 'http://vps-a8d8821c.vps.ovh.net/corecrabe';

const BIOMETRIE_CRABE_MAX = 30;

const TAILLE_MAXIMALE_CRABE = 250;

const TAILLE_MINIMALE_CRABE = 30;

const POIDS_MAX_DE_ECHANTILLON = 30;

const CHIFFRE_APRES_VIRGULE = 1;

const MARCHE_LOCAL_MIN = 400

const MARCHE_LOCAL_MAX = 20000

const ENGINS = [

  {id: 1, min: 0, max: 0},

  {id: 2, min: 1, max: 100},

  {id: 3, min: 1, max: 1},

  {id: 4, min: 1, max: 1},

  {id: 5, min: 3, max: 40},

  {id: 6, min: 1, max: 100},

  {id: 7, min: 1, max: 100},
  {id: 15, min: 1, max: 1},
  {id: 16, min: 1, max: 1},
  {id: 17, min: 1, max: 1},
  {id: 18, min: 1, max: 1},



]



function actualiserListeEnqueteur(village, typeEnqueteur) {

  return new Promise((resolve, reject) => {

    if (village === '') resolve([])

    else {

      $.ajax({

        method: 'post',

        data: {village: village, typeEnqueteur: typeEnqueteur},

        url: `${BASE_URL}/enqueteur/selection_par_village`,

        dataType: 'json',

        success: enqueteurs => resolve(enqueteurs),

        error: (arg1, arg2, arg3) => reject([arg1, arg2, arg3])

      })

    }

  })

}

function detail_pecheur(pecheur) {

  return new Promise((resolve, reject) => {

    if (pecheur === '') resolve([])

    else {

      $.ajax({

        method: 'post',

        data: {pecheur: pecheur},

        url: `${BASE_URL}/pecheur/detail-pecheur`,

        dataType: 'json',

        success: enqueteurs => resolve(enqueteurs),

        error: (arg1, arg2, arg3) => reject([arg1, arg2, arg3])

      })

    }

  })

}

function liste_par_origine_pecheur(village) {

  return new Promise((resolve, reject) => {

    if (village === '') resolve([])

    else {

      $.ajax({

        method: 'post',

        data: {village: village},

        url: `${BASE_URL}/pecheur/liste-pecheur-village-origine`,

        dataType: 'json',

        success: pecheurs => resolve(pecheurs),

        error: (arg1, arg2, arg3) => reject([arg1, arg2, arg3])

      })

    }

  })

}

function actualiserListeEnqueteurVillageSeulement(village) {

  return new Promise((resolve, reject) => {

    if (village === '') resolve([])

    else {

      $.ajax({

        method: 'post',

        data: {village: village},

        url: `${BASE_URL}/enqueteur/selection_par_village_seulement`,

        dataType: 'json',

        success: enqueteurs => resolve(enqueteurs),

        error: (arg1, arg2, arg3) => reject([arg1, arg2, arg3])

      })

    }

  })

}

function actualiserListeCommune(zone) {

  return new Promise((resolve, reject) => {


      $.ajax({

        method: 'post',

        data: {zone:zone},

        url: `${BASE_URL}/commune/liste-par-zone-corecrabe`,

        dataType: 'json',

        success: communes => resolve(communes),

        error: (arg1, arg2, arg3) => reject([arg1, arg2, arg3])

      })

    

  })

}

function actualiserListeFokontanyParCommune(commune) {

  return new Promise((resolve, reject) => {


      $.ajax({

        method: 'post',

        data: {commune:commune},

        url: `${BASE_URL}/fokontany/liste-par-commune`,

        dataType: 'json',

        success: fokontanys => resolve(fokontanys),

        error: (arg1, arg2, arg3) => reject([arg1, arg2, arg3])

      })

    

  })

}

function actualiserListeVillageParFokontany(fokontany) {

  return new Promise((resolve, reject) => {


      $.ajax({

        method: 'post',

        data: {fokontany:fokontany},

        url: `${BASE_URL}/village/liste-par-fokontany`,

        dataType: 'json',

        success: villages => resolve(villages),

        error: (arg1, arg2, arg3) => reject([arg1, arg2, arg3])

      })

    

  })

}

function actualiserListeActivite() {

  return new Promise((resolve, reject) => {


      $.ajax({

        method: 'post',

        data: {},

        url: `${BASE_URL}/activite/liste_tous`,

        dataType: 'json',

        success: activites => resolve(activites),

        error: (arg1, arg2, arg3) => reject([arg1, arg2, arg3])

      })

    

  })

}

function ListeEngin() {

  return new Promise((resolve, reject) => {


      $.ajax({

        method: 'get',

        data: {},

        url: `${BASE_URL}/engin/liste-engin`,

        dataType: 'json',

        async: false ,

        success: engins => resolve(engins),

        error: (arg1, arg2, arg3) => reject([arg1, arg2, arg3])

      })

    

  })

}



$(() => {

  // Désactiver la prise en charge des roulette de souris

  $(document).on('focus', 'input[type=number]', e => {

    $(e.currentTarget).select()

    $(e.currentTarget).on('wheel', e => {

      e.preventDefault()

    });

  });



  $(document).on('blur', 'input[type=number]', e => {

    $(e.currentTarget).off('wheel')

  })



  $('input[type=date]').trigger('change')



  $('input[type=number]').each((indexe, elementCible) => {

    if ($(elementCible).attr('min') === undefined) {

      $(elementCible).attr('min', 0);

    }

  })



  $('.js-poids-echantillon').attr('max', POIDS_MAX_DE_ECHANTILLON)

});