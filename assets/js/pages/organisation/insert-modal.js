$(() => {

    const formulaire = $('#js-formulaire-insertion')
  
  
  
    const modal = $('#modal-insertion')
  
  
  
    const form = {
  
      label: formulaire.find('[name=js-label]'),
  
  
      soummission: $('#js-enregistrer')
  
    }
  
  
  
    modal.on('show.bs.modal', () => {
  
      form.label.val('')
  
  
    })
  
  
  
    form.soummission.on('click', e => {
  
      formulaire.trigger('submit')
  
    })
  
  
  
    formulaire.on('submit', e => {
  
      e.preventDefault()
  
      effacerValidationPrecedente()
  
      if (!form.soummission.is(':disabled') && champObligatoireComplet()) {
  
        form.soummission.attr('disabled', true)
  
        const donnees = {
  
          label: form.label.val(),

  
        }
  
  
        $.ajax({
  
          url: `${BASE_URL}/organisation/insertion`,
  
          method: 'post',
  
          data: donnees,
  
          dataType: 'json',
  
          success: reponse => {
  
            if (reponse.succes) {
  
              $(document).trigger('reload-datatable')
  
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
  
        form.label,
  
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