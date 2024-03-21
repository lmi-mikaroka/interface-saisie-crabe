$(() => {
  const SORTIE_MAXIMALE = 4
  const form = {
    corps: $('.js-formulaire'),
    fiche: $('[name=js-id-fiche]'),
    jour: $('[name=js-jour]'),
    date: $('[name=js-date]'),
    pecheur: $('[name=js-pecheur]'),
    nombrePecheur: $('[name=js-nombre-pecheur]'),
    derniereSortieDePeches: [],
    nombreSortieVente: $('[name=js-nombre-sortie-vente]'),
    venteCrabe: {
      collecte: [
        {
          poids: $('[name=js-collecte-poids1]'),
          prix: $('[name=js-collecte-prix1]')
        },
        {
          poids: $('[name=js-collecte-poids2]'),
          prix: $('[name=js-collecte-prix2]')
        }
      ],
      marcheLocal: {
        poids: $('[name=js-marche-local-poids]'),
        prix: $('[name=js-marche-local-prix]')
      },
    },
    crabeNonVendu: {
      poids: $('[name=js-poids-de-crabe-non-vendu]'),
      nombre: $('[name=js-nombre-de-crabe-non-vendu]')
    }
  }

  for (let indexe = 0; indexe < 4; indexe++) {
    form.derniereSortieDePeches.push({
      nombre: $(`[name=js-derniere-sortie-de-peche-nombre${indexe}]`),
      pirogue: $(`[name=js-derniere-sortie-de-peche-pirogue${indexe}]`),
      engins: [
        {
          nom: $(`[name=js-derniere-sortie-de-peche-premier-engin-nom${indexe}]`),
          nombre: $(`[name=js-derniere-sortie-de-peche-premier-engin-nombre${indexe}]`),
        },
        {
          nom: $(`[name=js-derniere-sortie-de-peche-deuxieme-engin-nom${indexe}]`),
          nombre: $(`[name=js-derniere-sortie-de-peche-deuxieme-engin-nombre${indexe}]`),
        },
      ],
    });
  }

  const prixMarcheLocalObligatoire = $('#js-marche-local-prix-obligatoire')

  /*
  *
  * Initiation de données réçues et à envoyer
  *
  */

  form.jour.on('change', () => {
    const valeurDate = form.date.val();
    form.date.val(`${valeurDate.toString().substr(0, 8)}${('0' + form.jour.val()).substr(-2)}`)
    form.date.trigger('change')
  });

  // Détecter le changement de la date
  form.date.on('change', e => {
    const timestamp = new Date(e.currentTarget.value).getTime();
    const nominationParDefaut = ['Aujourd\'hui', 'Hier', 'Avant-hier', 'Avant-avant-hier'];
    const heuresJour = 1000 * 60 * 60 * 24;
    const dates = [];
    for (let indexe = 0; indexe < 4; indexe++) dates.push(new Date(timestamp - heuresJour * indexe));

    if (e.currentTarget.value === '') {
      // Changer l'affichage des dates dans le dernier jours de pêche
      form.corps.find('.js-date-literalle').each((index, element) => {
        $(element).text(nominationParDefaut[index]);
      });
    } else {
      // Changer l'affichage des dates dans le dernier jours de pêche
      form.corps.find('.js-date-literalle').each((index, element) => {
        $(element).text(dates[index].toLocaleDateString());
      });

      // Changer l'affichage des dates dans de dernier vente de crabe
      form.corps.find('.js-jours-vente-de-crabe').each((index, element) => {
        $(element).text(dates[index].toLocaleDateString());
      });
    }
  });

  // Suivi de changement de nombre de sortie pour voir si les champs doivent être reinitilaisés ou pas
  for (let indexe = 0; indexe < 4; indexe++) {
    form.derniereSortieDePeches[indexe].nombre.on('change', evenement => {
      const valeur = parseInt($(evenement.currentTarget).val());
      const balises = [
        $(evenement.currentTarget),
        form.derniereSortieDePeches[indexe].engins[0].nom,
        form.derniereSortieDePeches[indexe].engins[0].nombre,
        form.derniereSortieDePeches[indexe].engins[1].nom,
        form.derniereSortieDePeches[indexe].engins[1].nombre
      ];

      if (balises[0].is(':checked') && valeur === 0) {
        balises[1].val(balises[1].find('option').first().attr('value'));
        balises[1].find('option').attr('hidden', true);

        balises[3].val(balises[3].find('option').first().attr('value'));
        balises[3].find('option').attr('hidden', true);
      } else {
        balises[1].find('option').removeAttr('hidden');
        balises[3].find('option').removeAttr('hidden');
      }
      balises[1].attr('max', valeur);
      balises[1].trigger('blur');
      balises[1].trigger('change');
      balises[3].trigger('change');
    });
  }

  form.derniereSortieDePeches.forEach((derniereSortieDePeche, indexeSortie) => {
    derniereSortieDePeche.engins.forEach((engin, ceci) => {
      const autre = (ceci + 1) % derniereSortieDePeche.engins.length

      engin.nom.on('change', () => {
        const matchEngin = ENGINS.find(enginPredicate => enginPredicate.id === parseInt(engin.nom.val()))
        engin.nombre.attr('min', matchEngin.min);
        engin.nombre.attr('max', matchEngin.max);
        engin.nombre.val(matchEngin.min === matchEngin.max ? matchEngin.min : (parseInt(engin.nombre.val()) > matchEngin.max || parseInt(engin.nombre.val()) < matchEngin.min ? matchEngin.min : parseInt(engin.nombre.val())));
        engin.nombre.attr('readonly', matchEngin.min === matchEngin.max);

        derniereSortieDePeche.engins[ceci].nom.find('option').removeAttr('hidden')
        derniereSortieDePeche.engins[autre].nom.find('option').removeAttr('hidden')

        derniereSortieDePeche.engins[ceci].nom.find(`option[value="${derniereSortieDePeche.engins[ceci].nom.val()}"]`).attr('hidden', true)
        derniereSortieDePeche.engins[ceci].nom.find(`option[value="${derniereSortieDePeche.engins[autre].nom.val()}"]`).attr('hidden', true)
        derniereSortieDePeche.engins[autre].nom.find(`option[value="${derniereSortieDePeche.engins[ceci].nom.val()}"]`).attr('hidden', true)
        derniereSortieDePeche.engins[autre].nom.find(`option[value="${derniereSortieDePeche.engins[autre].nom.val()}"]`).attr('hidden', true)

        derniereSortieDePeche.engins[ceci].nom.find('option').first().removeAttr('hidden')
        derniereSortieDePeche.engins[autre].nom.find('option').first().removeAttr('hidden')
      })
    })
  })

  form.venteCrabe.marcheLocal.poids.on('blur', () => {
    const valeur = form.venteCrabe.marcheLocal.poids.val()
    if (valeur !== '' && parseFloat(valeur) > 0) {
      prixMarcheLocalObligatoire.show()
      form.venteCrabe.marcheLocal.prix.attr('min', MARCHE_LOCAL_MIN)
      form.venteCrabe.marcheLocal.prix.attr('max', MARCHE_LOCAL_MAX)
    } else {
      prixMarcheLocalObligatoire.hide()
      form.venteCrabe.marcheLocal.prix.removeAttr('min')
      form.venteCrabe.marcheLocal.prix.removeAttr('max')
    }
  })

  // Soumission du formulaire
  $('#js-bouton-enregistrer').on('click', e => {
    e.preventDefault();
    effacerValidationPrecedente();
    const boutonValidations = $('#js-bouton-enreigstrer, #js-bouton-enregistrer-et-nouveau');
    enregistrerFormulaire().then(() => {
      $.alert('L\'insertion du formulaire est un succès');
      setTimeout(() => location.href = `${BASE_URL}/consultation-de-fiche-acheteur/detail-et-action/${form.fiche.val()}.html`, 1000);
    }).finally(() => boutonValidations.removeAttr('disabled'));
  });

// Soumission du formulaire
  $('#js-bouton-enregistrer-et-nouveau').on('click', e => {
    e.preventDefault();
    effacerValidationPrecedente();
    const boutonValidations = $('#js-bouton-enreigstrer, #js-bouton-enregistrer-et-nouveau');
    enregistrerFormulaire().then(() => {
      $.alert('L\'insertion du formulaire est un succès');
      setTimeout(() => location.reload(), 1000);
    }).finally(() => boutonValidations.removeAttr('disabled'));
  });

  /**
   *
   * Définition des fonctions
   *
   */

  function enregistrerFormulaire() {
    return new Promise((resolve, reject) => {
      const boutonValidations = $('#js-bouton-enreigstrer, #js-bouton-enregistrer-et-nouveau');
      const minMaxOk = champNombreRespecteMinMax();
      const obligatoireOk = champObligatoireComplet();
      const autreValidationOk = autreValidation();
      if (!boutonValidations.is(':disabled') && minMaxOk && obligatoireOk && autreValidationOk) {
        $('.js-formulaire-card .js-alerte-information-incorrecte').slideUp(100);
        boutonValidations.attr('disabled', true);
        donnee = mettreAJourLesDonneesDePost();
        $.ajax({
          url: `${BASE_URL}/saisie-de-fiche-acheteur/saisie-enquete/insertion`,
          method: 'post',
          data: donnee,
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

  function mettreAJourLesDonneesDePost() {
    const donnee = {
      fiche: form.fiche.val(),
      date: form.date.val(),
      pecheur: form.pecheur.val(),
      nombrePecheur: form.nombrePecheur.val(),
      venteCrabe: {
        collecte: [
          {prix: form.venteCrabe.collecte[0].prix.val(), poids: form.venteCrabe.collecte[0].poids.val()},
          {prix: form.venteCrabe.collecte[1].prix.val(), poids: form.venteCrabe.collecte[1].poids.val()}
        ],
        marcheLocal: {
          prix: form.venteCrabe.marcheLocal.prix.val(),
          poids: form.venteCrabe.marcheLocal.poids.val()
        }
      },
      crabeNonVendu: {
        poids: form.crabeNonVendu.poids.val(),
        nombre: form.crabeNonVendu.nombre.val(),
      },
      dernierSortieDePeche: [],
      nombreSortieVente: form.nombreSortieVente.val(),
    };
    for (let indexe = 0; indexe < 4; indexe++) {
      const heuresJour = 1000 * 60 * 60 * 24;
      const dateReference = new Date(form.date.val()).getTime();
      const dateCourant = new Date(dateReference - heuresJour * indexe);

      donnee.dernierSortieDePeche.push({
        date: `${dateCourant.getFullYear()}-${dateCourant.getMonth() + 1}-${dateCourant.getDate()}`,
        nombre: form.derniereSortieDePeches[indexe].nombre.filter(':checked').val(),
        pirogue: form.derniereSortieDePeches[indexe].pirogue.filter(':checked').val(),
        engins: [
          {
            nom: form.derniereSortieDePeches[indexe].engins[0].nom.val(),
            nombre: form.derniereSortieDePeches[indexe].engins[0].nombre.val(),
          },
          {
            nom: form.derniereSortieDePeches[indexe].engins[1].nom.val(),
            nombre: form.derniereSortieDePeches[indexe].engins[1].nombre.val(),
          }
        ]
      });
    }
    return donnee;
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
      form.jour,
      form.pecheur,
      form.nombrePecheur,
      form.venteCrabe.collecte[0].poids,
      form.venteCrabe.marcheLocal.poids,
      form.nombreSortieVente,
      form.crabeNonVendu.poids,
      form.crabeNonVendu.nombre,
    ];

    if (!prixMarcheLocalObligatoire.is(':hidden')) {
      requises.push(form.venteCrabe.marcheLocal.prix)
    }

    form.derniereSortieDePeches.forEach(derniereSortieDePeche => {
      requises.push(derniereSortieDePeche.engins[0].nombre, derniereSortieDePeche.engins[1].nombre)
    })

    let errorString = '';
    for (let erreur of erreurs) {
      errorString += `<li>${erreur}</li>`;
    }

    $('.js-formulaire-card .js-alerte-information-incorrecte-conteneur').html(errorString);
    if (erreurs.length === 0) {
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
    $('.is-invalid').removeClass('is-invalid')
    $('.form-text').hide()
  }

  function autreValidation() {
    const timestamp = new Date(form.date.val()).getTime()
    const heuresJour = 1000 * 60 * 60 * 24
    const dates = []
    const erreurs = []
    const nombreDeSortiesDePeche = []
    const nombreDePiroguesUtilises = []
    const nombreDeVenteDeCrabe = parseInt(form.nombreSortieVente.val())
    let valide = true
    for (let i = 0; i < SORTIE_MAXIMALE; i++) dates.push(new Date(timestamp - heuresJour * i))

    if (form.jour.val() !== '') {
      for (let iteration = 0; iteration < SORTIE_MAXIMALE; iteration++) {
        if (parseInt(form.derniereSortieDePeches[iteration].engins[0].nombre.val()) < parseInt(form.derniereSortieDePeches[iteration].engins[1].nombre.val())) {
          erreurs.push(`Veuillez vérifier que le nombre premier engin du ${('0' + dates[iteration].getDate()).substr(-2)}/${('0' + (dates[iteration].getMonth() + 1)).substr(-2)}/${dates[iteration].getFullYear()} soit supérieur au deuxième`)
          valide = false
        }
      }
    }

    form.derniereSortieDePeches.forEach(derniereSortieDePeche => {
      nombreDeSortiesDePeche.push(parseInt(derniereSortieDePeche.nombre.filter(':checked').val()))
      nombreDePiroguesUtilises.push(parseInt(derniereSortieDePeche.pirogue.filter(':checked').val()))
    })

    for (let iteration = 0; iteration < SORTIE_MAXIMALE; iteration++) {
      if (nombreDeSortiesDePeche[iteration] < nombreDePiroguesUtilises[iteration]) {
        erreurs.push(`Le nombre de sorties en pirogue du ${('0' + dates[iteration].getDate()).substr(-2)}/${('0' + (dates[iteration].getMonth() + 1)).substr(-2)}/${dates[iteration].getFullYear()} ne doit pas dépasser le nombre de ${nombreDeSortiesDePeche[iteration]}`)
        valide = false
      }
    }

    let somme = nombreDeSortiesDePeche.reduce((a, b) => a + b, 0)
    if (somme < nombreDeVenteDeCrabe) {
      erreurs.push(`Le nombre de sorties correspondant à la vente ne doit pas dépasser le nombre de ${somme}`)
      valide = false
    }

    let chaineErreur = '';
    for (let erreur of erreurs) {
      chaineErreur += `<li>${erreur}</li>`
    }

    $('.js-alerte-information-incorrecte-conteneur').html(chaineErreur)

    return valide
  }

  (() => {
    form.venteCrabe.marcheLocal.poids.trigger('blur')
  })()

  /**
   *
   * Définition des fonctions
   *
   */
});