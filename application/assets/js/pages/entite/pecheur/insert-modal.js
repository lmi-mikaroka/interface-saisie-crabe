$(() => {
  const lien = ''
  const formulaire = $('#formulaire-insertion')
  const ajouterPecheur = $('#js-ajouter-pecheur')
  const supprimerPecheur = $('#js-supprimer-pecheur')
  const noms = $('#js-noms-insertion')
  const enregistrerInsertion = $('#enregistrer-insertion')
  const modal = $('#insert-modal')

  const form = {
    village: formulaire.find('[name=js-village]'),
    noms: []
  };

  ajouterPecheur.on('click', () => {
    anciennesValeurs = []
    noms.find('.form-control').each((indexe, elementCilble) => {
      anciennesValeurs.push($(elementCilble).val())
    })
    nouveauHtml = ''
    for(let iteration = 0; iteration < anciennesValeurs.length + 1; iteration++) {
      nouveauHtml += genererTemplate(iteration)
    }
    noms.html(nouveauHtml)
    for(let iteration = 0; iteration < anciennesValeurs.length; iteration++) {
      noms.find('.form-control').eq(iteration).val(anciennesValeurs[iteration])
    }
    chargerChampNoms()
  })

  supprimerPecheur.on('click', () => {
    anciennesValeurs = []
    noms.find('.form-control').each((indexe, elementCilble) => {
      anciennesValeurs.push($(elementCilble).val())
    })
    nouveauHtml = genererTemplate()
    for(let iteration = 1; iteration < anciennesValeurs.length - 1; iteration++) {
      nouveauHtml += genererTemplate(iteration)
    }
    noms.html(nouveauHtml)
    for(let iteration = 0; iteration < anciennesValeurs.length; iteration++) {
      noms.find('.form-control').eq(iteration).val(anciennesValeurs[iteration])
    }
    chargerChampNoms()
  })

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
            url: `${BASE_URL}/entite/pecheur/insertion`,
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
              attente.setContent('L\'insertion du(es) Pêcheur(s) a été effectuée')
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
      form.village,
    ]
    requises = requises.concat(form.noms)
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
      village: form.village.val(),
      noms: []
    }
    form.noms.forEach(nom => donnee.noms.push(nom.val()))
    return donnee
  }
  function chargerChampNoms() {
    form.noms = []
    noms.find('.form-control').each((indexe, elementCible) => {
      form.noms.push($(elementCible))
    })
  }

  function genererTemplate(ordre) {
    return `<div class="form-group">
              <input type="text" class="form-control" name="js-nom${typeof ordre === 'undefined' ? 0 : ordre}" maxlength="100">
              <span class="form-text text-red" style="display: none;">Ce champ est obligatoire</span>
            </div>`
  }

  function initialiserFormulaire() {
    form.village.val('')
    noms.html(genererTemplate())
    chargerChampNoms()
    supprimerValidation()
  }

  chargerChampNoms()

  modal.on('show.bs.modal', e => {
    initialiserFormulaire();
  });
})