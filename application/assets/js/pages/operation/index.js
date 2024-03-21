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
      targets: [-1, -2, -3, -4, -5],
      orderable: false,
      className: 'text-center'
    }],
    order: [[0, 'asc']],
    ajax: {
      url: BASE_URL + '/operation/datatable',
      method: 'post',
    }
  })

  $(document).on('recharger-datatable', () => {
    datatable.ajax.reload()
  })

  $(document).on('click', '.delete-button', e => {
    var information = $(e.currentTarget).attr('data-target')
    jConfirmRed('Supprimer la sélection', 'La suppression pourra entraîner la perte d\'autres données relatives à celle-ci.\nVeuillez confirmer la suppression', () => {
      $.ajax({
        url: BASE_URL + '/operation/nouvelle-operation/suppression/' + information,
        method: 'get',
        dataType: 'json',
        success: () => {
          $(document).trigger('recharger-datatable')
          $.alert('L\'opération a été supprimé avec succès')
        }
      })
    })
  })

  $(document).on('click', '[data-target="#modal-modification"]', e => {
    let id = $(e.currentTarget).attr('id');
    id = id.substring(7, id.length);
    $.ajax({
      url: `${BASE_URL}/operation/nouvelle-operation/selectionner/${id}`,
      method: 'get',
      dataType: 'json',
      success: reponse => {
        const formulaire = $('#js-formulaire-modification')
        formulaire.find('[name=js-id]').val(reponse.id)
        formulaire.find('[name=js-nom]').val(reponse.nom)
        formulaire.find('[name=js-creation]').prop('checked', JSON.parse(reponse.creation))
        formulaire.find('[name=js-modification]').prop('checked', JSON.parse(reponse.modification))
        formulaire.find('[name=js-visualisation]').prop('checked', JSON.parse(reponse.visualisation))
        formulaire.find('[name=js-suppression]').prop('checked', JSON.parse(reponse.suppression))
        $('#modal-modification').modal('show')
      }
    });
  });
})