$(() => {
  const modal = $('#modal-insertion')
  const formulaire = {
    corps: $('#js-formulaire-insertion'),
    groupe: $('#js-formulaire-insertion .js-groupe'),
    selectionnerEnqueteur: $('#js-formulaire-insertion .js-selection-enqueteur'),
    enqueteur: $('#js-formulaire-insertion .js-enqueteur'),
    nomUtilisateur: $('#js-formulaire-insertion .js-nom-utilisateur'),
    identifiant: $('#js-formulaire-insertion .js-identifiant'),
    motDePasse: $('#js-formulaire-insertion .js-mot-de-passe'),
    afficherChacherMotDePasse: $('#js-formulaire-insertion .js-afficher-cacher-mot-de-passe'),
  };
  formulaire.soumission = formulaire.corps.parents('.modal').find('.js-enregistrer');
  formulaire.iconeAfficherChacherMotDePasse = formulaire.corps.parents('.modal').find('.js-enregistrer');

  formulaire.groupe.on('change', e => {
    if (formulaire.groupe.val() !== '3') formulaire.selectionnerEnqueteur.parents('.icheck-warning').hide();
    else formulaire.selectionnerEnqueteur.parents('.icheck-warning').show();
    formulaire.selectionnerEnqueteur.prop('checked', false);
    formulaire.selectionnerEnqueteur.trigger('change');
  });

  formulaire.selectionnerEnqueteur.on('change', e => {
    if ($(e.currentTarget).is(':checked')) {
      formulaire.enqueteur.parents('.form-group').show();
      formulaire.nomUtilisateur.parents('.form-group').hide();
    } else {
      formulaire.enqueteur.parents('.form-group').hide();
      formulaire.nomUtilisateur.parents('.form-group').show();
    }
    formulaire.enqueteur.val('');
    formulaire.nomUtilisateur.val('');
  });

  formulaire.enqueteur.on('change', e => {
    formulaire.nomUtilisateur.val($(e.currentTarget).val());
  });

  formulaire.afficherChacherMotDePasse.on('click', e => {
    const icone = $(e.currentTarget).find('i');
    if (icone.hasClass('fa-eye-slash')) icone.removeClass('fa-eye-slash').addClass('fa-eye');
    else icone.removeClass('fa-eye').addClass('fa-eye-slash');
    formulaire.motDePasse.attr('type', icone.hasClass('fa-eye-slash') ? 'password' : 'text');
  });

  formulaire.soumission.on('click', () => {
    console.log('submit')
    formulaire.corps.trigger('submit');
  });

  formulaire.corps.on('submit', e => {
    e.preventDefault();
    console.log('submitting')
    if (champObligatoireOk()) {
      console.log('sending')
      const attente = $.alert({
        useBootstrap: true,
        theme: 'bootstrap',
        animation: 'rotatex',
        closeAnimation: 'rotatex',
        animateFromElement: false,
        content: function () {
          return $.ajax({
            url: `${BASE_URL}/utilisateur/nouvel-utilisateur/insertion`,
            data: donneesFormulaire(),
            type: 'post',
            dataType: 'json'
          }).done((reponse) => {
            if (!reponse.succes) {
              attente.setContent('Une erreur est survenue. Veuillez reessayer ou contacter un administrateur')
              attente.setTitle('Erreur')
            } else {
              attente.onDestroy = () => {
                $(document).trigger('recharger-datatable');
                modal.modal('hide');
              }
              attente.setContent('L\'insertion de l\'Utilisateur a été effectuée')
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

  function donneesFormulaire() {
    return {
      nomUtilisateur: formulaire.nomUtilisateur.val(),
      motDePasse: formulaire.motDePasse.val(),
      identifiant: formulaire.identifiant.val(),
      groupe: formulaire.groupe.val(),
      enqueteur: formulaire.selectionnerEnqueteur.is(':checked')
    }
  }

  function supprimerValidation() {
    $('.form-text').hide();
    $('.is-invalid').removeClass('is-invalid');
  }

  function champObligatoireOk() {
    let valide = true;
    const requises = [
      formulaire.groupe,
      formulaire.identifiant,
      formulaire.motDePasse,
    ]
    if (formulaire.selectionnerEnqueteur.is(':checked')) {
      requises.push(formulaire.enqueteur)
    } else {
      requises.push(formulaire.nomUtilisateur)
    }
    console.log(requises)
    supprimerValidation()
    for (let required of requises) {
      if (required.val() === '' || required.val() == null) {
        valide = false;
        required.parents('.form-group').find('.form-text').text('Ce champ est obligatoire')
        required.parents('.form-group').find('.form-text').show();
        required.addClass('is-invalid');
      }
    }
    return valide;
  }
})