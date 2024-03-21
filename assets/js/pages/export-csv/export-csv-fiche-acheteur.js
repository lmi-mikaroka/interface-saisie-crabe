$(() => {
  const formulaireFicheEnqueteur = $('#js-formulaire-fiche-enqueteur')
  const genererFicheEnqueteur = $('#js-generer-fiche-enqueteur')
  const formulaireFicheEnqueteurCorp = {
    village: formulaireFicheEnqueteur.find('[name="js-villages[]"]'),
    dateDebut: formulaireFicheEnqueteur.find('[name=js-date-debut]'),
    dateFin: formulaireFicheEnqueteur.find('[name=js-date-fin]'),
    effacerFiltreDate: formulaireFicheEnqueteur.find('[name=js-effacer-date]'),
    champs: formulaireFicheEnqueteur.find('[name="js-champs[]"]'),
    delimiteur: formulaireFicheEnqueteur.find('[name=js-delimiteur]')
  }

  $('.select2').select2({
    theme: 'bootstrap4'
  })
  formulaireFicheEnqueteurCorp.effacerFiltreDate.on('click', e => {
    e.preventDefault()
    formulaireFicheEnqueteurCorp.dateDebut.val('')
    formulaireFicheEnqueteurCorp.dateFin.val('')
  })
  genererFicheEnqueteur.on('click', e => {
    e.preventDefault();
    formulaireFicheEnqueteur.trigger('submit')
  })
  formulaireFicheEnqueteur.on('submit', e => {
    e.preventDefault();
    const attente = $.confirm({
      useBootstrap: true,
      theme: 'bootstrap',
      animation: 'rotatex',
      closeAnimation: 'rotatex',
      animateFromElement: false,
      closeIcon: true,
      buttons: {
        telecharger: {
          action: button => location.href = button.data,
          isHidden: true
        }
      },
      content: function () {
        return $.ajax({
          url: `${BASE_URL}/exporter-csv/acheteur/generer`,
          method: 'post',
          dataType: 'json',
          data: {
            villages: formulaireFicheEnqueteurCorp.village.val(),
            date: [formulaireFicheEnqueteurCorp.dateDebut.val(), formulaireFicheEnqueteurCorp.dateFin.val()],
            champs: formulaireFicheEnqueteurCorp.champs.val(),
            delimiteur: formulaireFicheEnqueteurCorp.delimiteur.filter(':checked').val()
          }
        }).done((reponse) => {
          attente.setContent(reponse['fichier'])
          attente.setTitle('Téléchargement du fichier')
          attente.buttons.telecharger.addClass('btn btn-warning')
          attente.buttons.telecharger.show()
          attente.buttons.telecharger.setText('<i class="fa fa-download"></i> Télécharger')
          attente.buttons.telecharger.data = reponse['lien']
          console.log(reponse['sql'])
        }).fail(() => {
          attente.setContent('Une erreur est survenue. Veuillez reessayer ou contacter un administrateur')
          attente.setTitle('Erreur')
        })
      }
    })
  })
})