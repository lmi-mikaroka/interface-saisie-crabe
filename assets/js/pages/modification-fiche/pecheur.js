$(() => {
  const form = {
    corps: $('#js-formulaire'),
    enquete: $('[name=js-enquete]'),
    fiche: $('[name=js-fiche]'),
    jour: $('[name=js-jour]'),
    date: $('[name=js-date]'),
    pecheur: {
      partenaire: $('[name=js-pecheur-partenaire]'),
      nombre: $('[name=js-pecheur-nombre]')
    },
    pirogue: $('[name=js-pirogue]'),
    engins: [
      {
        nom: $('[name=js-engin-de-peche-nom1]'),
        nombre: $('[name=js-engin-de-peche-nombre1]')
      },
      {
        nom: $('[name=js-engin-de-peche-nom2]'),
        nombre: $('[name=js-engin-de-peche-nombre2]')
      }
    ],
    consommationCrabe: {
      poids: $('[name=js-consommation-crabe-poids]'),
      nombre: $('[name=js-consommation-crabe-nombre]')
    },
    venteCrabe: {
      collecte: {
        poids: $('[name=js-collecte-poids]'),
        prix: $('[name=js-collecte-prix]')
      },
      marcheLocal: {
        poids: $('[name=js-marche-local-poids]'),
        prix: $('[name=js-marche-local-prix]')
      },
    }
  };

  const boutons = {
    enregistrerEtListe: $('#js-bouton-enregistrer'),
  }

  form.jour.on('change', () => {
    const valeurDate = form.date.val();
    form.date.val(`${valeurDate.toString().substr(0, 8)}${('0' + form.jour.val()).substr(-2)}`);
    form.date.trigger('change');
  });

  form.pecheur.partenaire.on('change', () => {
    const possibilites = [
      {valeur: 'seul', min: 1, max: 1, lectureSeul: true},
      {valeur: 'partenaire', min: 2, max: 2, lectureSeul: true},
      {valeur: 'enfant', min: 2, max: 6, lectureSeul: false},
      {valeur: 'amis', min: 2, max: 11, lectureSeul: false},
    ];

    const valeurChamp = form.pecheur.partenaire.val();
    
    possibilites.forEach(possibilite => {
      if(valeurChamp === possibilite.valeur) {
        form.pecheur.nombre.val(possibilite.min);
        form.pecheur.nombre.attr('min', possibilite.min);
        form.pecheur.nombre.attr('max', possibilite.max);
        if(possibilite.lectureSeul) form.pecheur.nombre.attr('readonly', true);
        else form.pecheur.nombre.removeAttr('readonly');
      }
    });
  });

  form.engins.forEach((engin, ceci) => {
    const autre = (ceci + 1) % form.engins.length;

    engin.nom.on('change', () => {
      const matchEngin = ENGINS.find(enginPredicate => enginPredicate.id === parseInt(engin.nom.val()))
      engin.nombre.attr('min', matchEngin.min);
      engin.nombre.attr('max', matchEngin.max);
      engin.nombre.val(matchEngin.min === matchEngin.max ? matchEngin.min : (parseInt(engin.nombre.val()) > matchEngin.max || parseInt(engin.nombre.val()) < matchEngin.min ? matchEngin.min : parseInt(engin.nombre.val())));
      engin.nombre.attr('readonly', matchEngin.min === matchEngin.max);
      form.engins[ceci].nom.find('option').removeAttr('hidden');
      form.engins[autre].nom.find('option').removeAttr('hidden');
  
      form.engins[ceci].nom.find(`option[value="${form.engins[ceci].nom.val()}"]`).attr('hidden', true);
      form.engins[ceci].nom.find(`option[value="${form.engins[autre].nom.val()}"]`).attr('hidden', true);
      form.engins[autre].nom.find(`option[value="${form.engins[ceci].nom.val()}"]`).attr('hidden', true);
      form.engins[autre].nom.find(`option[value="${form.engins[autre].nom.val()}"]`).attr('hidden', true);
  
      form.engins[ceci].nom.find('option').first().removeAttr('hidden');
      form.engins[autre].nom.find('option').first().removeAttr('hidden');
    });
  });

  boutons.enregistrerEtListe.on('click', e => {
    e.preventDefault();
    effacerValidationPrecedente();
    enregistrerFormulaire().then(reponse => {
      $.alert('L\'insertion du formulaire est un succès');
      setTimeout(() => location.href = `${BASE_URL}/consultation-de-fiche-pecheur/detail-et-action/${form.fiche.val()}.html`, 1000);
    }).finally(() => {boutons.enregistrerEtListe.removeAttr('disabled');});
  });

  function enregistrerFormulaire() {
    return new Promise((resolve, reject) => {
      const champMinMaxOk = champNombreRespecteMinMax()
      const champObligatoireOk = champObligatoireComplet()
      const formulaireValide = champMinMaxOk && champObligatoireOk;
      if (!boutons.enregistrerEtListe.is(':disabled') && formulaireValide) {
        $('.js-formulaire-card .js-alerte-information-incorrecte').slideUp(100);
        boutons.enregistrerEtListe.attr('disabled', true);
        $.ajax({
          url: `${BASE_URL}/modification-de-fiche-pecheur/enregistrer`,
          method: 'post',
          data: mettreAJourLesDonneesDePost(),
          dataType: 'json',
          success: reponse => {
            resolve(reponse);
          },
          error: (arg1, arg2, arg3) => {
            reject([arg1, arg2, arg3]);
          }
        });
      } else {
        $('.js-formulaire-card .js-alerte-information-incorrecte').slideDown(100);
      }
    });
  }

  function champNombreRespecteMinMax() {
    let valide = true;
    $('input[type=number]').each((index, elementCible) => {
      const erreurTag = $(elementCible).parents('.form-group').find('.form-text');
      if ($(elementCible).attr('min') !== 'undefined' && parseFloat($(elementCible).attr('min')) > parseFloat($(elementCible).val())) {
        valide = false;
        erreurTag.text(`valeur inférieure ${$(elementCible).attr('min')}`);
        erreurTag.show();
        $(elementCible).addClass('is-invalid');
      } else if ($(elementCible).attr('max') !== 'undefined' && parseFloat($(elementCible).attr('max')) < parseFloat($(elementCible).val())) {
        valide = false;
        erreurTag.text(`valeur maximale ${$(elementCible).attr('max')}`);
        erreurTag.show();
        $(elementCible).addClass('is-invalid');
      }
    });

    return valide;
  }

  function champObligatoireComplet() {
    let valide = true;
    const erreurs = [];
    const requises = [
      form.date,
      form.pecheur.partenaire,
      form.pecheur.nombre,
      form.consommationCrabe.poids,
      form.consommationCrabe.nombre,
      form.venteCrabe.collecte.poids,
      form.venteCrabe.collecte.prix,
      form.venteCrabe.marcheLocal.poids,
      form.venteCrabe.marcheLocal.prix,
    ];

    form.engins.forEach(engin => {
      requises.push(engin.nom, engin.nombre);
    });

    let chaineErreur = '';
    for (let erreur of erreurs) {
      chaineErreur += `<li>${erreur}</li>`;
    }

    $('.js-formulaire-card .js-alerte-information-incorrecte-conteneur').html(chaineErreur);
    if (erreurs.length == 0) {
      $('.js-formulaire-card .js-alerte-information-incorrecte').slideUp(100);
    }

    for (let requis of requises) {
      if (requis.val() === '') {
        valide = false;
        requis.parents('.form-group').find('.form-text').text('Ce champ est obligatoire');
        requis.parents('.form-group').find('.form-text').show();
        requis.addClass('is-invalid');
      }
    }

    return valide;
  }

  function effacerValidationPrecedente() {
    $('.is-invalid').removeClass('is-invalid');
    $('.form-text').hide();
  }

  function mettreAJourLesDonneesDePost() {
    return {
      enquete: form.enquete.val(),
      date: form.date.val(),
      pecheur: {
        partenaire: form.pecheur.partenaire.val(),
        nombre: form.pecheur.nombre.val(),
      },
      consommationCrabe: {
        poids: form.consommationCrabe.poids.val(),
        nombre: form.consommationCrabe.nombre.val()
      },
      crabeVendu: {
        collecte: {
          poids: form.venteCrabe.collecte.poids.val(),
          prix: form.venteCrabe.collecte.prix.val()
        },
        marcheLocal: {
          poids: form.venteCrabe.marcheLocal.poids.val(),
          prix: form.venteCrabe.marcheLocal.prix.val()
        }
      },
      engins: [
        {
          nom: form.engins[0].nom.val(),
          nombre: form.engins[0].nombre.val(),
        },
        {
          nom: form.engins[1].nom.val(),
          nombre: form.engins[1].nombre.val(),
        }
      ],
      avecPirogue: form.pirogue.is(':checked') ? 1 : 0
    };
  }
})