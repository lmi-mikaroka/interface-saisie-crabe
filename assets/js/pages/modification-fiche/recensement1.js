const form={
    recensement:$('#js-recensement').val(),
    date:$('#js-date-enquete').val(),
    enqueteur:$('#js-enqueteur').val(),
}

function change_date(){
     form.date = $('#js-date-enquete').val();
}

function change_enqueteur(){
    form.enqueteur = $('#js-enqueteur').val();
}



$('#enregistrer').on('click',function(){
    console.log(form)
        if((form.date !=null)&&(form.enqueteur !='' || form.enqueteur !=null)){
                
                $.alert({
                    content: function () {
                        var self = this;
                        return $.ajax({
                            url: `${BASE_URL}/recensement/modification-recensement`,

                            data: form,

                            type: 'post',

                            dataType: 'json'
                        }).done(function (response){
                            if(response.result){
                                self.setContent(response.message)
                                self.setTitle(response.title)
                                setTimeout(() => location.href = `${BASE_URL}/consultation-de-recensement/detail-et-action/${response.fiche}.html`, 1000);
                            }else{
                                self.setContent(response.message)
                                self.setTitle(response.title)
                            }
                        }).fail(function() {
                            self.setContent('Une erreur a été rencontré, veuillez vérifier vos entrées ou contactez l\'administrateur')
                            self.setTitle('Erreur!')
                        })
                    }
                })
            
            

        }
        else{
            erreur("Il faut renseigner le fiche")
        }
   
  });

  function erreur(message){
    $.alert({
            title: "Erreur",
            content: message
        })
}
