/*The account radio buttons*/
$(function(){
    $('input[type=radio][name=account]').change(function(){
        if(this.value == 'appraisee'){
            //alert('Switching account mode to Appraisee');
            $('#switch-modal').modal('show')
                .find('#modal-content')
                .html('<span>Switching account mode to Appraisee ...</span>');
            $.post('/site/switchaccount',{'type':2}).done(function(res){
                if(res.message == 1){

                    $('#switch-modal').modal('show')
                        .find('#modal-content')
                        .html('<p class="alert alert-success">'+res.action+'</p>');
                }
                else{
                    $('#switch-modal').modal('show')
                        .find('#modal-content')
                        .html('<span>'+res.action+'</span>');
                }
            });
        }
        if(this.value == 'supervisor'){
            //alert('Switching account mode to Supervisor');
            $('#switch-modal').modal('show')
                .find('#modal-content')
                .html('<span>Switching Account mode to Supervisor...</span>');
            $.post('/site/switchaccount',{'type':1}).done(function(res){
                if(res.message == 1){

                    $('#switch-modal').modal('show')
                        .find('#modal-content')
                        .html('<p class="alert alert-success">'+res.action+'</p>');
                }
                else{
                    $('#switch-modal').modal('show')
                        .find('#modal-content')
                        .html('<span>'+res.action+'</span>');
                }
            });
        }
    });//end account switching js

    //control event after modal is dismissed
    $('#switch-modal').on('hidden.bs.modal',function(){
        //var reld = location.reload(true);
        var reld = location.href ="/site";
        setTimeout(reld,500);
    });
});/*The account radio buttons*/
$(function(){
    $('input[type=radio][name=account]').change(function(){
        if(this.value == 'appraisee'){
            //alert('Switching account mode to Appraisee');
            $('#switch-modal').modal('show')
                .find('#modal-content')
                .html('<span>Switching account mode to Appraisee ...</span>');
            $.post('/site/switchaccount',{'type':2}).done(function(res){
                if(res.message == 1){

                    $('#switch-modal').modal('show')
                        .find('#modal-content')
                        .html('<p class="alert alert-success">'+res.action+'</p>');
                }
                else{
                    $('#switch-modal').modal('show')
                        .find('#modal-content')
                        .html('<span>'+res.action+'</span>');
                }
            });
        }
        if(this.value == 'supervisor'){
            //alert('Switching account mode to Supervisor');
            $('#switch-modal').modal('show')
                .find('#modal-content')
                .html('<span>Switching Account mode to Supervisor...</span>');
            $.post('/site/switchaccount',{'type':1}).done(function(res){
                if(res.message == 1){

                    $('#switch-modal').modal('show')
                        .find('#modal-content')
                        .html('<p class="alert alert-success">'+res.action+'</p>');
                }
                else{
                    $('#switch-modal').modal('show')
                        .find('#modal-content')
                        .html('<span>'+res.action+'</span>');
                }
            });
        }
    });//end account switching js

    //control event after modal is dismissed
    $('#switch-modal').on('hidden.bs.modal',function(){
        //var reld = location.reload(true);
        var reld = location.href ="/site";
        setTimeout(reld,500);
    });
});