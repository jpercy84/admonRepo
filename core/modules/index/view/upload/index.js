$(document).ready(function () {
    cargar_rejilla()  //Cargar table de perfiles generales en /perfiles/index.php
})

function cargar_rejilla() {
    let timeOut = null

    let datos = {}

    datos = {
        accion: 'consultagral' 
    }

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "./?action=_perfiles",
        data: JSON.stringify(datos),
        error: function(xhr, status, error) {
         // check status && error
         console.error(error);
        },
        beforeSend: function(){
            //timeOut = inicioCarga()
        },
        complete: function(){
            //finCarga(timeOut)
        },
        success: function (data) {
            //const res = JSON.parse(data)
            
            const contenedor = $("#lista");

            contenedor.append(data.tableperfil);
           
            $('#datatable-perfil').DataTable({
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
               "order": [[ 1, "desc" ]],
              "info": true,
              "autoWidth": true,
              "responsive": true,
              // Botones para exportar a excel, pdf u otro
              dom: 'Blfrtip',buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                // Botones para mostar numero de registros
              "lengthMenu": [[10,30,50,80,100,120, -1], [10,30,50,80,100,120, "All"]]
                            });
            /*res.map(perfil => {
                
                generar_html_perfiles(perfil.idperfil, perfil.nombre)
                
            })*/
        }
    })
}


function ver_perfil(idperfil){
    
   let datos = {}

      datos = {
           accion: 'consulta',
           idperfil: idperfil 
      }

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "./?action=_perfiles",
        data: JSON.stringify(datos),
        error: function(xhr, status, error) {
         // check status && error
         console.error(error);
        },
        beforeSend: function(){
            //timeOut = inicioCarga()
        },
        complete: function(){
            //finCarga(timeOut)
        },
        success: function (data) {
            //const res = JSON.parse(data)
            const contenedortitle = $("#title");
            contenedortitle.empty();
            contenedortitle.append("Ver detalles Perfil");
            const contenedor = $("#contenido");
            contenedor.empty();
            contenedor.append(data.tableperfil);
           
           
           
        }
    })

    
}

/*
function ver_perfil(idperfil){
    
   let datos = {}

      datos = {
           accion: 'consulta',
           idperfil: idperfil 
      }

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "./?action=_perfiles",
        data: JSON.stringify(datos),
        error: function(xhr, status, error) {
         // check status && error
         console.error(error);
        },
        beforeSend: function(){
            //timeOut = inicioCarga()
        },
        complete: function(){
            //finCarga(timeOut)
        },
        success: function (data) {
            //const res = JSON.parse(data)
            const contenedortitle = $("#title");
            contenedortitle.empty();
            contenedortitle.append("Ver detalles Perfil");
            const contenedor = $("#contenido");
            contenedor.empty();
            contenedor.append(data.tableperfil);
           
           
           
        }
    })

    
}
*/

function cancelar() {
    //window.location = `./?view=perfiles&page=index&action=null`
    location.reload(true);
}


function actualizar_perfil(idperfil) {
    location.href = `./?view=perfiles&page=nuevo_perfil&action=null&idperfil=${idperfil}`
}

function eliminar_perfil(idperfil){
    swal({
        title: "ESTAS SEGURO?",
        text: "UNA VEZ BORRADO NO PUEDE RECUPERARSE!",
        icon: "warning",
        buttons: ["CANCELAR", "ELIMINAR"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
                 let datos = {}
                  datos = {
                       accion: 'eliminar',
                       idperfil: idperfil 
                  } 
            $.ajax({
                type: "POST",
                url: "./?action=_perfiles",
                data: JSON.stringify(datos),
                error: function(xhr, status, error) {
                 // check status && error
                 console.error(error);
                },
                beforeSend: function(){
                    //timeOut = inicioCarga()
                },
                complete: function(){
                    //finCarga(timeOut)
                },
                success: function (data) {
                    //const res = JSON.parse(data)
                     swal("PERFIL ELIMINADOO!", {
                            icon: "success",
                            timer: 3000
                        })
                        .then(() => {
                            cancelar()
                        })
                    /*if(res.error.length > 0){
                        console.error(res.error)
                        swal("EL CLIENTE NO PUDO SER ELIMINADO!", {
                            icon: "error",
                            timer: 3000
                        })
                    }else{
                        $(`#cliente${codcliente}`).remove()

                        swal("CLIENTE ELIMINADO!", {
                            icon: "success",
                            timer: 3000
                        })
                    }*/
                },
                error: function (e) {
                    console.error(`Error: ${e}`)
                }
            })
        }
    })
}


