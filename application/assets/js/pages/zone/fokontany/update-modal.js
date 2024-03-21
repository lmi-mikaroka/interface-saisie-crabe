$(() => {
  const formulaire = $('#formulaire-modification')
  const modal = $('#modal-modification')
  const form = {
    id: formulaire.find('[name=js-id]'),
    commune: formulaire.find('[name=js-commune]'),
    nom: formulaire.find('[name=js-nom]')
  }
  const soumission = $('#enregistrer-modification')

  // récupération des évènements
  soumission.on('click', e => {
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
            url: `${BASE_URL}/edition-de-zone/fokontany/mise-a-jour`,
            data: { id: form.id.val(), fokontanyNom: form.nom.val(), commune: form.commune.val() },
            type: 'post',
            dataType: 'json'
          }).done((reponse) => {
            if (!reponse.success) {
              attente.setContent('Une erreur est survenue. Veuillez reessayer ou contacter un administrateur')
              attente.setTitle('Erreur')
            } else {
              attente.onDestroy = () => {
                $(document).trigger('reload-datatable');
                modal.modal('hide')
              }
              attente.setContent('La modification du Fokontany a été effectuée')
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

  function champObligatoireOk() {
    let valide = true;
    const requireds = [
      form.commune,
      form.nom
    ];

    for (let required of requireds) {
      if (required.val() === '') {
        valide = false;
        const indicateur = required.parents('.form-group').find('.form-text')
        indicateur.text('Ce champ est obligatoire')
        indicateur.show()
        required.addClass('is-invalid')
      }
    }

    return valide;
  }

  function effacerValidationPrecedente() {
    $('.is-invalid').removeClass('is-invalid')
    $('.form-text').hide()
  }

  function initializeForm() {
    effacerValidationPrecedente()
    form.commune.val('')
    form.nom.val('')
  }

  modal.on('show.bs.modal', e => {
    initializeForm()
  })
})