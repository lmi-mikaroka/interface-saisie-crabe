$(() => {
  $('.js-bouton-supprimer').on('click', e => {
    const identifiant = $(e.currentTarget).attr('data-target');
    jConfirmRed('Supprimer la l\'enquête', 'La suppression de cette enquête pourra entraîner la perte d\'autres données relatives à celle-ci.\nVeuillez confirmer la suppression', () => {
      $.ajax({
        url: `${BASE_URL}/consultation-de-fiche-pecheur/detail-et-action/supprimer-enquete/${identifiant}`,
        method: 'get',
        dataType: 'json',
        success: () => {
          $.alert('La fiche de Pêcheur a été supprimée avec succès');
          location.reload();
        }
      });
    });
  });
})