

    $('.append-select1').select2({
        tags:true,
        theme: 'bootstrap4',
        width: null,
        "language": {
            "noResults": function(){
                return "Aucun résultat";
            }
        },
    });
    $('.append-select').select2({
        
        theme: 'bootstrap4',
        width: null,
        "language": {
            "noResults": function(){
                return "Aucun résultat";
            }
        },
    });

    const tab1=['3','4','15','16','17']

    const tab2=['2','5','6','7','18']

    const form ={
        recensement:$('#js-recensement').val(),
        enquete_recensement:$('#js-enquete-recensement').val(),
        pecheur:null,
        resident:null,
        village_origine:null,
        nouveau_village_origine:0,
        nouveau_pecheur:0,
        sexe:null,
        age:null,
        pirogue:null,
        toute_annee:null,
        periode_mare:null,
        type_mare:null,
        periode_mois:null,
        engins:{
            engin1:null,
            annee1:null,
            engin2:null,
            annee2:null
        },
        activite:{
            activite1:null,
            pourcentage1:null,
            activite2:null,
            pourcentage2:null,
            activite3:null,
            pourcentage3:null
        },
    }
    //modification form

    var default_resident =$('#resident-par-defaut').val();
    form.resident=default_resident;
    if(default_resident==0){
        form.village_origine= $(`[name=js-village-origine]`).val();
    }
    form.pecheur=$(`[name=js-pecheur]`).val();
    form.sexe= $(`[name=js-sexe]:checked`).val();
    form.age= $(`[name=js-age]`).val();
    form.pirogue= $(`[name=js-pirogue]:checked`).val();
    form.toute_annee= $(`[name=js-toute-annee]:checked`).val();
    if(form.toute_annee==0){
            form.periode_mois= $(`#js-periode-mois`).val();   
    }
    form.engins.engin1=$(`[name=js-engin1]`).val();
    form.engins.annee1=$(`[name=js-annee1]`).val();
    if($(`[name=js-engin2]`).val()!=''){
        form.engins.engin2= $(`[name=js-engin2]`).val();
        form.engins.annee2= $(`[name=js-annee2]`).val();
    }
    form.activite.activite1=$(`[name=js-activite1]`).val();
    form.activite.pourcentage1=$(`[name=js-activite1-pourcent]`).val();
    if($(`[name=js-activite2]`).val()!=''){
        form.activite.activite2=$(`[name=js-activite2]`).val();
        form.activite.pourcentage2=$(`[name=js-activite2-pourcent]`).val();
    }
    if($(`[name=js-activite3]`).val()!=''){
        form.activite.activite3=$(`[name=js-activite3]`).val();
        form.activite.pourcentage3=$(`[name=js-activite3-pourcent]`).val();
    }
    recupereMare(form.engins.engin1,form.engins.engin2);
    console.log(form)
    

    function change_resident(){
        var val = $(`[name=js-resident]:checked`).val();
        form.resident=val;
        if(val==1){
            
            $('#div-village-origine').hide();
            pecheurs = ListePecheur($('#js-recensement-village').val());
            chainePecheur = '<option value="" selected hidden></option>'; 
            $.map(pecheurs,function(a,b){
                chainePecheur += `<option value="${a.idpecheur}">${a.nom}</option>`
            });

            $('[name=js-pecheur]').html(chainePecheur);
            // $('#div-crabe-toute-annee').show();
           
        }
        else{
            $(`[name=js-village-origine]`).val('').trigger('change')
            $(`[name=js-pecheur]`).empty().trigger('change')
            $('#div-village-origine').show(); 
            // $('#div-crabe-toute-annee').hide();
            form.toute_annee=0; 
        }
    }

    function change_village_origine(){
        var val = $(`[name=js-village-origine]`).val();
        if(val !=''){
            chainePecheur = '<option value="" selected hidden></option>'; 
            if(parseInt(val)>0){
                form.nouveau_village_origine =0;
                pecheurs = ListePecheur(val);
                $.map(pecheurs,function(a,b){
                    chainePecheur += `<option value="${a.idpecheur}">${a.nom}</option>`
                });
            }
            else{
                form.nouveau_village_origine =1;
            }
            form.village_origine=val;
            form.pecheur=null;
            $('[name=js-pecheur').html(chainePecheur);
        }
        else{

            form.village_origine=null; 
        }
        
    }

    function change_pecheur(){
        form.pecheur=$('[name=js-pecheur').val();
        var val_pecheur = $('[name=js-pecheur').val();
        const  date_aujourdhui = new Date();
        if(val_pecheur !=''){
            if(parseInt(val_pecheur)>0){
                form.nouveau_pecheur=0;
                detail_pecheur(val_pecheur).then(pecheur => {
                
                    $('[name=js-sexe]').prop('checked',false).trigger('change');
                    if(pecheur['sexe']!=null){
                        form.sexe=pecheur['sexe'];
                    }
                    else{
                        form.sexe=null; 
                    }
                    $('[name=js-sexe]').filter('[value='+ pecheur['sexe'] +']').prop('checked', true);

                    if(parseInt(pecheur['datenais'])!=null){
                        form.age=date_aujourdhui.getFullYear()- parseInt(pecheur['datenais']);
                        $('[name=js-age]').val( date_aujourdhui.getFullYear()- parseInt(pecheur['datenais']));
                    }
                    else{
                        $('[name=js-age]').val(null);
                        form.age=null;
                    }
                
                    
            
                }).finally(() => {
            
                    
            
                })
            }
            else{
                form.nouveau_pecheur=1;
                form.sexe=null;
                form.age=null;
                $('[name=js-sexe]').prop('checked',false).trigger('change');
                $('[name=js-age]').val(null);


            }
        }
    
    }

    function change_sexe(){
        form.sexe = $(`[name=js-sexe]:checked`).val();
        
    }

    function change_age(){
        form.age= $(`[name=js-age]`).val();
        
    }
    
    function change_toute_annee(){
        
        form.toute_annee = $(`[name=js-toute-annee]:checked`).val();
        var toute_annee= $(`[name=js-toute-annee]:checked`).val();
        if(toute_annee==1){
            // $(`#div-periode`).hide();
            $(`#div-periode-mois`).hide();
            // $(`#div-periode-mare`).hide();
            form.periode_mois=null;
    
        }
        else{
            $(`#div-periode-mois`).show();
        }
    
        
        
        
    }
    
    function change_pirogue(){
        
        form.pirogue = $(`[name=js-pirogue]:checked`).val();
        
        
    }
    
    function change_engin1(){
        
        form.engins.engin1 = null;
        var x = $(`[name=js-engin1]`).val();
        $(`[name=js-js-engin2] option`).prop('disabled',false).trigger('change');
        $(`[name=js-engin2]  option[value="${x}"]`).attr('disabled',true);
        if(x != ''){
            form.engins.engin1 = $(`[name=js-engin1]`).val();
        }
        recupereMare(form.engins.engin1,form.engins.engin2);
        warning()    
        
    }
    function change_engin2(){
        
        form.engins.engin2 = null;
        var val = $(`[name=js-engin2]`).val();
        if(val !=''){
            form.engins.engin2 = $(`[name=js-engin2]`).val();  
        }

        recupereMare(form.engins.engin1,form.engins.engin2);
        warning()  
    }
    function change_annee1(){
        form.engins.annee1 = null;
        var annee1 = $(`[name=js-annee1]`).val();
        if(annee1 != ''){
            form.engins.annee1 = annee1 
        }
        warning()
    }
    
    function change_annee2(){   
        form.engins.annee2 = null;
        var annee2 = $(`[name=js-annee2]`).val();
        if(annee2 != ''){
            form.engins.annee2 = annee2 
        }
        warning()
      
    }
    function change_activite1(){
        
        form.activite.activite1 = null;
        
        var x = $(`[name=js-activite1]`).val();
        $(`[name=js-activite2] option`).prop('disabled',false).trigger('change');
        $(`[name=js-activite3] option`).prop('disabled',false).trigger('change');
        $(`[name=js-activite2]  option[value="${x}"]`).attr('disabled',true);
        $(`[name=js-activite3]  option[value="${x}"]`).attr('disabled',true);
        if(x != ''){
            form.activite.activite1 = $(`[name=js-activite1]`).val();
        }
        warning()
          
         
      
    }
    
    function change_activite2(){
        var act2 = $(`[name=js-activite2]`).val();
        form.activite.activite2 = null;
        var x = $(`[name=js-activite1]`).val();
        var x2 = $(`[name=js-activite2]`).val();
          $(`[name=js-activite3] option`).prop('disabled',false).trigger('change');
          $(`[name=js-activite3]  option[value="${x}"]`).attr('disabled',true);
          $(`[name=js-activite3]  option[value="${x2}"]`).attr('disabled',true);
          if(act2 != ''){
            form.activite.activite2 = $(`[name=js-activite2]`).val();
        }
        warning()
        
      
    }
    
    function change_activite3(){
        var act3 = $(`[name=js-activite3]`).val();
        form.activite.activite3 = null;
        if(act3 != ''){
            form.activite.activite3 = $(`[name=js-activite3]`).val();
        }
        warning()
        
        
      
    }
    
    function change_pourcentage1(){
        form.activite.pourcentage1 = null;
        var pourcentage1 = $(`[name=js-activite1-pourcent]`).val();
        if(pourcentage1 != ''){
            form.activite.pourcentage1 = pourcentage1; 
        }
        warning()
           
    }
    function change_pourcentage2(){
        var p2 = $(`[name=js-activite2-pourcent]`).val();
        form.activite.pourcentage2 = null;
        if(p2 != ''){
            form.activite.pourcentage2 = $(`[name=js-activite2-pourcent]`).val();
        }
        warning()
        
           
    }
    function change_pourcentage3(){
        var p3= $(`[name=js-activite3-pourcent]`).val();
        if(p3 !=''){
            form.activite.pourcentage3 = $(`[name=js-activite3-pourcent]`).val();
        }
        else{
            form.activite.pourcentage3 = null;
        }
        warning()
          
          
    }
   
    
     function change_valeur_periode_mois(){
        var valeur = $(`#js-periode-mois`).val();
        form.periode_mois=null;
         if(valeur.length>0){
             form.periode_mois=valeur;
         }
        warning()
        
        
     }

    function ListePecheur(village){


        var pecheurss = [];
        
        $.ajax({
    
            method: 'post',
    
            data: {village:village},
    
            url: `${BASE_URL}/pecheur/liste-pecheur-village-origine`,
    
            dataType: 'json',
    
            async: false ,
    
          }).done(function(data){
            
            
            for(var i=0;i<data.length;i++){
                
                pecheurss.push({idpecheur:data[i].id,nom:data[i].nom});
            }
    
          }).fail(function(f){})
    
          return pecheurss;
    
    }

    $('#enregistrer').on('click',function(){

        warning();
                result = {"result": check_info_enquete().result, "message": check_info_enquete().message};
                if(result.result){
                    
                    $.alert({
                        content: function () {
                            var self = this;
                            return $.ajax({
                                url: `${BASE_URL}/recensement/modification-enquete`,
    
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
                    erreur(result.message)
                }

            
        
    })

    function erreur(message){
        $.alert({
                title: "Erreur",
                content: message
            })
    }

    function check_info_enquete(){
        result = true;
        message ="Informations complètes";
        if(form.resident==null || (form.resident==0 && form.village_origine == null )|| form.age == null || form.sexe==null || form.pirogue==null || form.toute_annee==null || form.type_mare==null || (form.toute_annee==0 && form.periode_mois==null) || form.engins.engin1==null || form.engins.annee1==null || form.activite.activite1==null || form.activite.pourcentage1 == null ||(parseInt(form.activite.activite2)>0 && (form.activite.pourcentage2==null||form.activite.pourcentage2=='') )||(parseInt(form.activite.activite3)>0 && (form.activite.pourcentage3==null||form.activite.pourcentage3 =='') )||(parseFloat(form.activite.pourcentage3)>0 && (form.activite.activite3==null||form.activite.activite3=='') )||(parseInt(form.engins.engin2)>0 && (form.engins.annee2==null||form.activite.annee2 =='') )||(parseInt(form.engins.annee2)>0 && (form.engins.engin2==null||form.engins.engin2 =='') ) ){
                result = false;
                message = "Veuillez vérifier vos entrées! il faut renseigner les champs obligatoires...";
            }
        return {"result":result, "message": message}
       }

       function warning(){

        invalideChamp();
        
        
    }

    function invalideChamp(){
        if(form.resident ==0){
            if(form.village_origine==null){
                $(`[name=js-village-origine]`).addClass('is-invalid');
            }
            else{
                $(`[name=js-village-origine]`).removeClass('is-invalid');
            }
        }
        if(form.pecheur ==null){
            $(`[name=js-pecheur]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-pecheur]`).removeClass('is-invalid');
        }
        if(form.age ==null){
            $(`[name=js-age]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-age]`).removeClass('is-invalid');
        }
        if(form.engins.engin1 ==null){
            $(`[name=js-engin1]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-engin1]`).removeClass('is-invalid');
        }
        if(form.engins.annee1 ==null){
            $(`[name=js-annee1]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-annee1]`).removeClass('is-invalid');
        }
        if(( form.engins.engin2 !=null && form.engins.annee2 ==null)){
            $(`[name=js-annee2]`).addClass('is-invalid');
        }else{
            $(`[name=js-annee2]`).removeClass('is-invalid');
        }
    
        if(( form.engins.engin2 ==null && form.engins.annee2 !=null)){
            $(`[name=js-engin2]`).addClass('is-invalid');
        }else{
            $(`[name=js-engin2]`).removeClass('is-invalid');
        }
        
        if(form.activite.activite1 ==null){
            $(`[name=js-activite1]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-activite1]`).removeClass('is-invalid');
        }
        if(form.activite.pourcentage1 ==null){
            $(`[name=js-activite1-pourcent]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-activite1-pourcent]`).removeClass('is-invalid');
        }
        if(  parseInt(form.activite.activite2)>0 && form.activite.pourcentage2 ==null){
            $(`[name=js-activite2-pourcent]`).addClass('is-invalid');
        }else{
            $(`[name=js-activite2-pourcent]`).removeClass('is-invalid');
        }
        if(( form.activite.activite2 ==null && form.activite.pourcentage2 !=null)){
            $(`[name=js-activite2]`).addClass('is-invalid');
        }else{
            $(`[name=js-activite2]`).removeClass('is-invalid');
        }
        if(( parseInt(form.activite.activite3)>0  && form.activite.pourcentage3 ==null)){
            $(`[name=js-activite3-pourcent]`).addClass('is-invalid');
        }else{
            $(`[name=js-activite3-pourcent]`).removeClass('is-invalid');
        }
        if(( form.activite.activite3 ==null && form.activite.pourcentage3 !=null)){
            $(`[name=js-activite3]`).addClass('is-invalid');
        }else{
            $(`[name=js-activite3]`).removeClass('is-invalid');
        }
    }

    function warning(){
        $(`#warning`).html("");
            if(form.resident==null || (form.resident==0 && form.village_origine == null )|| form.age == null || form.sexe==null || form.pirogue==null || form.toute_annee==null || form.type_mare==null || (form.toute_annee==0 && form.periode_mois==null) || form.engins.engin1==null || form.engins.annee1==null || form.activite.activite1==null || form.activite.pourcentage1 == null ||(parseInt(form.activite.activite2)>0 && (form.activite.pourcentage2==null||form.activite.pourcentage2=='') )||(parseInt(form.activite.activite3)>0 && (form.activite.pourcentage3==null||form.activite.pourcentage3 =='') )||(parseFloat(form.activite.pourcentage3)>0 && (form.activite.activite3==null||form.activite.activite3=='') )||(parseInt(form.engins.engin2)>0 && (form.engins.annee2==null||form.activite.annee2 =='') )||(parseInt(form.engins.annee2)>0 && (form.engins.engin2==null||form.engins.engin2 =='') ) ){
                $(`#warning`).html(`<span class="badge badge-danger"><i class="fa fa-times"></i> veuillez saisir ou corriger toutes les informations</badge>`)
            }
        invalideChamp();
        
        
    }
    function invalideChamp(){
        if(form.resident ==0){
            if(form.village_origine==null){
                $(`[name=js-village-origine]`).addClass('is-invalid');
            }
            else{
                $(`[name=js-village-origine]`).removeClass('is-invalid');
            }
        }
        if(form.pecheur ==null){
            $(`[name=js-pecheur]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-pecheur]`).removeClass('is-invalid');
        }
        if(form.age ==null){
            $(`[name=js-age]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-age]`).removeClass('is-invalid');
        }
        if(form.engins.engin1 ==null){
            $(`[name=js-engin1]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-engin1]`).removeClass('is-invalid');
        }
        if(form.engins.annee1 ==null){
            $(`[name=js-annee1]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-annee1]`).removeClass('is-invalid');
        }
        if(( form.engins.engin2 !=null && form.engins.annee2 ==null)){
            $(`[name=js-annee2]`).addClass('is-invalid');
        }else{
            $(`[name=js-annee2]`).removeClass('is-invalid');
        }
    
        if(( form.engins.engin2 ==null && form.engins.annee2>0)){
            $(`[name=js-engin2]`).addClass('is-invalid');
        }else{
            $(`[name=js-engin2]`).removeClass('is-invalid');
        }
        
        if(form.activite.activite1 ==null){
            $(`[name=js-activite1]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-activite1]`).removeClass('is-invalid');
        }
        if(form.activite.pourcentage1 ==null){
            $(`[name=js-activite1-pourcent]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-activite1-pourcent]`).removeClass('is-invalid');
        }
        if(  parseInt(form.activite.activite2)>0 && form.activite.pourcentage2 ==null){
            $(`[name=js-activite2-pourcent]`).addClass('is-invalid');
        }else{
            $(`[name=js-activite2-pourcent]`).removeClass('is-invalid');
        }
        if(( form.activite.activite2 ==null && parseFloat(form.activite.pourcentage2)>0)){
            $(`[name=js-activite2]`).addClass('is-invalid');
        }else{
            $(`[name=js-activite2]`).removeClass('is-invalid');
        }
        if(( parseInt(form.activite.activite3)>0  && form.activite.pourcentage3 ==null)){
            $(`[name=js-activite3-pourcent]`).addClass('is-invalid');
        }else{
            $(`[name=js-activite3-pourcent]`).removeClass('is-invalid');
        }
        if(( form.activite.activite3 ==null && parseFloat(form.activite.pourcentage3)>0)){
            $(`[name=js-activite3]`).addClass('is-invalid');
        }else{
            $(`[name=js-activite3]`).removeClass('is-invalid');
        }
    
        if (form.type_mare == null){
            $(`[name=js-periode-mare]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-periode-mare]`).removeClass('is-invalid');
        }
    
        if((form.toute_annee==0) && (form.periode_mois ==null)){
            $(`[name=js-periode-mois]`).addClass('is-invalid');
        }
        else{
            $(`[name=js-periode-mois]`).removeClass('is-invalid');
        }
    
    
        if(form.sexe ==null){
            $(`#warning-sexe`).html(`<span class="badge badge-danger"><i class="fa fa-times"></i> </badge>`);   
        }
        else{
            $(`#warning-sexe`).html('');
        }
    }

    function recupereMare(engin1,engin2){
        var engin1tab1 = tab1.indexOf(engin1);
        var engin2tab1 = tab1.indexOf(engin2);
        
        var engin1tab2 = tab2.indexOf(engin1);
        var engin2tab2 = tab2.indexOf(engin2);
        
        var type_engin1 = null;
        var type_engin2 = null;
        var type_mare = null;
        
        if(engin1 != null && engin1 != ''  ){
        
          if(engin1tab1>=0){ type_engin1 = 0 }
          if(engin1tab2>=0){
            type_engin1 =  1;
            
        }
        }
        if(engin2 != null && engin2 != ''  ){
        
          if(engin2tab1>=0){ type_engin2 = 0}
          if(engin2tab2>=0){type_engin2 = 1}
        }
        
        if(type_engin1 == null && type_engin2 == null) {
         type_mare=null;
        }
        
        if(type_engin1 != null && type_engin2 == null) {
            type_mare=type_engin1;
        }
        if(type_engin2 != null && type_engin1 == null) {
            type_mare=type_engin2;
        }
        if(type_engin2 != null && type_engin1 != null)
        {
         if(type_engin2==type_engin1)
         {type_mare=type_engin1}
        else{type_mare=2}
        }
        if(type_mare == null){
        form.type_mare=null;
        }
        if(type_mare == 0){
        form.type_mare = 'Mortes eaux';
        }
        if(type_mare == 1){
        form.type_mare='Vives eaux';
        }
        if(type_mare == 2){
        form.type_mare='Toutes marées';
        }
        
        }
  
    
