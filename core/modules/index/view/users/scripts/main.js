function deleteUser(email){
    var url = "./?action=deleteUser";
    $('#tableUsers').DataTable({
        "scrollX": true
    });

    swal({
        title: "¿Estás seguro?",
        text: "Eliminaremos todos los accesos para este usuario",
        icon: "warning",
        buttons: ["CANCELAR", "ELIMINAR"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            let datos = {}
            datos = {
                "email" : email
            }
            $.ajax({
            type: "POST",
            url: url,
            data: datos,
            success: function(data){
                swal("Usuario eliminado", {
                    icon: "error",
                    timer: 2000
                });
                window.setTimeout(function() {  
                    location.href = "./?view=users&page=main&action=null";  
                    }, 1500);
            }
            });
        }
    });
}
