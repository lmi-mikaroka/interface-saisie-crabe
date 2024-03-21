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
      orderable: false
    }],
    order: [[0, 'asc']],
    ajax: {
      url: BASE_URL + '/groupe/datatable',
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
        url: BASE_URL + '/groupe/nouveau-groupe/suppression/' + information,
        method: 'get',
        dataType: 'json',
        success: () => {
          $(document).trigger('recharger-datatable')
          $.alert('Le groupe a été supprimé avec succès')
        }
      })
    })
  })

  $(document).on('click', '[data-target="#modal-modification"]', e => {
    let id = $(e.currentTarget).attr('id');
    id = id.substring(7, id.length);
    $.ajax({
      url: `${BASE_URL}/groupe/nouveau-groupe/selectionner/${id}`,
      method: 'get',
      dataType: 'json',
      success: groupe => {
        const formulaire = $('#js-formulaire-modification')
        initialiserOptionsOperations(formulaire)
        formulaire.find('[name=js-id]').val(groupe.id)
        formulaire.find('[name=js-nom]').val(groupe.nom)
        groupe.autorisations.forEach((autorisation, iteration) => {
          formulaire.find(`[name=js-permission${iteration}]`).val(autorisation.operation)
          formulaire.find(`[name=js-creation${iteration}]`).prop('checked', JSON.parse(autorisation.creation))
          formulaire.find(`[name=js-modification${iteration}]`).prop('checked', JSON.parse(autorisation.modification))
          formulaire.find(`[name=js-visualisation${iteration}]`).prop('checked', JSON.parse(autorisation.visualisation))
          formulaire.find(`[name=js-suppression${iteration}]`).prop('checked', JSON.parse(autorisation.suppression))
        })
        $('#modal-modification').modal('show')
      }
    })
  })

  function initialiserOptionsOperations(formulaire) {
    formulaire.find('.js-operation').each((iteration, elementCible) => {
      const permission = {
        creation: formulaire.find(`[name=js-creation${iteration}]`),
        modification: formulaire.find(`[name=js-modification${iteration}]`),
        visualisation: formulaire.find(`[name=js-visualisation${iteration}]`),
        suppression: formulaire.find(`[name=js-suppression${iteration}]`)
      }
      for(let cle in permission) {
        if(permission[cle].length) permission[cle].prop('checked', false)
      }
    })
  }
})