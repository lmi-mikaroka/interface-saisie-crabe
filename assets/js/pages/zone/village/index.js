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
      url: BASE_URL + '/edition-de-zone/village/datatable',
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
        url: BASE_URL + '/edition-de-zone/village/suppression/' + information,
        method: 'get',
        dataType: 'json',
        success: () => {
          $(document).trigger('reload-datatable');
          $.alert('Le village a été supprimée avec succès');
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
      fokontany: formulaire.find('[name=js-fokontany]'),
      nom: formulaire.find('[name=js-nom]'),
      longitude: formulaire.find('[name=js-longitude]'),
      latitude: formulaire.find('[name=js-latitude]'),
      sous_zone: formulaire.find('[name=js-sous-zone]'),
    }
    const soumission = $('#enregistrer-modification')
    const chargeurInformationModification = $('#chargeur-information-modification')
    chargeurInformationModification.show()
    soumission.attr('disabled', true)
    formulaire.hide()
    $(target).modal('show');
    $.ajax({
      url: `${BASE_URL}/edition-de-zone/village/selection/${id}`,
      method: 'get',
      dataType: 'json',
      success: response => {
        supprimerValidation()
        form.id.val(response['id'])
        form.fokontany.val(response['fokontany'])
        form.nom.val(response['nom'])
	form.longitude.val(response['longitude'])
        form.latitude.val(response['latitude'])
        form.sous_zone.val(response['sous_zone'])
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