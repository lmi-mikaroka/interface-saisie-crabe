$(() => {

    const formulaireModification = {

        id: $('#js-formulaire-modification .js-id'),
    
        corps: $('#js-formulaire-modification'),
    
         organisation: $('#js-formulaire-modification .js-organisation'),
    
        nom: $('#js-formulaire-modification .js-nom'),
    
        user: $('#js-formulaire-modification .js-user'),
    
        password: $('#js-formulaire-modification .js-password'),

        email: $('#js-formulaire-modification .js-email'),

        tel: $('#js-formulaire-modification .js-tel'),
    
        afficherChacherPassword: $('#js-formulaire-modification .js-afficher-cacher-password'),
    
      };

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
  
        url: BASE_URL + '/login_shiny/datatable',
  
        method: 'post',
  
      },
  
    });
  
  
  
    // Evènement au rechergement de la datatable
  
    $(document).on('reload-datatable', () => {
  
      datatable.ajax.reload();
  
    });
  
  
  
    $(document).on('click', '.delete-button', e => {
  
      var information = $(e.currentTarget).attr('data-target');
  
      jConfirmRed('Supprimer la sélection', 'La suppression pourra entraîner la perte d\'autres données relatives à celle-ci.\nVeuillez confirmer la suppression', () => {
  
        $.ajax({
  
          url: BASE_URL + '/login_shiny/suppression/' + information,
  
          method: 'get',
  
          dataType: 'json',
  
          success: () => {
  
            $(document).trigger('reload-datatable');
  
            $.alert('L\'organisation a été supprimé avec succès');
  
          }
  
        });
  
      });
  
    });



  
  
  
    $(document).on('click', '[data-target="#modal-modification"]', e => {

        let id = $(e.currentTarget).attr('id');
    
        id = id.substring(7, id.length);
    
        const chargeurInformationModification = $('#chargeur-information-modification')
    
        const modal = $('#modal-modification')
    
        const formulaire = $('#js-formulaire-modification')
    
        const boutonEnregisrer = $('#js-enregistrer-modification')
    
        formulaire.hide()
    
        chargeurInformationModification.show()
    
        boutonEnregisrer.attr('disabled', true)
    
        modal.modal('show')
    
    
    
        $.ajax({
    
            url: `${BASE_URL}/login_shiny/selection/${id}`,
  
            method: 'get',
  
            dataType: 'json',
  
            success: reponse => {
  
  
  
              initialiserFormulaire(formulaireModification);
  
              formulaireModification.id.val(id);
  
  
              formulaireModification.organisation.val(reponse.organisation).trigger('change');
  
              formulaireModification.nom.val(reponse.nom);
  
              formulaireModification.user.val(reponse.user);

              formulaireModification.email.val(reponse.email);

              formulaireModification.tel.val(reponse.tel);
  
              formulaire.show()
  
              chargeurInformationModification.hide()
  
              boutonEnregisrer.removeAttr('disabled')
  
            }
  
          })
    
        // rafraichirChampNonUtilisateur().then(enqueteurs => {
    
        //   let options = '<option value="" selected hidden></option>';
    
        //   for (let enqueteur of enqueteurs) {
    
        //     options += `<option value="${enqueteur['id']}">${enqueteur['code']} - ${enqueteur['nom']}</option>`;
    
        //   }
    
        //   $.ajax({
    
        //     url: `${BASE_URL}/utilisateur/nouvel-utilisateur/selectionner/${id}`,
    
        //     method: 'get',
    
        //     dataType: 'json',
    
        //     success: reponse => {
    
        //       const utilisateur = reponse.utilisateur;
    
        //       const enqueteurReponse = reponse.enqueteur;
    
        //       initialiserFormulaire(formulaireModification);
    
        //       formulaireModification.id.val(id);
    
        //       formulaireModification.enqueteur.html(options);
    
        //       formulaireModification.groupe.val(utilisateur.groupe).trigger('change');
    
        //       if (enqueteurReponse.length !== 0) {
    
        //         formulaireModification.selectionnerEnqueteur.prop('checked', true);
    
        //         formulaireModification.selectionnerEnqueteur.trigger('change');
    
        //         options += `<option value="${enqueteurReponse[0]['id']}">${enqueteurReponse[0]['code']} - ${enqueteurReponse[0]['nom']}</option>`;
    
        //         formulaireModification.enqueteur.html(options);
    
        //         formulaireModification.enqueteur.val(enqueteurReponse[0].id);
    
        //       }
    
        //       formulaireModification.nomUtilisateur.val(utilisateur['nom_utilisateur']);
    
        //       formulaireModification.identifiant.val(utilisateur.identifiant);
    
        //     }
    
        //   });
    
        // });
    
      });
  
  
  
    function supprimerValidation() {
  
      $('.form-text').hide();
  
      $('.is-invalid').removeClass('is-invalid');
  
    }

    function initialiserFormulaire(formulaire) {

      formulaire.corps.trigger('reset');
  
      formulaire.password.attr('type', 'text');
  
      formulaire.afficherChacherPassword.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
  
  
      formulaire.nom.parents('.form-group').show();
      formulaire.user.parents('.form-group').show();
      formulaire.email.parents('.form-group').show();
      formulaire.tel.parents('.form-group').show();
  
    }
  
  })