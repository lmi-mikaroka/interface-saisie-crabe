const nb_enquete= $('#nombre_enquete').val()
const fiche = $('#fiche').val()
let form =[]
for(var i=0;i<nb_enquete;i++){
   var activite2 = null;
   var pourcentage2 = null;
   var activite3 = null;
   var pourcentage3 = null;
   var activite2_data =$(`#js-activite2${i}`).val();
   var pourcentage2_data =$(`#js-activite2-pourcent${i}`).val();
   var activite3_data =$(`#js-activite3${i}`).val();
   var pourcentage3_data =$(`#js-activite3-pourcent${i}`).val();
   if(activite2_data != ''){
    activite2=activite2_data;
   }
   if(pourcentage2_data != ''){
   pourcentage2=pourcentage2_data;
   }
   if(activite3_data != ''){
    activite3=activite3_data;
   }
   if(pourcentage3_data != ''){
   pourcentage3=pourcentage3_data;
   }
    form = [...form,
        {
            enquete_mensuel:$(`#js-enquete${i}`).val(),
            pecheur:$(`#pecheur${i}`).val(),
            crabe:$(`[name=js-crabe${i}]:checked`).val(),
            activite:{
                activite1:$(`#js-activite1${i}`).val(),
                pourcentage1:$(`#js-activite1-pourcent${i}`).val(),
                activite2:activite2,
                pourcentage2:pourcentage2,
                activite3:activite3,
                pourcentage3:pourcentage3
            }
        
        }]
}
function change_crabe(key){
    var val = $(`[name=js-crabe${key}]:checked`).val();
    if(val != form[key].crabe ){
        if(val != ''){
            var chaineoption = '<option value="" ></option>';
            var activites = ListeActivites();
            $.map(activites,function(a,b){
                if(val==0){
                if(a.id !=1){
                    chaineoption +=`<option value='${a.id}'>${a.nom}</option>`
                }
                
                }   
                else{
                    chaineoption +=`<option value='${a.id}'>${a.nom}</option>`
                }
            })
            $(`#js-activite1${key}`).html(chaineoption)
            $(`#js-activite2${key}`).html(chaineoption)
            $(`#js-activite3${key}`).html(chaineoption)

        }

        form[key].activite.activite1=null
        form[key].activite.activite2=null;
        form[key].activite.activite3=null;

    }
    form[key].crabe = $(`[name=js-crabe${key}]:checked`).val();
    warning(key)
     
}
function change_activite1(key){
    form[key].activite.activite1=null;
   var activite1 =  $(`#js-activite1${key}`).val()
   if(activite1 != ''){
    form[key].activite.activite1=activite1;
   }
   warning(key)
   if(activite1 != ''){
    $(`[name=js-activite2${key}] option`).prop('disabled',false).trigger('change');
    $(`[name=js-activite3${key}] option`).prop('disabled',false).trigger('change');
    $(`[name=js-activite2${key}]  option[value="${activite1}"]`).attr('disabled',true);
    $(`[name=js-activite3${key}]  option[value="${activite1}"]`).attr('disabled',true);
   }
     

}
function change_activite2(key){

    form[key].activite.activite2=null;
   var activite2 =  $(`#js-activite2${key}`).val()
   if(activite2 != ''){
    form[key].activite.activite2=activite2;
   }
   warning(key)
   var x = $(`[name=js-activite1${key}]`).val();
   if(x != '' && activite2 != ''){
    $(`[name=js-activite3${key}] option`).prop('disabled',false).trigger('change');
    $(`[name=js-activite3${key}]  option[value="${x}"]`).attr('disabled',true);
    $(`[name=js-activite3${key}]  option[value="${activite2}"]`).attr('disabled',true);
   }
   
    
}
function change_activite3(key){
    form[key].activite.activite3=null;
    var activite3 =  $(`#js-activite3${key}`).val()
    if(activite3 != ''){
     form[key].activite.activite3=activite3;
    } 
    warning(key)
}
function change_pourcentage1(key){
    form[key].activite.pourcentage1=null;
    var pourcentage1 =  $(`#js-activite1-pourcent${key}`).val()
    if(pourcentage1 != ''){
     form[key].activite.pourcentage1=pourcentage1;
    } 
    warning(key)
}
function change_pourcentage2(key){
    form[key].activite.pourcentage2=null;
    var pourcentage2 =  $(`#js-activite2-pourcent${key}`).val()
    if(pourcentage2 != ''){
     form[key].activite.pourcentage2=pourcentage2;
    }   
    warning(key)
}
function change_pourcentage3(key){
    form[key].activite.pourcentage3=null;
    var pourcentage3 =  $(`#js-activite3-pourcent${key}`).val()
    if(pourcentage3 != ''){
     form[key].activite.pourcentage3=pourcentage3;
    } 
    warning(key)
    
}

