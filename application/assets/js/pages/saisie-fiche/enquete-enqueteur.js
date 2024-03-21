$(() => {

  const SORTIE_MAXIMALE = 4

  let biometrieCrabeTemporaire = []

  const prixMarcheLocalObligatoire = $('#js-marche-local-prix-obligatoire')



  const form = {

    corps: $('#js-formulaire'),

    fiche: $('[name=js-fiche]'),

    jour: $('[name=js-jour]'),

    date: $('[name=js-date]'),

    pecheur: $('[name=js-pecheur]'),

    accompaganteur: {

      individu: $('[name=js-individu-accompagnateur]'),

      nombre: $('[name=js-nombre-accompagnateur]'),

    },

    derniereSortieDePeches: [],

    nombreSortieCapture: $('[name=js-nombre-sortie-capture]'),

    poidsTotalCapture: $('[name=js-capture-poids-total]'),

    venteDeCrabe: {

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

      }

    },

    crabeConsomme: {

      poids: $('[name=js-crabe-consomme-poids-total]'),

      nombre: $('[name=js-crabe-consomme-nombre]')

    },

    echantillon: {

      trie: $('[name=js-echantillon-trie]'),

      tailleAbsente: $('[name=js-echantillon-trie-taille-absente]'),

      tailleAutrePrecision: $('[name=js-echantillon-trie-taille-absente-autre-precision]'),

      crabes: [],

      poids: $('[name=js-echantillon-poids-total]')

    },

    dateLiteralle: $('.js-date-literalle')

  }



  for (let iteration = 0; iteration < SORTIE_MAXIMALE; iteration++) {

    form.derniereSortieDePeches.push({

      nombre: $(`[name=js-derniere-sortie-de-peche-nombre${iteration}]`),

      pirogue: $(`[name=js-derniere-sortie-de-peche-pirogue${iteration}]`),

      engins: [

        {

          nom: $(`[name=js-derniere-sortie-de-peche-premier-engin-nom${iteration}]`),

          nombre: $(`[name=js-derniere-sortie-de-peche-premier-engin-nombre${iteration}]`)

        },

        {

          nom: $(`[name=js-derniere-sortie-de-peche-deuxieme-engin-nom${iteration}]`),

          nombre: $(`[name=js-derniere-sortie-de-peche-deuxieme-engin-nombre${iteration}]`)

        }

      ]

    })

  }



  const boutons = {

    enregistrerEtNouveau: $('#js-bouton-enregistrer-et-nouveau'),

    enregistrerEtListe: $('#js-bouton-enregistrer'),

  }



  /*

  *

  * Initiation de données réçues et à envoyer

  *

  */



  form.venteDeCrabe.marcheLocal.poids.on('blur', e => {

    const valeur = form.venteDeCrabe.marcheLocal.poids.val()

    if (valeur !== '' && parseFloat(valeur) > 0) {

      prixMarcheLocalObligatoire.show()

      form.venteDeCrabe.marcheLocal.prix.attr('min', MARCHE_LOCAL_MIN)

      form.venteDeCrabe.marcheLocal.prix.attr('max', MARCHE_LOCAL_MAX)

    } else {

      prixMarcheLocalObligatoire.hide()

      form.venteDeCrabe.marcheLocal.prix.removeAttr('min')

      form.venteDeCrabe.marcheLocal.prix.removeAttr('max')

    }

  })



  form.jour.on('change', () => {

    const valeurDate = form.date.val();

    form.date.val(`${valeurDate.toString().substr(0, 8)}${('0' + form.jour.val()).substr(-2)}`);

    form.date.trigger('change');

  });



  // Détecter le changement de la date

  form.date.on('change', e => {

    const timestamp = new Date(e.currentTarget.value).getTime();

    const nominationParDefaut = ['Aujourd\'hui', 'Hier', 'Avant-hier', 'Avant-avant-hier'];

    const heuresJour = 1000 * 60 * 60 * 24;

    const dates = [];

    for (let i = 0; i < SORTIE_MAXIMALE; i++) dates.push(new Date(timestamp - heuresJour * i));

    var maintenant = null;
    var p = 0;
    form.dateLiteralle.each((indexe, elementCible) => {

      const date = {

        jour: `0${dates[indexe % SORTIE_MAXIMALE].getDate()}`.substr(-2),

        mois: `0${dates[indexe % SORTIE_MAXIMALE].getMonth() + 1}`.substr(-2),

        annee: dates[indexe % SORTIE_MAXIMALE].getFullYear()

      }
      if(p == 0){
        maintenant = `${date.jour}/${date.mois}/${date.annee}`;
      }
      p+=1;
      $(elementCible).text(`○ Activité le ${date.jour}/${date.mois}/${date.annee}`)

    });

    $(".maintenant").text("LE "+maintenant);

  });



  // Actualisation du nombre de partenaire en fonction du critère de choix de partenaire

  form.accompaganteur.individu.on('change', e => {

    const possibilites = [

      {valeur: 'seul', min: 0, max: 0, lectureSeul: true},

      {valeur: 'partenaire', min: 1, max: 1, lectureSeul: true},

      {valeur: 'enfant', min: 1, max: 5, lectureSeul: false},

      {valeur: 'amis', min: 1, max: 10, lectureSeul: false},

    ]



    const valeurChamp = e.currentTarget.value



    possibilites.forEach(possibilite => {

      if (valeurChamp === possibilite.valeur) {

        form.accompaganteur.nombre.val(possibilite.min)

        form.accompaganteur.nombre.attr('min', possibilite.min)

        form.accompaganteur.nombre.attr('max', possibilite.max)

        if (possibilite.lectureSeul) form.accompaganteur.nombre.attr('readonly', true)

        else form.accompaganteur.nombre.removeAttr('readonly')

      }

    })

  })



  form.derniereSortieDePeches.forEach((derniereSortieDePeche, indexeSortie) => {

    derniereSortieDePeche.engins.forEach((engin, ceci) => {

      const autre = (ceci + 1) % derniereSortieDePeche.engins.length



      engin.nom.on('change', () => {

        const matchEngin = ENGINS.find(enginPredicate => enginPredicate.id === parseInt(engin.nom.val()))

        engin.nombre.attr('min', matchEngin.min);
        var max = matchEngin.max
        if(parseInt(form.accompaganteur.nombre.val())>0){
          max = matchEngin.max+parseInt(form.accompaganteur.nombre.val())
        }
        
        engin.nombre.attr('max', max);
        engin.nombre.val(matchEngin.min === max ? matchEngin.min : (parseInt(engin.nombre.val()) > max || parseInt(engin.nombre.val()) < matchEngin.min ? matchEngin.min : parseInt(engin.nombre.val())));

        engin.nombre.attr('readonly', matchEngin.min === max);



        derniereSortieDePeche.engins[ceci].nom.find('option').removeAttr('hidden')

        derniereSortieDePeche.engins[autre].nom.find('option').removeAttr('hidden')



        derniereSortieDePeche.engins[ceci].nom.find(`option[value="${derniereSortieDePeche.engins[ceci].nom.val()}"]`).attr('hidden', true)

        derniereSortieDePeche.engins[ceci].nom.find(`option[value="${derniereSortieDePeche.engins[autre].nom.val()}"]`).attr('hidden', true)

        derniereSortieDePeche.engins[autre].nom.find(`option[value="${derniereSortieDePeche.engins[ceci].nom.val()}"]`).attr('hidden', true)

        derniereSortieDePeche.engins[autre].nom.find(`option[value="${derniereSortieDePeche.engins[autre].nom.val()}"]`).attr('hidden', true)



        derniereSortieDePeche.engins[ceci].nom.find('option').first().removeAttr('hidden')

        derniereSortieDePeche.engins[autre].nom.find('option').first().removeAttr('hidden')

      });

    });

  })



  /**

   *

   * Evénement sur le choix si l'échantillon a été trié

   * ou pas

   * si'il a été trié un autre choix se propose

   *

   */

  form.echantillon.trie.on('change', e => {

    const trie = JSON.parse($(e.currentTarget).val())



    if (trie) {

      form.echantillon.tailleAbsente.parents('.js-echantillon-trie-taille-absente-autre').show()

    } else {

      form.echantillon.tailleAbsente.parents('.js-echantillon-trie-taille-absente-autre').hide()

    }

    form.echantillon.tailleAbsente.eq(1).prop('checked', true)

    form.echantillon.tailleAbsente.trigger('change')

  })



  form.echantillon.tailleAbsente.on('change', e => {

    if (form.echantillon.tailleAbsente.filter(':checked').val() === form.echantillon.tailleAbsente.eq(2).val()) {

      form.echantillon.tailleAutrePrecision.removeAttr('readonly')

    } else {

      form.echantillon.tailleAutrePrecision.attr('readonly', true)

      form.echantillon.tailleAutrePrecision.val('')

    }

  })



  $('#js-donnee-biometrique-taille-allouer').on('blur', e => {

    const elementCible = e.currentTarget

    const min = parseInt($(elementCible).attr('min'))

    const max = parseInt($(elementCible).attr('max'))

    if (parseInt($(elementCible).val()) < min) {

      $(elementCible).val(min)

    } else if (parseInt($(elementCible).val()) > max) {

      $(elementCible).val(max)

    }

  })



  $('#js-donnee-biometrique-allouer').on('click', e => {

    genererBiometrie(parseInt($('#js-donnee-biometrique-taille-allouer').val()))

    capturerEvenementAJoutBiometrie()

  })



  capturerEvenementAJoutBiometrie()



  function capturerEvenementAJoutBiometrie() {

    const ajouterBiometrie = $('#js-biometrie-crabe-ajouter')

    if (ajouterBiometrie.length) {

      ajouterBiometrie.on('click', e => {

        const tailleVoulue = form.echantillon.crabes.length + 1

        genererBiometrie(tailleVoulue)

        capturerEvenementAJoutBiometrie()

      })

    }

  }



  function genererBiometrie(tailleVoulue) {

    const biometrie = $('#js-donnees-biometrique-crabe')

    biometrieCrabeTemporaire = form.echantillon.crabes.map(crabe => {

      return {

        destination: crabe.destination.val(),

        taille: crabe.taille.val(),

        sexe: crabe.sexe.val()

      }

    })



    form.echantillon.crabes = []

    let brouillonBiometrie = ''



    for (let iteration = 0; iteration < tailleVoulue && iteration < BIOMETRIE_CRABE_MAX; iteration++) {

      brouillonBiometrie += `<div class="col-sm-2 col-xs-12 d-flex align-items-stretch flex-column">

        <div class="card">

          <div class="card-header border-0">

            <h3 class="card-title">Crabe N°${iteration + 1}</h3>

            <!-- tools card -->

            <div class="card-tools">

              <button type="button" class="btn btn-danger btn-sm" id="js-donnees-biometrique-crabe-fermer${iteration}">

                <i class="fas fa-times"></i>

              </button>

            </div>

            <!-- /. tools -->

          </div>

          <div class="card-body">

            <div class="form-group">

              <label for="js-donnees-biometrique-crabe-destination${iteration}">Destination</label>

              <select name="js-donnees-biometrique-crabe-destination${iteration}" id="js-donnees-biometrique-crabe-destination${iteration}" class="custom-select">

                <option value="1" selected="">Collecte</option>

                <option value="2">Marché local</option>

                <option value="3">Autoconsommation</option>

              </select>

            </div>

            <div class="form-group">

              <label for="js-donnees-biometrique-crabe-sexe${iteration}">Sexe</label>

              <select name="js-donnees-biometrique-crabe-sexe${iteration}" id="js-donnees-biometrique-crabe-sexe${iteration}" class="custom-select">

                <option value="NR" selected="">Non renseigné</option>

                <option value="M">Mâle</option>

                <option value="NO">Femelle non-ovée</option>

                <option value="FO">Femelle ovée</option>

              </select>

            </div>

            <div class="form-group">

              <label for="js-donnees-biometrique-crabe-taille${iteration}">Taille (mm)<span class="text text-red">*</span></label>

              <input type="number" min="${TAILLE_MINIMALE_CRABE}" max="${TAILLE_MAXIMALE_CRABE}" class="form-control" name="js-donnees-biometrique-crabe-taille${iteration}" id="js-donnees-biometrique-crabe-taille${iteration}">

              <span class="form-text text-red" style="display: none;"></span>

            </div>

          </div>

        </div>

      </div>`

    }



    if (tailleVoulue < BIOMETRIE_CRABE_MAX) {

      brouillonBiometrie += `<div class="col-sm-${tailleVoulue % 6 == 0 ? 12 : 2} col-xs-12 d-flex align-items-stretch flex-column" id="js-biometrie-crabe-ajouter">

          <div type="button" class="card d-flex flex-fill">

            <button type="button" class="btn btn-default btn-block" style="height: 100%;">

              <i class="fa fa-plus"></i><br>

              <span>Ajouter un crabe</span>

            </button>

          </div>

        </div>`

    }



    biometrie.find('.row').html(brouillonBiometrie)



    for (let iteration = 0; iteration < tailleVoulue; iteration++) {

      form.echantillon.crabes.push({

        destination: $(`[name=js-donnees-biometrique-crabe-destination${iteration}]`),

        taille: $(`[name=js-donnees-biometrique-crabe-taille${iteration}]`),

        sexe: $(`[name=js-donnees-biometrique-crabe-sexe${iteration}]`),

        fermerCarte: $(`#js-donnees-biometrique-crabe-fermer${iteration}`)

      })



      if (form.echantillon.crabes[iteration].fermerCarte.length) {

        form.echantillon.crabes[iteration].fermerCarte.on('click', e => {

          form.echantillon.crabes.splice(iteration, 1)

          genererBiometrie(form.echantillon.crabes.length)

          capturerEvenementAJoutBiometrie()

        })

      }

    }



    miseAJourDonneesBiometrie(biometrieCrabeTemporaire, form.echantillon.crabes)

    const tailleAllouer = $('#js-donnee-biometrique-taille-allouer')

    tailleAllouer.attr('min', form.echantillon.crabes.length)

    tailleAllouer.trigger('blur')

  }



  function miseAJourDonneesBiometrie(ancienneDonnee, nouveauConteneur) {

    for (let iteration = 0; iteration < ancienneDonnee.length && iteration < nouveauConteneur.length; iteration++) {

      nouveauConteneur[iteration].destination.val(ancienneDonnee[iteration].destination)

      nouveauConteneur[iteration].taille.val(ancienneDonnee[iteration].taille)

      nouveauConteneur[iteration].sexe.val(ancienneDonnee[iteration].sexe)

    }

  }



  // Soumission du formulaire

  boutons.enregistrerEtNouveau.on('click', e => {

    e.preventDefault();

    const boutons = $('#js-bouton-enregistrer-et-nouveau, #js-bouton-enregistrer');

    effacerValidationPrecedente();

    enregistrerFormulaire(boutons).then(() => {

      $.alert('L\'insertion du formulaire est un succès');

      setTimeout(() => location.reload(), 1000);

    }).finally(() => {

      boutons.removeAttr('disabled')

    });

  });



  boutons.enregistrerEtListe.on('click', e => {

    e.preventDefault();

    const boutons = $('#js-bouton-enregistrer-et-nouveau, #js-bouton-enregistrer');

    effacerValidationPrecedente();

    enregistrerFormulaire(boutons).then(reponse => {

      if (!reponse.serveur.succes) {

        reponse.alert.setContent('Une erreur est survenue. Veuillez reessayer ou contacter un administrateur')

        reponse.alert.setTitle('Erreur')

      } else {

        reponse.alert.setContent('L\'insertion de l\'Enquête a été effectué')

        reponse.alert.setTitle('Succès')

        setTimeout(() => location.href = `${BASE_URL}/consultation-de-fiche-enqueteur/detail-et-action/${form.fiche.val()}.html`, 1000);

      }

    }).catch(alert => {

      alert.setContent('Une erreur est survenue. Veuillez reessayer ou contacter un administrateur')

      alert.setTitle('Erreur')

    })

  });



  $(document).on('focus', 'input[type=number]', e => {

    $(e.currentTarget).select();

  });



  /**

   *

   * Définition des fonctions

   * Définition des fonctions

   *

   */



  function effacerValidationPrecedente() {

    $('.is-invalid').removeClass('is-invalid');

    $('.form-text').hide();

  }



  function enregistrerFormulaire() {

    return new Promise((resolve, reject) => {

      const minMaxOk = champNombreRespecteMinMax()

      const obligatoireOk = champObligatoireComplet()

      const autreOk = autreValidation()

      if (minMaxOk && obligatoireOk && autreOk) {

        $('.js-alerte-information-incorrecte').slideUp(100)

        const attente = $.alert({

          useBootstrap: true,

          theme: 'bootstrap',

          animation: 'rotatex',

          closeAnimation: 'rotatex',

          animateFromElement: false,

          content: function () {

            return $.ajax({

              url: `${BASE_URL}/saisie-de-fiche-enqueteur/saisie-enquete/insertion`,

              data: mettreAJourLesDonneesDePost(),

              type: 'post',

              dataType: 'json'

            }).done(reponse => {

              resolve({alert: attente, serveur: reponse})

            }).fail(() => {

              reject(attente)

            })

          }

        })

      } else {

        $('.js-alerte-information-incorrecte').slideDown(100)

      }

    })

  }



  function mettreAJourLesDonneesDePost() {

    const donnees = {

      fiche: form.fiche.val(),

      date: form.date.val(),

      pecheur: form.pecheur.val(),

      participant: form.accompaganteur.individu.val(),

      nombreParticipant: form.accompaganteur.nombre.val(),

      poidsTotalDeLaCapture: form.poidsTotalCapture.val(),

      nombreSortieCapture: form.nombreSortieCapture.val(),

      crabeConsomme: {

        poids: form.crabeConsomme.poids.val(),

        nombre: form.crabeConsomme.nombre.val()

      },

      venteDeCrabe: {

        collecte: [

          {poids: form.venteDeCrabe.collecte[0].poids.val(), prix: form.venteDeCrabe.collecte[0].prix.val()},

          {poids: form.venteDeCrabe.collecte[1].poids.val(), prix: form.venteDeCrabe.collecte[1].prix.val()}

        ],

        marcheLocal: {poids: form.venteDeCrabe.marcheLocal.poids.val(), prix: form.venteDeCrabe.marcheLocal.prix.val()}

      },

      echantillon: {

        trie: JSON.parse(form.echantillon.trie.filter(':checked').val()) ? 1 : 0,

        tailleAbsente: {

          taille: form.echantillon.tailleAbsente.filter(':checked').val(),

          precision: form.echantillon.tailleAutrePrecision.val()

        },

        poids: form.echantillon.poids.val(),

        crabes: []

      },

      dernierSortieDePeches: [],

      captureDeCrabes: []

    }



    for (let iteration = 0; iteration < SORTIE_MAXIMALE; iteration++) {

      const heuresJour = 1000 * 60 * 60 * 24;

      const dateReference = new Date(form.date.val()).getTime();

      const dateCourant = new Date(dateReference - heuresJour * iteration);



      donnees.dernierSortieDePeches.push({

        nombreDeSortie: form.derniereSortieDePeches[iteration].nombre.filter(':checked').val(),

        nombreDePirogue: form.derniereSortieDePeches[iteration].pirogue.filter(':checked').val(),

        date: `${dateCourant.getFullYear()}-${dateCourant.getMonth() + 1}-${dateCourant.getDate()}`,

        engins: [

          {

            nom: form.derniereSortieDePeches[iteration].engins[0].nom.val(),

            nombre: form.derniereSortieDePeches[iteration].engins[0].nombre.val()

          },

          {

            nom: form.derniereSortieDePeches[iteration].engins[1].nom.val(),

            nombre: form.derniereSortieDePeches[iteration].engins[1].nombre.val()

          }

        ]

      })

    }



    for (let iteration = 0; iteration < form.echantillon.crabes.length; iteration++) {

      donnees.echantillon.crabes.push({

        sexe: form.echantillon.crabes[iteration].sexe.val(),

        destination: form.echantillon.crabes[iteration].destination.val(),

        taille: form.echantillon.crabes[iteration].taille.val(),

      })

    }



    return donnees

  }



  function champNombreRespecteMinMax() {

    let valide = true

    const nombreDeCrabes = form.echantillon.crabes.length

    const poidsEchantillon = form.echantillon.poids



    if (nombreDeCrabes < BIOMETRIE_CRABE_MAX) {

      poidsEchantillon.val(form.poidsTotalCapture.val())

    }



    $('input[type=number]').each((index, elementCible) => {

      const erreurTag = $(elementCible).parents('.form-group').find('.form-text')

      if ($(elementCible).attr('min') !== 'undefined' && parseFloat($(elementCible).attr('min')) > parseFloat($(elementCible).val())) {

        valide = false

        erreurTag.text(`valeur inférieure ${$(elementCible).attr('min')}`)

        erreurTag.show()

        $(elementCible).addClass('is-invalid');

      } else if ($(elementCible).attr('max') !== 'undefined' && parseFloat($(elementCible).attr('max')) < parseFloat($(elementCible).val())) {

        valide = false

        erreurTag.text(`valeur maximale ${$(elementCible).attr('max')}`)

        erreurTag.show()

        $(elementCible).addClass('is-invalid')

      }

    })



    return valide;

  }



  function champObligatoireComplet() {

    let valide = true

    const requises = [

      form.jour,

      form.pecheur,

      form.accompaganteur.nombre,

      form.poidsTotalCapture,

      form.nombreSortieCapture,

      form.venteDeCrabe.marcheLocal.poids,

      form.crabeConsomme.poids

    ]



    if (!prixMarcheLocalObligatoire.is(':hidden')) {

      requises.push(form.venteDeCrabe.marcheLocal.prix)

    }



    const nombreDeCrabes = form.echantillon.crabes.length;

    const poidsEchantillon = form.echantillon.poids;

    if (nombreDeCrabes === BIOMETRIE_CRABE_MAX) {

      requises.push(poidsEchantillon)

      poidsEchantillon.attr('max', parseFloat(requises[3].val()) <= POIDS_MAX_DE_ECHANTILLON ? parseFloat(requises[3].val()) : POIDS_MAX_DE_ECHANTILLON)

    }



    form.derniereSortieDePeches.forEach(derniereSortieDePeche => {

      requises.push(derniereSortieDePeche.engins[0].nombre, derniereSortieDePeche.engins[1].nombre)

    })



    if (form.echantillon.tailleAbsente.filter(':checked').val() === 'autre') {

      requises.push(form.echantillon.tailleAutrePrecision)

    }



    form.echantillon.crabes.forEach(crabe => {

      requises.push(crabe.taille)

    })



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



  function autreValidation() {

    const timestamp = new Date(form.date.val()).getTime()

    const heuresJour = 1000 * 60 * 60 * 24

    const dates = []

    const erreurs = []

    const nombreDeSortiesDePeche = []

    const nombreDePiroguesUtilises = []

    const nombreDeCaptureDeCrabe = parseInt(form.nombreSortieCapture.val())

    let valide = true

    for (let i = 0; i < SORTIE_MAXIMALE; i++) dates.push(new Date(timestamp - heuresJour * i))



    if (form.jour.val() !== '') {

      for (let iteration = 0; iteration < SORTIE_MAXIMALE; iteration++) {

        if (parseInt(form.derniereSortieDePeches[iteration].engins[0].nombre.val()) < parseInt(form.derniereSortieDePeches[iteration].engins[1].nombre.val())) {

          erreurs.push(`Veuillez vérifier que le nombre premier engin du ${('0' + dates[iteration].getDate()).substr(-2)}/${('0' + (dates[iteration].getMonth() + 1)).substr(-2)}/${dates[iteration].getFullYear()} soit supérieur au deuxième`);

          valide = false;

        }

      }

    }



    form.derniereSortieDePeches.forEach(derniereSortieDePeche => {

      nombreDeSortiesDePeche.push(parseInt(derniereSortieDePeche.nombre.filter(':checked').val()))

      nombreDePiroguesUtilises.push(parseInt(derniereSortieDePeche.pirogue.filter(':checked').val()))

    })



    for (let iteration = 0; iteration < SORTIE_MAXIMALE; iteration++) {

      if (nombreDeSortiesDePeche[iteration] < nombreDePiroguesUtilises[iteration]) {

        erreurs.push(`Le nombre de sorties en pirogue du ${('0' + dates[iteration].getDate()).substr(-2)}/${('0' + (dates[iteration].getMonth() + 1)).substr(-2)}/${dates[iteration].getFullYear()} ne doit pas dépasser le nombre de ${nombreDeSortiesDePeche[iteration]}`);

        valide = false;

      }

    }



    let somme = nombreDeSortiesDePeche.reduce((a, b) => a + b, 0)

    if(somme < nombreDeCaptureDeCrabe) {

      erreurs.push(`Le nombre de sorties correspondant à la capture ne doit pas dépasser le nombre de ${somme}`)

      valide = false

    }

    if (form.echantillon.crabes.length == 0) {

      erreurs.push(`Vous devez au moins insérer une donnée biométrique`)

      valide = false

    }



    const poidsCollecte = parseFloat(form.venteDeCrabe.collecte[0].poids.val()) + parseFloat(isNaN(parseFloat(form.venteDeCrabe.collecte[1].poids.val())) ? '0' : form.venteDeCrabe.collecte[1].poids.val())

    const poidsMarcheLocal = parseFloat(form.venteDeCrabe.marcheLocal.poids.val())

    const poidsConsomme = parseFloat(form.crabeConsomme.poids.val())

    const poidsCapture = parseFloat(parseFloat(form.poidsTotalCapture.val()))



    if (parseFloat((poidsCollecte + poidsMarcheLocal + poidsConsomme).toFixed(CHIFFRE_APRES_VIRGULE)) !== parseFloat(poidsCapture.toFixed(CHIFFRE_APRES_VIRGULE))) {

      valide = false

      erreurs.push('la somme de poids de crabe collecté, vendu aux marchés local et consommé doit être égal au poids total de crabe capturé')

    }



    let chaineErreur = '';

    for (let erreur of erreurs) {

      chaineErreur += `<li>${erreur}</li>`;

    }



    $('.js-alerte-information-incorrecte-conteneur').html(chaineErreur);



    return valide

  }



  /**

   *

   * Définition des fonctions

   *

   */



  prixMarcheLocalObligatoire.hide()

});