$(() => {
  const formulaire = $('#js-formulaire-modification')

  const modal = $('#modal-modification')

  const form = {
    id: formulaire.find('[name=js-id]'),
    nom: formulaire.find('[name=js-nom]'),
    permissions: [],
    soummission: $('#js-modifier')
  }

  form.soummission.on('click', e => {
    formulaire.trigger('submit')
  })

  formulaire.on('submit', e => {
    e.preventDefault()
    effacerValidationPrecedente()
    if (!form.soummission.is(':disabled') && champObligatoireComplet()) {
      form.soummission.attr('disabled', true)
      const donnees = {
        id: form.id.val(),
        nom: form.nom.val(),
        permissions: []
      }
      form.permissions.forEach(permission => {
        donnees.permissions.push({
          operation: permission.id.val(),
          creation: permission.creation === null ? 0 : (permission.creation.is(':checked') ? 1 : 0),
          modification: permission.modification === null ? 0 : (permission.modification.is(':checked') ? 1 : 0),
          visualisation: permission.visualisation === null ? 0 : (permission.visualisation.is(':checked') ? 1 : 0),
          suppression: permission.suppression === null ? 0 : (permission.suppression.is(':checked') ? 1 : 0),
        })
      })
      $.ajax({
        url: `${BASE_URL}/groupe/nouveau-groupe/modification`,
        method: 'post',
        data: donnees,
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

  (() => {
    formulaire.find('.js-operation').each((iteration, elementCible) => {
      const permission = {
        id: formulaire.find(`[name=js-permission${iteration}]`),
        creation: formulaire.find(`[name=js-creation${iteration}]`),
        modification: formulaire.find(`[name=js-modification${iteration}]`),
        visualisation: formulaire.find(`[name=js-visualisation${iteration}]`),
        suppression: formulaire.find(`[name=js-suppression${iteration}]`)
      }
      form.permissions.push({
        id: permission.id,
        creation: permission.creation.length ? permission.creation : null,
        modification: permission.modification.length ? permission.modification : null,
        visualisation: permission.visualisation.length ? permission.visualisation : null,
        suppression: permission.suppression.length ? permission.suppression : null,
      })
    })
  })()
})