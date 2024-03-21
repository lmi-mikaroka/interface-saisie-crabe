$(() => {
  const formulaire = $('#formulaire-modification')
  const form = {
    id: formulaire.find('[name=js-id]'),
    village: formulaire.find('[name=js-village]'),
    type: formulaire.find('[name=js-type]'),
    structure: formulaire.find('[name=js-structure]'),
    code: formulaire.find('[name=js-code]'),
    nom: formulaire.find('[name=js-nom]'),
  }

  const soumission = $('#enregistrer-modification')
  // récupération des évènements
  form.type.on('change', e => {
    const element = $(e.currentTarget);
    if (element.val() === element.find('option').first().attr('value')) {
      form.structure.parent('.form-group').show();
    } else {
      form.structure.parent('.form-group').hide();
    }
  });

  // Validation du formulaire
  soumission.on('click', e => {
    e.preventDefault();
    formulaire.trigger('submit');
  });

  formulaire.on('submit', e => {
    e.preventDefault();
    const data = {
      id: form.id.val(),
      type: form.type.val(),
      code: form.code.val(),
      nom: form.nom.val(),
      village: form.village.val()
    }
    if (!form.structure.parent('.form-group').is(':hidden')) {
      data.structure = form.structure.val();
    }
    if (champObligatoireOk()) {
      const attente = $.alert({
        useBootstrap: true,
        theme: 'bootstrap',
        animation: 'rotatex',
        closeAnimation: 'rotatex',
        animateFromElement: false,
        content: function () {
          return $.ajax({
            url: BASE_URL + '/entite/enqueteur/mise-a-jour',
            data: data,
            type: 'post',
            dataType: 'json'
          }).done((reponse) => {
            if (!reponse.success) {
              attente.setContent('Une erreur est survenue. Veuillez reessayer ou contacter un administrateur')
              attente.setTitle('Erreur')
            } else {
              attente.onDestroy = () => {
                $(document).trigger('reload-datatable');
                $('#update-modal').modal('hide');
              }
              attente.setContent('La modification de l\'Enqueteur a été effectuée')
              attente.setTitle('Succès')
            }
          }).fail(() => {
            attente.setContent('Une erreur est survenue. Veuillez reessayer ou contacter un administrateur')
            attente.setTitle('Erreur')
          })
        }
      })
    }
  });

  function supprimerValidation() {
    $('.form-text').hide();
    $('.is-invalid').removeClass('is-invalid');
  }

  function champObligatoireOk() {
    let valide = true;
    const requises = [
      form.village,
      form.code,
    ];
    if (!form.structure.parent('.form-group').is(':hidden')) {
      requises.push(form.structure);
    }
    supprimerValidation()
    for (let requis of requises) {
      if (requis.val() === '' || requis.val() == null) {
        valide = false;
        requis.parents('.form-group').find('.form-text').show();
        requis.addClass('is-invalid');
      }
    }

    return valide;
  }
})