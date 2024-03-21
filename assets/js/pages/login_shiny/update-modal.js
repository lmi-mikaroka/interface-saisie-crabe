$(() => {

    const formulaire = {
  
      corps: $('#js-formulaire-modification'),
  
      id: $('#js-formulaire-modification .js-id'),
  
      organisation: $('#js-formulaire-modification .js-organisation'),
  
      nom: $('#js-formulaire-modification .js-nom'),
  
  
      password: $('#js-formulaire-modification .js-password'),

      email: $('#js-formulaire-modification .js-email'),

      tel: $('#js-formulaire-modification .js-tel'),
  
      afficherChacherPassword: $('#js-formulaire-modification .js-afficher-cacher-password'),
  
    };
    
  
    formulaire.soumission = $('#js-enregistrer-modification');
  
    formulaire.iconeAfficherChacherPassword = formulaire.corps.parents('.modal').find('.js-enregistrer');

  
  
    formulaire.afficherChacherPassword.on('click', e => {
  
      const icone = $(e.currentTarget).find('i');
  
      if (icone.hasClass('fa-eye-slash')) icone.removeClass('fa-eye-slash').addClass('fa-eye');
  
      else icone.removeClass('fa-eye').addClass('fa-eye-slash');
  
      formulaire.password.attr('type', icone.hasClass('fa-eye-slash') ? 'password' : 'text');
  
    });
  
  
  
    formulaire.soumission.on('click', () => {
  
      console.log('clicked')
  
      formulaire.corps.trigger('submit');
  
    });
  
  
  
    formulaire.corps.on('submit', e => {
  
      e.preventDefault();
  
      $.ajax({
  
        url: `${BASE_URL}/login_shiny/modification`,
  
        method: 'post',
  
        data: donneesFormulaire(),
  
        dataType: 'json',
  
        success: reponse => {
  
          if (reponse.succes) {
  
            $(document).trigger('reload-datatable');

            $.alert({
  
                title: 'Success',
    
                content: "La modification de l\'Utilisateur a été effectuée"
    
              });
  
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
  
        nom: formulaire.nom.val(),

        email: formulaire.email.val(),

        tel: formulaire.tel.val(),
  
        password: formulaire.password.val(),
  
        organisation: formulaire.organisation.val(),
  
  
      }
  
    }
  
  })