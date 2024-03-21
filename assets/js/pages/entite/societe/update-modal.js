$(() => {

  const lien = ''

  const formulaire = $('#formulaire-modification')

  const enregistrer = $('#enregistrer-modification')

  const modal = $('#update-modal')



  const form = {

    id: formulaire.find('[name=js-id]'),

    nom: formulaire.find('[name=js-nom]'),
    num: formulaire.find('[name=js-num]'),
    adresse: formulaire.find('[name=js-adresse]'),
    nomPersonneContact: formulaire.find('[name=js-nomPersonneContact]'),

  };



  enregistrer.on('click', e => {

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

            url: `${BASE_URL}/entite/societe/mise-a-jour`,

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

              attente.setContent('La modification de la Société a été effectuée')

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

    const requises = [

      form.nom,
      form.adresse

    ]

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

    return {

      id: form.id.val(),

      nom: form.nom.val(),
      adresse: form.adresse.val(),
      num: form.num.val(),
      nomPersonneContact: form.nomPersonneContact.val(),


    }

  }

})