$(() => {
  var datatable = $('#datatable').DataTable({
    language: { url: BASE_URL + '/assets/datatable-fr.json' },
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
      url: BASE_URL + '/edition-de-zone/zone-corecrabe/datatable',
      method: 'post',
    },
  });

  // Evènement au rechergement de la datatable
  $(document).on('reload-datatable', () => {
    datatable.ajax.reload();
  });

  $(document).on('click', '.delete-button', e => {
    var information = $(e.currentTarget).attr('data-target');
    jConfirmRed('Supprimer la sélection', 'La suppression pourra entrainer la perte d\'autres données relatives à celle-ci.\nVeuillez confirmer la suppression', () => {
      $.ajax({
        url: BASE_URL + '/edition-de-zone/zone-corecrabe/suppression/' + information,
        method: 'get',
        dataType: 'json',
        success: () => {
          $(document).trigger('reload-datatable');
          $.alert('La zone a été supprimée avec succès');
        }
      });
    });
  });

  $(document).on('click', '.update-button', e => {
    const rawId = $(e.currentTarget).attr('id');
    const target = $(e.currentTarget).attr('data-target');
    var id = rawId.substr(rawId.indexOf('-') + 1, rawId.length);
    const formulaire = $('#formulaire-modification')
    const form = {
      id: formulaire.find('[name=js-id]'),
      nom: formulaire.find('[name=js-nom]')
    }
    const soumission = $('#enregistrer-modification')
    const chargeurInformationModification = $('#chargeur-information-modification')
    chargeurInformationModification.show()
    soumission.attr('disabled', true)
    formulaire.hide()
    $(target).modal('show');
    $.ajax({
      url: `${BASE_URL}/edition-de-zone/zone-corecrabe/selection/${id}`,
      method: 'get',
      dataType: 'json',
      success: response => {
        supprimerValidation()
        form.id.val(response['id'])
        form.nom.val(response['nom'])
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