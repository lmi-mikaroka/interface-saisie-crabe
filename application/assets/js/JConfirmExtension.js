function jConfirmRed(title, text, callback) {
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
    content: 'La suppression pourra entrainer la perte d\'autres données relatives à celle-ci.\nVeuillez confirmer la suppression',
    type: 'red',
    typeAnimated: true,
    buttons: {
      accept: {
        text: 'Supprimer',
        btnClass: 'btn-red',
        action: () => {
          callback();
        }
      },
      close: {
        text: 'annuler'
      }
    }
  })
}

function confirmerDeconnexion(callback) {
  $.confirm({
    title: 'Déconnexion!',
    closeIcon: true,
    draggable: true,
    useBootstrap: true,
    theme: 'bootstrap',
    animation: 'rotatex',
    closeAnimation: 'rotatex',
    animateFromElement: false,
    autoClose: 'close|5000',
    content: 'Êtes-vous sùr de mettre fin à cette session!',
    type: 'warning',
    typeAnimated: true,
    buttons: {
      accept: {
        text: 'me déconnecter',
        btnClass: 'btn-warning',
        action: () => {
          callback();
        }
      },
      close: {
        text: 'annuler'
      }
    }
  })
}

function JAlertSuccess(title, text) {
  $.alert({
    useBootstrap: true,
    title: title,
    content: text,
    type: 'success'
  })
}