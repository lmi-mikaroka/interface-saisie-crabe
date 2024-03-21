$(() => {

  const lien = ''

  const formulaire = $('#formulaire-insertion')

  // const ajouterSociete = $('#js-ajouter-societe')

  // const supprimerSociete = $('#js-supprimer-societe')

  // const nom = $('#js-nom-insertion')

  const enregistrerInsertion = $('#enregistrer-insertion')

  const modal = $('#insert-modal')



  const form = {

    nom: formulaire.find('[name=js-nom]'),
    adresse: formulaire.find('[name=js-adresse]'),
    num: formulaire.find('[name=js-num]'),
    nomPersonneContact: formulaire.find('[name=js-nomPersonneContact]'),

  };



  // ajouterSociete.on('click', () => {

  //   anciennesValeurs = []

  //   noms.find('.form-control').each((indexe, elementCilble) => {

  //     anciennesValeurs.push($(elementCilble).val())

  //   })

  //   nouveauHtml = ''

  //   for(let iteration = 0; iteration < anciennesValeurs.length + 1; iteration++) {

  //     nouveauHtml += genererTemplate(iteration)

  //   }

  //   noms.html(nouveauHtml)

  //   for(let iteration = 0; iteration < anciennesValeurs.length; iteration++) {

  //     noms.find('.form-control').eq(iteration).val(anciennesValeurs[iteration])

  //   }

  //   chargerChampNoms()

  // })



  // supprimerPecheur.on('click', () => {

  //   anciennesValeurs = []

  //   noms.find('.form-control').each((indexe, elementCilble) => {

  //     anciennesValeurs.push($(elementCilble).val())

  //   })

  //   nouveauHtml = genererTemplate()

  //   for(let iteration = 1; iteration < anciennesValeurs.length - 1; iteration++) {

  //     nouveauHtml += genererTemplate(iteration)

  //   }

  //   noms.html(nouveauHtml)

  //   for(let iteration = 0; iteration < anciennesValeurs.length; iteration++) {

  //     noms.find('.form-control').eq(iteration).val(anciennesValeurs[iteration])

  //   }

  //   chargerChampNoms()

  // })



  enregistrerInsertion.on('click', e => {

    e.preventDefault()

    formulaire.trigger('submit')

  })



  formulaire.on('submit', e => {

    e.preventDefault()

    if (champObligatoireOk()) {

      const attente = $.alert({

        useBootstrap: true,

        theme: 'bootstrap',

        animation: 'rotatex',

        closeAnimation: 'rotatex',

        animateFromElement: false,

        content: function () {

          return $.ajax({

            url: `${BASE_URL}/entite/societe/insertion`,

            data: chargerChampsEnvoi(),

            type: 'post',

            dataType: 'json'

          }).done((reponse) => {

            if (!reponse.success) {

              attente.setContent('Une erreur est survenue. Veuillez reessayer ou contacter un administrateur')

              attente.setTitle('Erreur')

            } else {

              attente.onDestroy = () => {

                $(document).trigger('reload-datatable');

                modal.modal('hide');

              }

              attente.setContent('L\'insertion de la société a été effectuée')

              attente.setTitle('Succès')

            }

          }).fail(() => {

            attente.setContent('Une erreur est survenue. Veuillez reessayer ou contacter un administrateur')

            attente.setTitle('Erreur')

          })

        }

      })

    }

  })



  function supprimerValidation() {

    $('.form-text').hide();

    $('.is-invalid').removeClass('is-invalid');

  }



  function champObligatoireOk() {

    let valide = true;

    let requises = [

      form.nom,
      form.adresse

    ]

    // requises = requises.concat(form.noms)

    supprimerValidation()

    for (let required of requises) {

      if (required.val() === '' || required.val() == null) {

        valide = false;

        required.parents('.form-group').find('.form-text').show();

        required.addClass('is-invalid');

      }

    }

    return valide

  }



  function chargerChampsEnvoi() {

    const donnee = {

      nom: form.nom.val(),
      adresse: form.adresse.val(),
      num: form.num.val(),
      nomPersonneContact: form.nomPersonneContact.val(),

    }

    return donnee

  }

  // function chargerChampNoms() {

  //   form.noms = []

  //   noms.find('.form-control').each((indexe, elementCible) => {

  //     form.noms.push($(elementCible))

  //   })

  // }



  // function genererTemplate(ordre) {

  //   return `<div class="form-group">

  //             <input type="text" class="form-control" name="js-nom${typeof ordre === 'undefined' ? 0 : ordre}" maxlength="100">

  //             <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>

  //           </div>`

  // }



  function initialiserFormulaire() {

    form.nom.val('')
    form.adresse.val('')
    form.num.val('')
    form.nomPersonneContact.val('')

    // chargerChampNoms()

    supprimerValidation()

  }



  // chargerChampNoms()



  modal.on('show.bs.modal', e => {

    initialiserFormulaire();

  });

})