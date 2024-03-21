$(() => {
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
      url: BASE_URL + '/entite/pecheur/datatable',
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
        url: BASE_URL + '/entite/pecheur/suppression/' + information,
        method: 'get',
        dataType: 'json',
        success: () => {
          $(document).trigger('reload-datatable');
          $.alert('Le pêcheur a été supprimé avec succès');
        }
      });
    });
  });

  $(document).on('click', '.update-button', e => {
    const rawId = $(e.currentTarget).attr('id');
    const target = $(e.currentTarget).attr('data-target');
    const formulaire = $('#formulaire-modification')
    const form = {
      id: formulaire.find('[name=js-id]'),
      village: formulaire.find('[name=js-village]'),
      nom: formulaire.find('[name=js-nom]')
    }
    const soumission = $('#enregistrer-modification')
    const chargeurInformationModification = $('#chargeur-information-modification')
    chargeurInformationModification.show()
    soumission.attr('disabled', true)
    formulaire.hide()
    $(target).modal('show');
    var id = rawId.substr(rawId.indexOf('-') + 1, rawId.length);
    $.ajax({
      url: `${BASE_URL}/entite/pecheur/selection/${id}`,
      method: 'get',
      dataType: 'json',
      success: selectionEnqueteur => {
        form.village.val('')
        form.nom.val('')
        supprimerValidation()
        form.id.val(selectionEnqueteur['id'])
        form.village.val(selectionEnqueteur['village'])
        form.nom.val(selectionEnqueteur['nom'])
        chargeurInformationModification.hide()
        soumission.removeAttr('disabled')
        formulaire.show()
      },
      error: (arg0, arg1, arg2) => {
        console.error(arg0, arg1, arg2);
      }
    })
  })

  function supprimerValidation() {
    $('.form-text').hide();
    $('.is-invalid').removeClass('is-invalid');
  }
})