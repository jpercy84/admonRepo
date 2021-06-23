function goBack(){
    window.history.back();
}
$( document ).ready(function() {

    let searchParams = new URLSearchParams(window.location.search);
    let param = searchParams.get('email')
    dictForm = {"Correo electrónico": "email", "Primer nombre": "pNombre", "Segundo nombre": "sNombre",
                "Sexo": "sexo", "Perfil":"perfil", "Primer apellido": "pApellido", "Segundo apellido": "sApellido",
                "saveEmail": "savedEmail"};

    let url = "./?action=updateUser";
    let datos = {};
  

    
    $("#btnSubmit").click(() => {
        
    })
    datos = {
        "email" : param
    }
    $.ajax({
        type: "POST",
        url: url,
        data: datos,
        success: function(data){
            
            $('info').empty();


            const form = document.createElement('form');
            form.setAttribute("id", "formUpdate");
            form.method = "post";
            form.classList.add('form-group');
            const btn = document.createElement('BUTTON');
            btn.type= "submit";
            btn.classList.add('btn');
            btn.classList.add('btn-outline-success');
            btn.classList.add('btn-block');
            btn.setAttribute("id", "btnSubmit");
            btn.innerHTML = "Actualizar Usuario";

            for (var key in data) {
                const label = document.createElement('label');
                var br = document.createElement("BR");
                var br1 = document.createElement("BR");
                var br2 = document.createElement("BR");  


                if (key != 'Perfil' && key != 'Sexo'){
                    const input = document.createElement('input');
                    if (key == 'Primer nombre' || key == 'Primer apellido'){
                        input.required = true;
                    }
                    input.setAttribute("type", "text");
                    input.setAttribute("value", data[key]);
                    input.setAttribute("name", dictForm[key])
                    input.setAttribute("class", "form-control");
                    form.append(label,br1 ,input, br, br2);
                }

                else{
                    const select = document.createElement('SELECT');
                    select.setAttribute("name", dictForm[key]);
                    select.setAttribute("class", "form-control");
                    var dictProfiles = {"Administrador": 1, "General": 2};
                    if(key == 'Perfil'){
                        var profiles = ['Administrador', 'General'];
                        var filterProfiles = profiles.filter(function(profile){
                            if (profile != data[key]){
                                return profile;
                            }
                        });
                    
                    var option1 = document.createElement('OPTION');
                    option1.setAttribute('value', dictProfiles[data[key]]);
                    option1.setAttribute('selected', 'selected');
                    option1.innerHTML = data[key];
                    const option2 = document.createElement('OPTION');
                    option2.setAttribute('value', dictProfiles[filterProfiles[0]]);
                    option2.innerHTML = filterProfiles[0];
                    select.append(option1, option2);
                    form.append(label, br1, select, br2, br)
                    }
                    else{
                        var sexos = ['m', 'f', 'o']
                        var dictSexos = {"m": 'Masculino', 'f':'Femenino', 'o':'Otro'};
                        var filterSex = sexos.filter(function(sex){
                            if (sex != data[key]){
                                return sex;
                            }
                        });
                        var option1 = document.createElement('OPTION');
                        option1.setAttribute('value', data[key]);
                        option1.setAttribute('selected', 'selected');
                        option1.innerHTML = dictSexos[data[key]];
                        select.append(option1);

                        for (var sexo in filterSex){
                            console.log(sexo);
                            var opt = document.createElement('OPTION');
                            opt.setAttribute('value', filterSex[sexo]);
                            opt.innerHTML = dictSexos[filterSex[sexo]];
                            select.append(opt);
                        }

                    form.append(label, br1, select, br2, br)
                    }


                }
                label.innerHTML = key;

            }
            const savedEmail = document.createElement('input');
            savedEmail.setAttribute('name', 'savedEmail');
            savedEmail.setAttribute('value', param);
            savedEmail.setAttribute('type', 'hidden');
            form.append(savedEmail);

            form.append(btn);        
            
            document.getElementById("info").append(form)
            


            $("#formUpdate").submit(function(e){
                console.log("submit form");
                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var url = "./?action=updateInfoUser";
                
                $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(), // serializes the form's elements.
                        success: function(data){
                            swal("Usuario actualizado", {
                                icon: "info",
                                timer: 2000
                            });
                            window.setTimeout(function() {  
                                location.href = "./?view=users&page=main&action=null";  
                                }, 1500);
                        }
                        ,
                        error: function(error){
                            swal("No se ha podido actualizar", {
                                icon: "error",
                                timer: 2000
                            });
                        }
                });           
            });
        } // success AJAX   
    });
     
  


});