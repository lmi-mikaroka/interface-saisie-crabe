$(() => {
  const formulaire = {
    corps: $('#js-formulaire'),
    identifiant: $('#js-identifiant'),
    motDePasse: $('#js-mot-de-passe'),
    seSouvenirDeMoi: $('#js-se-souvenir-de-moi'),
  };

  formulaire.corps.on('submit', e => {
    e.preventDefault();
    $.ajax({
      url: `${BASE_URL}/connexion/verification`,
      method: 'post',
      dataType: 'json',
      data: genererDonneeVerification(),
      success: reponse => {
        if(!reponse.autorise) {
          $.alert({
            title: 'Erreur de conneexion',
            content: reponse.message,
          });
        } else {
          location.reload()
          // location.href = `${BASE_URL}/edition-de-zone/zone-corecrabe.html`
        }
      },
      error: (arg1, arg2, arg3) => {
        console.log(arg1, arg2, arg3);
      }
    });
  });

  function genererDonneeVerification() {
    return {
      identifiant: formulaire.identifiant.val(),
      motDePasse: formulaire.motDePasse.val()
    };
  }
});