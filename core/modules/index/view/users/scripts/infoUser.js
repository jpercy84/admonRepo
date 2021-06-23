 function goBack(){
        window.history.back();
    }
$( document ).ready(function() {

    let searchParams = new URLSearchParams(window.location.search);
    let param = searchParams.get('email');
 

    let url = "./?action=infoUser";
    let datos = {};

    datos = {
        "email" : param
    }
    $.ajax({
        type: "POST",
        url: url,
        data: datos,
        success: function(data){
        console.log(data);
        $('section.info').empty();

        const uList = document.createElement('ul');
        uList.classList.add('list-group');
        
        for (var key in data) {
            const itemLi = document.createElement('li');
            itemLi.classList.add('list-group-item');
            itemLi.innerHTML='<b>' + key + '</b>: <h2>' + data[key] + '</h2>';
            uList.append(itemLi);
        }        
        $('section.info').append(uList);
        $('section.info').load('section.info');
    }   
    });
     


});