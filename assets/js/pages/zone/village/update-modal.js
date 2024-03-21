$(() => {
  const formulaire = $('#formulaire-modification')
  const modal = $('#modal-modification')
  const form = {
    id: formulaire.find('[name=js-id]'),
    fokontany: formulaire.find('[name=js-fokontany]'),
    nom: formulaire.find('[name=js-nom]'),
    longitude : formulaire.find('[name=js-longitude]'),
    latitude : formulaire.find('[name=js-latitude]'),
    sous_zone : formulaire.find('[name=js-sous-zone]'),
  }
  const soumission = $('#enregistrer-modification')

  // récupération des évènements
  soumission.on('click', e => {
    e.preventDefault()
    formulaire.trigger('submit')
  })

  formulaire.on('submit', e => {
    e.preventDefault()
    var longitude = null;
    var latitude = null;
    if(form.longitude.val() !=''){
      longitude = form.longitude.val(); 
    }
    if(form.latitude.val() !=''){
      latitude = form.latitude.val(); 
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
            url: `${BASE_URL}/edition-de-zone/village/mise-a-jour`,
            data: { id: form.id.val(), villageNom: form.nom.val(), fokontany: form.fokontany.val(),sous_zone:form.sous_zone.val(),longitude:longitude,latitude:latitude },
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
              attente.setContent('La modification du Village a été effectuée')
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
      form.fokontany,
      form.nom,
      form.sous_zone
    ];

    for (let required of requireds) {
      if (required.val() === '') {
        valide = false;
        const indicateur = required.parents('.form-group').find('.form-text');
        indicateur.text('Ce champ est obligatoire');
        indicateur.show();
        required.addClass('is-invalid');
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
    form.fokontany.val('')
    form.nom.val('')
  }

  modal.on('show.bs.modal', e => {
    initializeForm()
  })
})