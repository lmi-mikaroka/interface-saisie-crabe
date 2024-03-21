$(() => {
  var datatable = $('#datatable').DataTable({
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
      url: BASE_URL + '/fiche-enquete/datatable',
      method: 'post',
    },
  });
})