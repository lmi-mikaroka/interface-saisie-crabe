$(() => {
  const formulaire = $('#js-formulaire')

  const form = {
    id: formulaire.find('[name=js-fiche]'),
    zoneCorecrabe: formulaire.find('[name=js-zone-corecrabe]'),
    village: formulaire.find('[name=js-village]'),
    annee: formulaire.find('[name=js-annee]'),
    mois: formulaire.find('[name=js-mois]'),
    numero: formulaire.find('[name=js-numero]'),
    enqueteur: formulaire.find('[name=js-enqueteur]'),
    dateExpedition: formulaire.find('[name=js-date-expedition]'),
    soumission: $('#js-bouton-enregistrer'),
  }

  //envoi du formulaire
  form.soumission.on('click', e => {
    e.preventDefault();
    formulaire.trigger('submit');
  });

  formulaire.on('submit', e => {
    e.preventDefault();
    effacerValidationPrecedente();
    const champObligatoire = champObligatoireOK(), minMax = minMaxOK()
    if (champObligatoire && minMax) {
      $.alert({
        content: function () {
          var self = this;
          return $.ajax({
            url: `${BASE_URL}/saisie-de-fiche-acheteur/modification`,
            method: 'post',
            data: chargerDonneesFormulaire(),
            dataType: 'json',
          }).done((reponse) => {
            if(!reponse.success) {
              self.setContent(reponse.raison)
              self.setTitle('Erreur')
            } else {
              self.setContent('La modification de la fiche a été effectuée')
              self.setTitle('Succès')
              setTimeout(() => {
                location.href = `${BASE_URL}/consultation-de-fiche-enqueteur.html`
              }, 1000)
            }
          }).fail(() => {
            self.setContent('Une erreur est survenue. Veuillez reessayer ou contacter un administrateur')
            self.setTitle('Erreur')
          })
        }
      })
    }
  });

  function chargerDonneesFormulaire() {
    return {
      id: form.id.val(),
      village: form.village.val(),
      enqueteur: form.enqueteur.val(),
      ficheType: 'ENQ',
      ficheAnnee: form.annee.val(),
      ficheMois: form.mois.val(),
      ficheNumeroOrdre: form.numero.val(),
      ficheExpedie: form.dateExpedition.val() != '',
      ficheDateExpedition: form.dateExpedition.val()
    }
  }

  function champObligatoireOK() {
    let valide = true;
    const requireds = [
      form.zoneCorecrabe,
      form.village,
      form.annee,
      form.numero,
      form.enqueteur,
    ]

    for (let required of requireds) {
      if (required.val() === '') {
        valide = false
        const indicateur = required.parents('.form-group').find('.form-text')
        indicateur.text('Ce champ est obligatoire')
        indicateur.show()
        required.addClass('is-invalid')
      }
    }

    return valide
  }

  function effacerValidationPrecedente() {
    $('.is-invalid').removeClass('is-invalid')
    $('.form-text').hide()
  }

  function minMaxOK() {
    let valide = true
    $('input[type=number]').each((index, elementCible) => {
      const erreurTag = $(elementCible).parents('.form-group').find('.form-text')
      if ($(elementCible).attr('min') !== 'undefined' && parseFloat($(elementCible).attr('min')) > parseFloat($(elementCible).val())) {
        valide = false
        erreurTag.text(`valeur inférieure ${$(elementCible).attr('min')}`);
        erreurTag.show()
        $(elementCible).addClass('is-invalid')
      } else if ($(elementCible).attr('max') !== 'undefined' && parseFloat($(elementCible).attr('max')) < parseFloat($(elementCible).val())) {
        valide = false
        erreurTag.text(`valeur maximale ${$(elementCible).attr('max')}`)
        erreurTag.show()
        $(elementCible).addClass('is-invalid')
      }
    });

    return valide
  }
})