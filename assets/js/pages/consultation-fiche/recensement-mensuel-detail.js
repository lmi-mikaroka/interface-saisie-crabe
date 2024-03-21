


    var choix_multiple = [];

    var datatable = $('#datatable').DataTable({
  
      language: {url: BASE_URL + '/assets/datatable-fr.json'},
  
      processing: true,
  
      paging: true,
  
      lengthChange: true,
  
      searching: true,
  
      ordering: true,
  
      info: true,
  
      autoWidth: true,
  
      responsive: true,
      columnDefs: [
          {
              
              orderable: false,
              targets: [1, 2, 3,4,5,6,7,8,9],
          },
      ],
  
      
  
    });

    $('#datatable tbody').on('click', '.delete-button', function() {

      const valeur = $(this).attr('data-target');
      
  
      jConfirmRed('Supprimer la sélection', 'La suppression pourra entraîner la perte d\'autres données relatives à celle-ci.\nVeuillez confirmer la suppression', () => {
  
        $.ajax({
  
          url: `${BASE_URL}/recensement-mensuel/suppression-enquete/${valeur}`,
  
          method: 'get',
  
          dataType: 'json',
  
          success: () => {
  
  
            $.alert('La fiche a été supprimée avec succès');
            datatable.row( $(this).parents('tr') ).remove().draw(false);
  
          }
  
        });
  
      });
  
    });

    $('#btn_multiple').on('click',function(){
      if(choix_multiple.length>0){
        var lien_val ='';
        var arret = choix_multiple.length -1;
        for(var i =0; i<choix_multiple.length;i++){
          lien_val +=choix_multiple[i];
          if(i<arret){
            lien_val +='_';
          }
          
        }
        location.href = `${BASE_URL}/consultation-de-recensement-mensuel/modification-enquete/${lien_val}`;
      }
      
     else{
      $.alert({
        title: "Informations",
        content: "Veuillez cocher au moins une enquete..."
    })
     }
      
    })
    
  


    function recupValeurs(donnees) {
      let index = choix_multiple.indexOf(donnees);
      if(index<0){
        choix_multiple =[...choix_multiple,donnees];
      }
      else{
        choix_multiple.splice(index,1);
      }
      

      // var cases = $(`[name=modification-check]`);
      // var resultat = [];
      //    for (var i = 0; i < cases.length; i++) {
      //       if (cases[i].checked) {
      //          resultat =[...resultat,parseInt(cases[i].getAttribute('id'))];
      //       }
      //    }
      
    }

    
  
  