$(() => {
  const formulaire = $('#js-formulaire-modification')

  const modal = $('#modal-modification')

  const form = {
    id: formulaire.find('[name=js-id]'),
    nom: formulaire.find('[name=js-nom]'),
    creation: formulaire.find('[name=js-creation]'),
    modification: formulaire.find('[name=js-modification]'),
    visualisation: formulaire.find('[name=js-visualisation]'),
    suppression: formulaire.find('[name=js-suppression]'),
    soummission: $('#js-modifier')
  }

  form.soummission.on('click', e => {
    console.log('clicked')
    formulaire.trigger('submit')
  })

  formulaire.on('submit', e => {
    e.preventDefault()
    effacerValidationPrecedente()
    if(!form.soummission.is(':disabled') && champObligatoireComplet()) {
      form.soummission.attr('disabled', true)
      $.ajax({
        url: `${BASE_URL}/operation/nouvelle-operation/modification`,
        method: 'post',
        data: {
          id: form.id.val(),
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