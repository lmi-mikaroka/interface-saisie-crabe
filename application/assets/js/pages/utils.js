const BASE_URL = 'https://applis.ocea.re/corecrabe';

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
  {id: 18, min: 1, max: 1},
  {id: 17, min: 1, max: 1},



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