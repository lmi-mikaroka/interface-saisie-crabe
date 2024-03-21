$(() => {
  const formulaire = {
    corps: $('#js-formulaire-modification'),
    id: $('#js-formulaire-modification .js-id'),
    groupe: $('#js-formulaire-modification .js-groupe'),
    selectionnerEnqueteur: $('#js-formulaire-modification .js-selection-enqueteur'),
    enqueteur: $('#js-formulaire-modification .js-enqueteur'),
    nomUtilisateur: $('#js-formulaire-modification .js-nom-utilisateur'),
    identifiant: $('#js-formulaire-modification .js-identifiant'),
    motDePasse: $('#js-formulaire-modification .js-mot-de-passe'),
    afficherChacherMotDePasse: $('#js-formulaire-modification .js-afficher-cacher-mot-de-passe'),
  };
  formulaire.soumission = $('#js-enregistrer-modification');
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
    console.log('clicked')
    formulaire.corps.trigger('submit');
  });

  formulaire.corps.on('submit', e => {
    e.preventDefault();
    $.ajax({
      url: `${BASE_URL}/utilisateur/nouvel-utilisateur/modification`,
      method: 'post',
      data: donneesFormulaire(),
      dataType: 'json',
      success: reponse => {
        if (reponse.succes) {
          $(document).trigger('recharger-datatable');
          $('#modal-modification').modal('hide');
        } else {
          $.alert({
            title: 'Erreur du traitement',
            content: reponse.message
          });
        }

      },
      error: (arg1, arg2, arg3) => {
        console.log(arg1, arg2, arg3);
      },
    });
  });

  function donneesFormulaire() {
    return {
      id: formulaire.id.val(),
      nomUtilisateur: formulaire.nomUtilisateur.val(),
      motDePasse: formulaire.motDePasse.val(),
      identifiant: formulaire.identifiant.val(),
      groupe: formulaire.groupe.val(),
      enqueteur: formulaire.selectionnerEnqueteur.is(':checked'),
    }
  }
})