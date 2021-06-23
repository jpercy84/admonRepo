$( document ).ready(function() {

    $("#formCreateUser").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
    
        var form = $(this);
        var url = "./?action=registerUser";
        
        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data){
                    swal("Usuario agregado", {
                        icon: "info",
                        timer: 2000
                    });
                    window.setTimeout(function() {  
                        location.href = "./?view=users&page=main&action=null";  
                        }, 1500);
               }
               ,
               error: function(error){
                    swal("Email ya registrado", {
                        icon: "error",
                        timer: 2000
                    });
               }
             });
    
        
    });

});