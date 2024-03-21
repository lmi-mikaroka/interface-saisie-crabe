$(() => {


  $('#historiqueTable').DataTable();

  $('#js-nettoyer-historique').on('click', e => {

    e.preventDefault()

    $.confirm({

      title: 'Suppression!',

      closeIcon: true,

      draggable: true,

      useBootstrap: true,

      theme: 'bootstrap',

      animation: 'rotatex',

      closeAnimation: 'rotatex',

      animateFromElement: false,

      autoClose: 'close|5000',

      content: 'Voulez-vous vraiment nettoyer l\'historique de navigations?',

      type: 'red',

      typeAnimated: true,

      buttons: {

        accept: {

          text: 'Confirmer',

          btnClass: 'btn-red',

          action: () => {

            window.location = `${BASE_URL}/historique/nettoyer.html`

          }

        },

        close: {

          text: 'Annuler'

        }

      }

    })

  })

})