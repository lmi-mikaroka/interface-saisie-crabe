$(() => {

  const nouveauFicheLien = `${BASE_URL}/saisie-de-fiche-pecheur/saisie-enquete/`



  const actualisationVillage = $('#actualisation-village')

  const champInsertionVillage = $('#champ-insertion-village')

  const actualisationEnqueteur = $('#actualisation-enqueteur')

  const champInsertionEnqueteur = $('#champ-insertion-enqueteur')



  const form = {

    corps: $('#js-formulaire'),

    zoneCorecrabe: $('[name=js-zone-corecrabe]'),

    village: $('[name=js-village]'),

    annee: $('[name=js-annee]'),

    mois: $('[name=js-mois]'),

    numero: $('[name=js-numero]'),

    enqueteur: $('[name=js-enqueteur]'),

    dateExpedition: $('[name=js-date-expedition]'),

    soumission: $('#js-bouton-enregistrer'),

  };



  // Ecoute de changement de zone corecrabe

  form.zoneCorecrabe.on('change', e => {

    var zone = parseInt($(e.currentTarget).val());

    let optionTags = '<option value="" hidden selected></option>';

    // Vider la liste déroulante pour faire place à la nouvelle liste

    while (form.village.children().length > 0) {

      form.village.children().eq(0).remove();

    }

    actualisationVillage.show()

    champInsertionVillage.hide()

    $.ajax({

       url: BASE_URL + '/edition-de-zone/village/selection-par-zone-corecrabe/' + zone + '/?type=Pêcheur',

      method: 'get',

      dataType: 'json',

      success: villages => {

        for (var village of villages) {

          optionTags += `<option value="${village['id']}">${village['nom']}</option>`

        }

        form.village.html(optionTags)

      }

    }).always(() => {

      actualisationVillage.hide()

      champInsertionVillage.show()

      form.village.trigger('change')

    })

  })



  form.village.on('change', e => {

    actualisationEnqueteur.show()

    champInsertionEnqueteur.hide()

    actualiserListeEnqueteur(form.village.val(), 2).then(enqueteurs => {

      let chaineEnqueteur = '<option value="" selected hidden></option>'

      for (let enqueteur of enqueteurs) {

        chaineEnqueteur += `<option value="${enqueteur['id']}">${enqueteur['code']}</option>`

      }

      form.enqueteur.html(chaineEnqueteur)

    }).finally(() => {

      actualisationEnqueteur.hide()

      champInsertionEnqueteur.show()

    })

  })



  //envoi du formulaire

  form.soumission.on('click', e => {

    e.preventDefault();

    form.corps.trigger('submit');

  });



  form.corps.on('submit', e => {

    e.preventDefault();

    effacerValidationPrecedente();

    const formularieValide = fromulaireValide() && champNombreRespecteMinMax();

    if (!form.soumission.is(':disabled') && formularieValide) {

      form.soumission.attr('disabled', true);

      $.ajax({

        url: `${BASE_URL}/saisie-fiche/fiche/insertion`,

        method: 'post',

        data: chargerDonneesFormulaire(),

        dataType: 'json',

        success: reponse => {

          if (!reponse.success) {

            $.alert(reponse.raison);

          } else {

            location.href = `${nouveauFicheLien}${reponse.message}.html`;

          }

          form.soumission.removeAttr('disabled');

        },

        error: (arg1, arg2, arg3) => {

          console.error(arg1, arg2, arg3);

          form.soumission.removeAttr('disabled');

        }

      })

    }

  });



  function chargerDonneesFormulaire() {

    return {

      village: form.village.val(),

      enqueteur: form.enqueteur.val(),

      ficheType: 'PEC',

      ficheAnnee: form.annee.val(),

      ficheMois: form.mois.val(),

      ficheNumeroOrdre: form.numero.val(),

      ficheExpedie: form.dateExpedition.val() != '',

      ficheDateExpedition: form.dateExpedition.val()

    };

  }



  function fromulaireValide() {

    let valide = true;

    const requireds = [

      form.zoneCorecrabe,

      form.village,

      form.annee,

      form.numero,

      form.enqueteur,

    ];



    for (let required of requireds) {

      if (required.val() === '') {

        valide = false;

        const indicateur = required.parents('.form-group').find('.form-text');

        indicateur.text('Ce champ est obligatoire');

        indicateur.show();

        required.addClass('is-invalid');

      }

    }



    return valide;

  }



  function effacerValidationPrecedente() {

    $('.is-invalid').removeClass('is-invalid');

    $('.form-text').hide();

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

});