function check_info_enquete(){
    result = true;
    message ="Informations complètes";
    for(index=0;index<nb_enquete;index++){

        if( form[index].activite.activite1==null || form[index].activite.pourcentage1 == null ||(form[index].activite.activite2 != null && form[index].activite.pourcentage2==null) || (form[index].activite.activite2==null && form[index].activite.pourcentage2!=null) || (form[index].activite.activite3 != null && form[index].activite.pourcentage3==null)||(form[index].activite.activite3==null && form[index].activite.pourcentage3 != null)){
            result = false;
            message = "Veuillez vérifier vos entrées! il faut renseigner tous les champs obligatoires...";
        }
        warning(index)

    }
   
    return {"result":result, "message": message}
   }
function warning(index){
    if(form[index].activite.activite1 == null){
            $(`[name=js-activite1${index}]`).addClass('is-invalid');
    }
    else{
        $(`[name=js-activite1${index}]`).removeClass('is-invalid');
    }
    if(form[index].activite.pourcentage1 == null){
        $(`[name=js-activite1-pourcent${index}]`).addClass('is-invalid');
}
else{
    $(`[name=js-activite1-pourcent${index}]`).removeClass('is-invalid');
}
if(form[index].activite.activite2 != null && form[index].activite.pourcentage2 == null  ){
    $(`[name=js-activite2-pourcent${index}]`).addClass('is-invalid'); 
}
else{
    $(`[name=js-activite2-pourcent${index}]`).removeClass('is-invalid');
}
if(form[index].activite.activite2 == null && form[index].activite.pourcentage2 != null  ){
    $(`[name=js-activite2${index}]`).addClass('is-invalid'); 
}
else{
    $(`[name=js-activite2${index}]`).removeClass('is-invalid');
}
if(form[index].activite.activite3 != null && form[index].activite.pourcentage3 == null  ){
    $(`[name=js-activite3-pourcent${index}]`).addClass('is-invalid'); 
}
else{
    $(`[name=js-activite3-pourcent${index}]`).removeClass('is-invalid');
}
if(form[index].activite.activite3 == null && form[index].activite.pourcentage3 != null  ){
    $(`[name=js-activite3${index}]`).addClass('is-invalid'); 
}
else{
    $(`[name=js-activite3${index}]`).removeClass('is-invalid');
}

}
function ListeActivites(){
    
    let activites = [] ;
    $.ajax({

        method: 'post',

        data: {},

        url: `${BASE_URL}/activite/liste_tous`,

        dataType: 'json',

        async: false 

      }).done(function(data){

        for(let act of data){
            activites.push({id:act.id,nom:act.nom})
        }

      }).fail(function(f){

      });
    return activites; 

}
$('#enregistrer').click(function(){
    var result = check_info_enquete();
    if(result.result){
        $.alert({
            content: function () {
                var self = this;
                return $.ajax({
                    url: `${BASE_URL}/recensement-mensuel/modification-recensement-mensuel`,

                    data: {fiche:fiche,enquetes:form},

                    type: 'post',

                    dataType: 'json'
                }).done(function (response){
                    if(response.result){
                        self.setContent(response.message)
                        self.setTitle(response.title)
                        setTimeout(() => location.href = `${BASE_URL}/consultation-de-recensement-mensuel/detail-et-action/${response.fiche}.html`, 1000);
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
        erreur(result.message)
    }
})
function erreur(message){
    $.alert({
            title: "Erreur",
            content: message
        })
}
