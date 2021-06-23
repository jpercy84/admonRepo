const string = window.location.search
const page = string.indexOf("?view=perfiles&page=nuevo_sisben&action=null")
 
    $(document).ready(function() {
         jQuery('input[type=file]').change(function(){

           var filename = jQuery(this).val().split('\\').pop();
 
            $("#labelnombre").text(filename);
 
         });
           
        
    })
 







function cancelar() {
    window.location = `./?view=perfiles&page=index&action=null`
    //location.reload(true);
}

function recopilar_datos() {
   var datos = new FormData();
    datos.append("archivo",$('#InputFile')[0].files[0]);
    datos.append("accion","ingresar");

    return datos
}

/** VERIFICAR QUE SE CUMPLA CON LO REQUERIDO PARA INICIAR PROCESO DE PERSISTIR LA INFORMACION */
function validar_campos() {
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




function inicioCarga() {

    const timeOut = setTimeout(reiniciar, 10000*180)
    const element = document.createElement("div")
    element.innerHTML =
        `<div class="progress">
            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="width: 100%">CARGANDO</div>
        </div>`

    swal({
        buttons: false,
        closeOnEsc: false,
        closeOnClickOutside: false,
        content: element
    })

    return timeOut
}

function finCarga(timeOut) {
    clearTimeout(timeOut)
    swal.close()
}

function reiniciar() {
    swal(decode_utf8("Se esta demorando más de lo esperado, la pagina será recargada"), {
        timer: 1000
    }).then(() => {
        top.location.reload(true)
    })
}



function uploadchange() {
                 
 document.getElementById('cargar').innerHTML  = '<progress id="barra" max="100">Cargando...</progress>';



               var input = document.getElementById("InputFile");
               var ul = document.getElementById("uploadlist");
               while (ul.hasChildNodes()) {
                   ul.removeChild(ul.firstChild);
               }
               for (var i = 0; i < input.files.length; i++) {
                   var li = document.createElement("li");
                   thefilesize = input.files[i].fileSize||input.files[i].size;
                   if (thefilesize > 1024 * 1024){
                                thefilesize = (Math.round(thefilesize  * 100 / (1024 * 1024)) / 100).toString() + 'MB';
                            }else{
                                   thefilesize = (Math.round(thefilesize  * 100 / 1024) / 100).toString() + 'KB';
                   }

                   li.innerHTML = input.files[i].name + " " + thefilesize ;
                   ul.appendChild(li);             
               }
               if(!ul.hasChildNodes()) {
                   var li = document.createElement("li");
                   li.innerHTML = 'No Files Selected';
                   ul.appendChild(li);
               }
               sendRequest();
           }

window.BlobBuilder = window.MozBlobBuilder || window.WebKitBlobBuilder || window.BlobBuilder;

               function sendRequest() {
           var blob = document.getElementById('InputFile').files[0];
                   //var BYTES_PER_CHUNK = 1048576; // 1MB chunk sizes.
//var BYTES_PER_CHUNK = 104857; // 1MB chunk sizes.
var BYTES_PER_CHUNK = 5242880; // 1MB chunk sizes.
//var BYTES_PER_CHUNK = 209715200; // 1MB chunk sizes.

                   var SIZE = blob.size;
                   var start = 0;
                   var end = BYTES_PER_CHUNK;
           window.uploadcounter=0;
           window.uploadfilearray = [];
           //document.getElementById('progressNumber').innerHTML = "Upload: 0 % ";
                   while( start < SIZE ) {

                       var chunk = blob.slice(start, end);
               window.uploadfilearray[window.uploadcounter]=chunk;
                           window.uploadcounter=window.uploadcounter+1;
                       start = end;
                       end = start + BYTES_PER_CHUNK;
                   }
           window.uploadcounter=0;
           uploadFile(window.uploadfilearray[window.uploadcounter],document.getElementById('InputFile').files[0].name);
               }

               function fileSelected() {
                   var file = document.getElementById('fileToUpload').files[0];
                   if (file) {
                       var fileSize = 0;
                       if (file.size > 1024 * 1024)
                           fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
                       else
                           fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';

 
                       document.getElementById('fileName').innerHTML = 'Name: ' + file.name;
                       document.getElementById('fileSize').innerHTML = 'Size: ' + fileSize;
                       document.getElementById('fileType').innerHTML = 'Type: ' + file.type;
                   }
               }

               function uploadFile(blobFile,filename) {
                   var fd = new FormData();
                   filename = filename.replace(/ /g, "");
                   fd.append("fileToUpload", blobFile);
                   fd.append("accion", "fragmentar");
                   fd.append("filename", filename);
                   var xhr = new XMLHttpRequest();


                   xhr.addEventListener("load", uploadComplete, false);
                   xhr.addEventListener("error", uploadFailed, false);
                   xhr.addEventListener("abort", uploadCanceled, false);

                   xhr.open("POST", "./?action=_upload");
                    

                   xhr.onload = function(e) {
               window.uploadcounter=window.uploadcounter+1;
               if (window.uploadfilearray.length > window.uploadcounter ){
                   uploadFile(window.uploadfilearray[window.uploadcounter],document.getElementById('InputFile').files[0].name); 
                   var percentloaded2 = parseInt((window.uploadcounter/window.uploadfilearray.length)*100);

                    //document.getElementById('barra').value += 1;
   
                   //document.getElementById('progressNumber').innerHTML = 'Cargando: '+percentloaded2+' % ';                              
               }else{
                   //document.getElementById('progressNumber').innerHTML = "Archivo Cargado";
                  

                  var fd = new FormData();
                  
                   fd.append("fileToUpload", filename);
                   fd.append("accion", "ingresarbd");

                   var xhr = new XMLHttpRequest();

                   //xhr.open("POST", "./?view=icl&page=sendbd&action=null");
                  // xhr.open("POST", "./?action=_icl");
                   xhr.open("POST", "./?view=upload&page=sendbd&action=null");
                   xhr.onreadystatechange = function() {//Call a function when the state changes.
                        if(xhr.readyState == 4 && xhr.status == 200) {
                           // alert(xhr.responseText);
                              swal("ARCHIVO GUARDADO!", {
                                  icon: "success",
                                  timer: 3000
                              })
                              .then(() => {
                                 document.getElementById('cargar').innerHTML  = 'Cargado!!';
                              })
                        }
                    }
                   xhr.send(fd);

                  
                   //loadXMLDoc('./system/loaddir.php?url='+ window.currentuploaddir);

               }
                     };

                   xhr.send(fd);

               }

              function uploadComplete(evt) {
                   /* This event is raised when the server send back a response */
           if (evt.target.responseText != ""){
                      //alert(evt.target.responseText);

           }
               }

               function uploadFailed(evt) {
                   alert("There was an error attempting to upload the file.");
               }

               function uploadCanceled(evt) {
                   xhr.abort();
                   xhr = null;
                   //alert("The upload has been canceled by the user or the browser dropped the connection.");
               }




