$(() => {
  const formulaire = $('#js-formulaire-insertion')

  const modal = $('#modal-insertion')

  const form = {
    nom: formulaire.find('[name=js-nom]'),
    creation: formulaire.find('[name=js-creation]'),
    modification: formulaire.find('[name=js-modification]'),
    visualisation: formulaire.find('[name=js-visualisation]'),
    suppression: formulaire.find('[name=js-suppression]'),
    soummission: $('#js-enregistrer')
  }

  modal.on('show.bs.modal', () => {
    form.nom.val('')
    form.creation.prop('checked', false)
    form.modification.prop('checked', false)
    form.visualisation.prop('checked', false)
    form.suppression.prop('checked', false)
  })

  form.soummission.on('click', e => {
    formulaire.trigger('submit')
  })

  formulaire.on('submit', e => {
    e.preventDefault()
    effacerValidationPrecedente()
    if(!form.soummission.is(':disabled') && champObligatoireComplet()) {
      form.soummission.attr('disabled', true)
      $.ajax({
        url: `${BASE_URL}/operation/nouvelle-operation/insertion`,
        method: 'post',
        data: {
          nom: form.nom.val(),
          creation: form.creation.is(':checked') ? 1 : 0,
          modification: form.modification.is(':checked') ? 1 : 0,
          visualisation: form.visualisation.is(':checked') ? 1 : 0,
          suppression: form.suppression.is(':checked') ? 1 : 0
        },
        dataType: 'json',
        success: reponse => {
          if (reponse.succes) {
            $(document).trigger('recharger-datatable')
            modal.modal('hide')
          } else {
            $.alert({
              title: 'Erreur du traitement',
              content: reponse.message
            })
          }
          form.soummission.removeAttr('disabled')
        },
        error: (arg1, arg2, arg3) => {
          console.log(arg1, arg2, arg3)
          form.soummission.removeAttr('disabled')
        },
      });
    }
  })

  function effacerValidationPrecedente() {
    $('.is-invalid').removeClass('is-invalid')
    $('.form-text').hide()
  }

  function champObligatoireComplet() {
    let valide = true
    const requises = [
      form.nom,
    ]

    for (let requis of requises) {
      if (requis.val() === '') {
        valide = false;
        requis.parents('.form-group').find('.form-text').text('Ce champ est obligatoire');
        requis.parents('.form-group').find('.form-text').show();
        requis.addClass('is-invalid');
      }
    }

    return valide;
  }
})