$(document).ready(function () {    
    cargar_menu();
})

function cargar_menu(){
    let datos = {}

    datos = {
        /*email: email,*/
        accion: 'consulta',
        tipo: 'menuuser' 
    }
  
    //dato=email;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "./?action=_mainmenu",
        data: JSON.stringify(datos),
        error: function(xhr, status, error) {
         // check status && error
         console.error(error);
        },
        success: function(data) {
            //alert(data);
            
            $("#sidebar-menu").html(data.tablemenu);
            //$("#nombremenu").text(nombresubmenu);
        }
    });
                    
}

function hideMenu(){
    console.log('click menu');
    var bodyMenu = document.getElementById('bodyMenu');
    bodyMenu.classList.remove('nav-sm');
    bodyMenu.classList.add('nav-md');
}
