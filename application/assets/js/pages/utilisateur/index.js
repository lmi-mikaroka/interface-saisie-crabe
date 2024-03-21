$(() => {
  const formulaireInsertion = {
    corps: $('#js-formulaire-insertion'),
    groupe: $('#js-formulaire-insertion .js-groupe'),
    selectionnerEnqueteur: $('#js-formulaire-insertion .js-selection-enqueteur'),
    enqueteur: $('#js-formulaire-insertion .js-enqueteur'),
    nomUtilisateur: $('#js-formulaire-insertion .js-nom-utilisateur'),
    identifiant: $('#js-formulaire-insertion .js-identifiant'),
    motDePasse: $('#js-formulaire-insertion .js-mot-de-passe'),
    afficherChacherMotDePasse: $('#js-formulaire-insertion .js-afficher-cacher-mot-de-passe'),
  };
  formulaireInsertion.soumission = formulaireInsertion.corps.parents('.modal').find('.js-enregistrer');
  formulaireInsertion.iconeAfficherChacherMotDePasse = formulaireInsertion.corps.parents('.modal').find('.js-enregistrer');

  const formulaireModification = {
    id: $('#js-formulaire-modification .js-id'),
    corps: $('#js-formulaire-modification'),
    groupe: $('#js-formulaire-modification .js-groupe'),
    selectionnerEnqueteur: $('#js-formulaire-modification .js-selection-enqueteur'),
    enqueteur: $('#js-formulaire-modification .js-enqueteur'),
    nomUtilisateur: $('#js-formulaire-modification .js-nom-utilisateur'),
    identifiant: $('#js-formulaire-modification .js-identifiant'),
    motDePasse: $('#js-formulaire-modification .js-mot-de-passe'),
    afficherChacherMotDePasse: $('#js-formulaire-modification .js-afficher-cacher-mot-de-passe'),
  };
  formulaireModification.soumission = formulaireModification.corps.parents('.modal').find('.js-enregistrer');
  formulaireModification.iconeAfficherChacherMotDePasse = formulaireModification.corps.parents('.modal').find('.js-enregistrer');

  var datatable = $('#datatable').DataTable({
    language: {url: BASE_URL + '/assets/datatable-fr.json'},
    processing: true,
    serverSide: true,
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: true,
    responsive: true,
    columnDefs: [{
      targets: [-1],
      orderable: false,
      className: ''
    }],
    order: [[0, 'asc']],
    ajax: {
      url: BASE_URL + '/utilisateur/datatable',
      method: 'post',
    },
  });

  $(document).on('recharger-datatable', () => {
    datatable.ajax.reload();
  });

  $(document).on('click', '.delete-button', e => {
    var information = $(e.currentTarget).attr('data-target');
    jConfirmRed('Supprimer la sélection', 'La suppression pourra entraîner la perte d\'autres données relatives à celle-ci.\nVeuillez confirmer la suppression', () => {
      $.ajax({
        url: BASE_URL + '/utilisateur/nouvel-utilisateur/suppression/' + information,
        method: 'get',
        dataType: 'json',
        success: () => {
          $(document).trigger('recharger-datatable');
          $.alert('L\'utilisateur a été supprimé avec succès');
        }
      });
    });
  });

  $(document).on('click', '[data-target="#modal-modification"]', e => {
    let id = $(e.currentTarget).attr('id');
    id = id.substring(7, id.length);
    while (formulaireInsertion.enqueteur.find('option').length) {
      formulaireInsertion.enqueteur.find('option').eq(0).remove();
    }
    const chargeurInformationModification = $('#chargeur-information-modification')
    const modal = $('#modal-modification')
    const formulaire = $('#js-formulaire-modification')
    const boutonEnregisrer = $('#js-enregistrer-modification')
    formulaire.hide()
    chargeurInformationModification.show()
    boutonEnregisrer.attr('disabled', true)
    modal.modal('show')

    // Rafrachir le champ nom utilisateur
    $.ajax({
      url: `${BASE_URL}/entite/enqueteur/liste_non_utilisateur`,
      method: 'get',
      dataType: 'json',
      success: enqueteurs => {
        let options = '<option value="" selected hidden></option>';
        for (let enqueteur of enqueteurs) {
          options += `<option value="${enqueteur['id']}">${enqueteur['code']} - ${enqueteur['nom']}</option>`
        }

        // Sélection des informations à modifier
        $.ajax({
          url: `${BASE_URL}/utilisateur/nouvel-utilisateur/selectionner/${id}`,
          method: 'get',
          dataType: 'json',
          success: reponse => {
            const utilisateur = reponse.utilisateur;
            const enqueteurReponse = reponse.enqueteur;
            initialiserFormulaire(formulaireModification);
            formulaireModification.id.val(id);
            formulaireModification.enqueteur.html(options);
            formulaireModification.groupe.val(utilisateur.groupe).trigger('change');
            if (enqueteurReponse.length !== 0) {
              formulaireModification.selectionnerEnqueteur.prop('checked', true);
              formulaireModification.selectionnerEnqueteur.trigger('change');
              options += `<option value="${enqueteurReponse[0]['id']}">${enqueteurReponse[0]['code']} - ${enqueteurReponse[0]['nom']}</option>`;
              formulaireModification.enqueteur.html(options);
              formulaireModification.enqueteur.val(enqueteurReponse[0].id);
            }
            formulaireModification.nomUtilisateur.val(utilisateur['nom_utilisateur']);
            formulaireModification.identifiant.val(utilisateur.identifiant);
            formulaire.show()
            chargeurInformationModification.hide()
            boutonEnregisrer.removeAttr('disabled')
          }
        })
      },
      error: (arg0, arg1, arg2) => {
        console.error(arg0, arg1, arg2);
      }
    })
    rafraichirChampNonUtilisateur().then(enqueteurs => {
      let options = '<option value="" selected hidden></option>';
      for (let enqueteur of enqueteurs) {
        options += `<option value="${enqueteur['id']}">${enqueteur['code']} - ${enqueteur['nom']}</option>`;
      }
      $.ajax({
        url: `${BASE_URL}/utilisateur/nouvel-utilisateur/selectionner/${id}`,
        method: 'get',
        dataType: 'json',
        success: reponse => {
          const utilisateur = reponse.utilisateur;
          const enqueteurReponse = reponse.enqueteur;
          initialiserFormulaire(formulaireModification);
          formulaireModification.id.val(id);
          formulaireModification.enqueteur.html(options);
          formulaireModification.groupe.val(utilisateur.groupe).trigger('change');
          if (enqueteurReponse.length !== 0) {
            formulaireModification.selectionnerEnqueteur.prop('checked', true);
            formulaireModification.selectionnerEnqueteur.trigger('change');
            options += `<option value="${enqueteurReponse[0]['id']}">${enqueteurReponse[0]['code']} - ${enqueteurReponse[0]['nom']}</option>`;
            formulaireModification.enqueteur.html(options);
            formulaireModification.enqueteur.val(enqueteurReponse[0].id);
          }
          formulaireModification.nomUtilisateur.val(utilisateur['nom_utilisateur']);
          formulaireModification.identifiant.val(utilisateur.identifiant);
        }
      });
    });
  });

  $('[data-target="#modal-insertion"]').on('click', () => {
    initialiserFormulaire(formulaireInsertion)
  })

  function initialiserFormulaire(formulaire) {
    formulaire.corps.trigger('reset');
    formulaire.motDePasse.attr('type', 'text');
    formulaire.afficherChacherMotDePasse.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    formulaire.enqueteur.parents('.form-group').hide();
    formulaire.nomUtilisateur.parents('.form-group').show();
    formulaire.selectionnerEnqueteur.parents('.icheck-warning').hide();
    formulaire.selectionnerEnqueteur.prop('checked', false);
    formulaire.selectionnerEnqueteur.trigger('change');
  }

  function rafraichirChampNonUtilisateur() {
    return new Promise(resolve => {
      $.ajax({
        method: 'get',
        url: `${BASE_URL}/entite/enqueteur/liste_non_utilisateur`,
        dataType: 'json',
        success: reponse => resolve(reponse)
      })
    });
  }


})