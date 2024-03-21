 $("#upload").click(function (e) {
        e.preventDefault();
        var form_Data = new FormData($('#upload_form')[0]);
        $.alert({
            content: function() {
                var self = this;
                return jQuery.ajax({
                    type: "POST",
                    url: `${BASE_URL}/ImportController/recuperer`,
                    data: form_Data,
                    processData: false,
                    contentType: false,
                    dataType: 'json'
                }).done(function (response){
                    if(response.result){
                        self.setContent(response.message)
                        self.setTitle(response.titre)
                    }else{
                        self.setContent(response.message)
                        self.setTitle(response.titre)
                    }
                }).fail(function() {
                    self.setContent('Une erreur a été rencontré, veuillez vérifier vos entrées ou contactez l\'administrateur')
                    self.setTitle('Erreur!')
                })
            }
        })
    })