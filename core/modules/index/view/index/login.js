document.getElementById('password').addEventListener('keypress', function (event) {
    if (event.keyCode == 13) {
        event.preventDefault();
        var form_login = document.getElementById('guardar');
        form_login.click();
        console.log(form_login);
    }
});
var pickedup;
$(document).ready(function () {
    var consulta;

    //hacemos focus al campo de búsqueda
    $("#changeuser").focus();

    //comprobamos si se pulsa una tecla
    $("#botonchange").click(function (e) {

        //obtenemos el texto introducido en el campo de búsqueda
        //consulta = $("#busqueda").val();
        var dataString = $('#formchange').serialize();
        //hace la búsqueda


        $.ajax({
            type: "POST",
            url: "./?action=_changepassword",

            data: dataString,
            dataType: "html",
            beforeSend: function () {
                //imagen de carga
                $("#resultado").html("<p align='center'><img src='./res/ajax-loader.gif' /></p>");
            },
            error: function () {
                alert("error petición ajax");
            },
            success: function (data) {
                $("#changeuser").empty();
                $("#changepass").empty();
                $("#changepassnew").empty();
                alert(data);
                if (data != 'User and Password does not exist!!') {
                    $("#popupChangepasword").modal('hide');
                }
            }
        });
    });
});

function cancelar() {
    location.reload(true);
    //window.location = `./?view=home&page=home&action=null`
    //elemento = window.parent.document.name;
    //alert(elemento);
}

function validar() {
    let res = true
    

    $(".validar").each((pos, element) => {
        if($(element).val() == "") {
            $(element).parent().addClass("has-error")
            res = false
        }else{
            $(element).parent().removeClass("has-error")
        }
    })

    return res
}


function recopilar_datos() {
    let datos = {}

   
        datos = {
            user: $("#user").val(),
            password: $("#password").val(),
        }
   


    return datos
}



$("#guardar").click(() => {
    if (validar()) {
        const datos = recopilar_datos();
        //console.log(datos)
        //console.log(JSON.stringify(datos));
        $.ajax({
            type: "POST",
             dataType: "json",
             url: "./?view=index&page=widget-default&action=processlogin",
             data: JSON.stringify(datos),
           
            //data: datos,
            error: function(xhr, status, error) {
            // check status && error
            console.error(error);
             swal("Error, Usuario o clave errado!!", {
                        icon: "error",
                        timer: 3000
                    })
      },
      
            success: function (data) {
                //alert(data.email);
                //const res = JSON.parse(data)
               // alert(res);
                if (data.error!="" > 0) {
                   // console.error(res.error)
                    swal("Error, Usuario o clave errado!!", {
                        icon: "error",
                        timer: 3000
                    })
                } else {

                    swal("Bienvenido!", {
                            icon: "success",
                            timer: 3000
                        })
                        .then(() => {
                            cancelar()
                        })
                }
            }
        })
    } else {
        swal("FALTAN CAMPOS POR LLENAR", {
            icon: "error",
            timer: 2000
        })
    }
})

