$(() => {

    const datatable = $('#datatable').DataTable({
  
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
  
        url: BASE_URL + '/consultation-de-recensement/liste',
  
        method: 'post',
  
      },
  
    });
  
  
  
    $(document).on('reload-datatable', () => {
  
      datatable.ajax.reload();
  
    });
  
    $(document).on('click', '.delete-button', e => {
  
      var information = $(e.currentTarget).attr('data-target');
  
      jConfirmRed('Supprimer la sélection', 'La suppression pourra entraîner la perte d\'autres données relatives à celle-ci.\nVeuillez confirmer la suppression', () => {
  
        $.ajax({
  
          url: BASE_URL + '/recensement/suppression/' + information,
  
          method: 'get',
  
          dataType: 'json',
  
          success: () => {
  
            $(document).trigger('reload-datatable');
  
            $.alert('La fiche de récensement  a été supprimé avec succès');
  
          }
  
        });
  
      });
  
    });
  
  
  
  //   $(document).on('click', '.delete-button', e => {
  
  //     const valeur = $(e.currentTarget).attr('data-target');
  
  //     jConfirmRed('Supprimer la sélection', 'La suppression pourra entraîner la perte d\'autres données relatives à celle-ci.\nVeuillez confirmer la suppression', () => {
  
  //       $.ajax({
  
  //         url: `${BASE_URL}/fiche/supprimer/${valeur}`,
  
  //         method: 'get',
  
  //         dataType: 'json',
  
  //         success: () => {
  
  //           $(document).trigger('reload-datatable');
  
  //           $.alert('La fiche a été supprimée avec succès');
  
  //         }
  
  //       });
  
  //     });
  
  //   });
  
  })