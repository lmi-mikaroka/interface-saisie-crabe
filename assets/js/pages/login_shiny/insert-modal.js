$(() => {

    const modal = $('#modal-insertion')
  
    const formulaire = {
  
      corps: $('#js-formulaire-insertion'),
  
      organisation: $('#js-formulaire-insertion .js-organisation'),
  
      nom: $('#js-formulaire-insertion .js-nom'),

  
      password: $('#js-formulaire-insertion .js-password'),

      email: $('#js-formulaire-insertion .js-email'),

      tel: $('#js-formulaire-insertion .js-tel'),
  
      afficherChacherPassword: $('#js-formulaire-insertion .js-afficher-cacher-password'),
  
    };

    modal.on('show.bs.modal', () => {
  
      formulaire.organisation.val('')

      formulaire.nom.val('')

      formulaire.password.val('')

      formulaire.email.val('')

      formulaire.tel.val('')


  
  
    })
  
    formulaire.soumission = formulaire.corps.parents('.modal').find('.js-enregistrer');
  
    formulaire.iconeAfficherChacherMotDePasse = formulaire.corps.parents('.modal').find('.js-enregistrer');
  
    formulaire.afficherChacherPassword.on('click', e => {
  
      const icone = $(e.currentTarget).find('i');
  
      if (icone.hasClass('fa-eye-slash')) icone.removeClass('fa-eye-slash').addClass('fa-eye');
  
      else icone.removeClass('fa-eye').addClass('fa-eye-slash');
  
      formulaire.password.attr('type', icone.hasClass('fa-eye-slash') ? 'password' : 'text');
  
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
  
              url: `${BASE_URL}/login_shiny/insertion`,
  
              data: donneesFormulaire(),
  
              type: 'post',
  
              dataType: 'json'
  
            }).done((reponse) => {
  
              if (!reponse.succes) {
  
                attente.setContent(reponse.message)
  
                attente.setTitle('Erreur')
  
              } else {
  
                attente.onDestroy = () => {
  
                  $(document).trigger('reload-datatable');
  
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
  
        nom: formulaire.nom.val(),
  
        password: formulaire.password.val(),


        email: formulaire.email.val(),
         
        tel: formulaire.tel.val(),
  
        organisation: formulaire.organisation.val(),

  
      }
  
    }
  
  
  
    function supprimerValidation() {
  
      $('.form-text').hide();
  
      $('.is-invalid').removeClass('is-invalid');
  
    }
  
  
  
    function champObligatoireOk() {
  
      let valide = true;
  
      const requises = [
  
        formulaire.organisation,

        formulaire.email,

        formulaire.nom,
  
        formulaire.password,
  
      ]
  
  
      supprimerValidation()
  
      for (let required of requises) {
  
        if (required.val() === '' || required.val() == null) {
  
          valide = false;
  
          required.parents('.form-group').find('.form-text').text('Ce champ est obligatoire')
  
          required.parents('.form-group').find('.form-text').show();
  
          required.addClass('is-invalid');
  
        }
  
      }

      
      // if(valide){
      //   if(IsEmail(formulaire.email.val())){
      //     vali
      //   }
      // }
  
      return valide;
  
    }

    function IsEmail(email) {
      var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if(!regex.test(email)) {
        return false;
      }else{
        return true;
      }
    }
  
  })