(function ($) {
    $.fn.validationEngineLanguage = function () {
    };
    $.validationEngineLanguage = {
        newLang: function () {
            $.validationEngineLanguage.allRules = {
                "required": {// Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText": "* Este campo es obligatorio",
                    "alertTextCheckboxMultiple": "* Por favor seleccione una opción",
                    "alertTextCheckboxe": "* Este checkbox es obligatorio"
                },
                "requiredInFunction": {
                    "func": function (field, rules, i, options) {
                        return (field.val() == "test") ? true : false;
                    },
                    "alertText": "* Field must equal test"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Mínimo de ",
                    "alertText2": " caracteres autorizados"
                },
                "groupRequired": {
                    "regex": "none",
                    "alertText": "* Debe de rellenar al menos uno de los siguientes campos"
                },
                "maxSize": {
                    "regex": "none",
                    "alertText": "* Máximo de ",
                    "alertText2": " caracteres autorizados"
                },
                "min": {
                    "regex": "none",
                    "alertText": "* El valor mínimo es "
                },
                "max": {
                    "regex": "none",
                    "alertText": "* El valor máximo es "
                },
                "past": {
                    "regex": "none",
                    "alertText": "* Fecha anterior a "
                },
                "future": {
                    "regex": "none",
                    "alertText": "* Fecha posterior a "
                },
                "maxCheckbox": {
                    "regex": "none",
                    "alertText": "* Se ha excedido el número de opciones permitidas"
                },
                "minCheckbox": {
                    "regex": "none",
                    "alertText": "* Por favor seleccione ",
                    "alertText2": " opciones"
                },
                "equals": {
                    "regex": "none",
                    "alertText": "* Los campos no coinciden"
                },
                "creditCard": {
                    "regex": "none",
                    "alertText": "* La tarjeta de crédito no es válida"
                },
                "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Número de teléfono inválido"
                },
                "email": {
                    // Shamelessly lifted from Scott Gonzalez via the Bassistance Validation plugin http://projects.scottsplayground.com/email_address_validation/
//                    "regex": /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,
                    // Lista de dominios por pais http://goo.gl/SOCxR3 http://goo.gl/I4whES
                    "regex": /^[0-9a-zA-Z_\-\.]+@([a-zA-Z0-9\-]+\.?)*[a-zA-Z0-9]+\.(BIZ|COM|EDU|GOV|INFO|INT|MIL|NAME|NET|ORG|AF|AX|AL|DE|AD|AO|AI|AQ|AG|AN|SA|DZ|AR|AM|AW|AC|AU|AT|AZ|BS|RO|BH|BB|BE|BZ|BJ|BM|BY|BO|BA|BW|BR|BN|BG|BF|BI|BT|CH|CV|KY|KH|CM|CA|CR|TD|CL|CN|TW|CY|NC|CC|CO|KM|CG|CD|CK|KP|KR|CI|CR|HR|CU|DE|DK|DM|DO|EC|EG|SV|AE|ER|SK|SI|ES|US|EE|ET|EU|FO|PH|FI|FJ|FR|GA|GM|GE|GS|GH|GI|GD|GR|GL|GU|GT|GG|GN|GQ|GW|GY|HT|HN|HK|HU|IN|UK|ID|IR|IQ|IE|IS|IL|IT|JM|JP|JE|JO|KZ|KE|KG|KI|KW|LA|LS|LV|LB|LR|LY|LI|LT|LU|MO|MK|MG|MY|MW|MV|ML|MT|FK|IM|MP|MA|MH|MU|MR|MX|FM|MD|MC|MN|ME|MS|MZ|MM|NA|CX|NR|NP|NI|NE|NG|NU|NF|NO|NC|NZ|OM|NL|PK|PW|PS|PA|PG|PY|PE|PN|PF|PL|PT|PR|SO|QA|UK|CF|CZ|DO|RW|RO|RU|EH|PM|SB|WS|AS|KN|SM|VC|SH|LC|ST|SN|RS|SC|SL|SG|SY|SO|LK|SZ|ZA|SD|SE|CH|SR|NO|SJ|SV|TH|TZ|TJ|TF|IO|TL|TG|TK|TO|TT|SH|TN|TC|TM|TR|TV|UA|UG|UM|UY|UZ|VU|VA|VE|VN|VG|VI|WF|YE|DJ|ZM|ZW|AQ|BV|VE|CAT|CS|DD|EUS|GF|GR|MQ|SJ|ZR|biz|com|edu|gov|info|int|mil|name|net|org|af|ax|al|de|ad|ao|ai|aq|ag|an|sa|dz|ar|am|aw|ac|au|at|az|bs|ro|bh|bb|be|bz|bj|bm|by|bo|ba|bw|br|bn|bg|bf|bi|bt|ch|cv|ky|kh|cm|ca|cr|td|cl|cn|tw|cy|nc|cc|co|km|cg|cd|ck|kp|kr|ci|cr|hr|cu|de|dk|dm|do|ec|eg|sv|ae|er|sk|si|es|us|ee|et|eu|fo|ph|fi|fj|fr|ga|gm|ge|gs|gh|gi|gd|gr|gl|gu|gt|gg|gn|gq|gw|gy|ht|hn|hk|hu|in|uk|id|ir|iq|ie|is|il|it|jm|jp|je|jo|kz|ke|kg|ki|kw|la|ls|lv|lb|lr|ly|li|lt|lu|mo|mk|mg|my|mw|mv|ml|mt|fk|im|mp|ma|mh|mu|mr|mx|fm|md|mc|mn|me|ms|mz|mm|na|cx|nr|np|ni|ne|ng|nu|nf|no|nc|nz|om|nl|pk|pw|ps|pa|pg|py|pe|pn|pf|pl|pt|pr|so|qa|uk|cf|cz|do|rw|ro|ru|eh|pm|sb|ws|as|kn|sm|vc|sh|lc|st|sn|rs|sc|sl|sg|sy|so|lk|sz|za|sd|se|ch|sr|no|sj|sv|th|tz|tj|tf|io|tl|tg|tk|to|tt|sh|tn|tc|tm|tr|tv|ua|ug|um|uy|uz|vu|va|ve|vn|vg|vi|wf|ye|dj|zm|zw|aq|bv|ve|cat|cs|dd|eus|gf|gr|mq|sj|zr)+$/,
                    "alertText": "* Correo inválido"

                },
                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "* No es un valor entero válido"
                },
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\-\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/,
                    "alertText": "* No es un valor decimal válido"
                },
                "date": {
//                    "regex": /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/,
//                    "alertText": "* Fecha inválida, por favor utilize el formato DD/MM/AAAA"
                    "regex": /^[0-9]{4}-(0?[1-9]|1[012])-(0?[1-9]|[12][0-9]|3[01])$/,
                    "alertText": "* Fecha inválida, por favor utilize el formato AAAA-MM-DD"
                },
                "ipv4": {
                    "regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    "alertText": "* Direccion IP inválida"
                },
                "url": {
//                    "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                    "regex": /^((ht|f)tps?:\/\/)?\w+([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?$/i,
                    "alertText": "* URL Inválida"
                },
                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "* Sólo números"
                },
                "onlyLetterSp": {
                    "regex": /^[a-zA-Z\ \']+$/,
                    "alertText": "* Sólo letras"
                },
                "onlyLetterNumber": {
                    "regex": /^[0-9a-zA-Z]+$/,
                    "alertText": "* No se permiten caracteres especiales"
                },
                // --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
                "ajaxUserCall": {
                    "url": "ajaxValidateFieldUser",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    "alertTextLoad": "* Cargando, espere por favor",
                    "alertText": "* Este nombre de usuario ya se encuentra usado"
                },
                //class="validate[ajax[ajaxAccount]]"
                "ajaxAccount": {
                    "url": "index.php?module=Accounts&action=comprorbar_duplicado",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": ['#tipo_documento', '#tipo_persona', '#digito_verificacion', '#numero_identificacion', '#record'],
                    "alertTextLoad": "* Verificando, espere por favor",
                    "alertText": "* Este Cliente ya se encuentra registrado"
                },
                //class="validate[ajax[ajaxSerialCompra]]"
                "ajaxSerialCompra": {
                    "url": "index.php?modulo=Movimiento_inventario&accion=verificarserialcompra",
                    "alertTextLoad": "* Verificando, espere por favor",
                    "alertText": "* Este Serial ya está registrado!",
                },
                //class="validate[ajax[ajaxSerialDevolucion]]"
                "ajaxSerialDevolucion": {
                    "url": "index.php?modulo=Movimiento_inventario&accion=verificarserialdevolucion",
                    "alertTextLoad": "* Verificando, espere por favor",
                    "alertText": "* Este Serial no está registrado o ya ha sido vendido!",
                },
                //class="validate[ajax[ajaxSerialRemision]]"
                "ajaxSerialRemision": {
                    "url": "index.php?modulo=remisiones&accion=verificarserial",
                    "alertTextLoad": "* Verificando, espere por favor",
                    "alertText": "* Este Serial ya está registrado!",
                },
                "ajaxNameCall": {
                    // remote json service location
                    "url": "ajaxValidateFieldName",
                    // error
                    "alertText": "* Este nombre ya se encuentra usado",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* Este nombre está disponible",
                    // speaks by itself
                    "alertTextLoad": "* Cargando, espere por favor"
                },
                "lbl_ajax": {
                    // error
                    "alertText": "* Ya se encuentra este registro",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "No se ecnuentra el registro, puede proceder",
                    // speaks by itself
                    "alertTextLoad": "* Cargando, espere por favor"
                },
                "validate2fields": {
                    "alertText": "* Por favor entrar HELLO"
                },
                "minUnaMayus": {
                    "regex": /[A-Z]/,
                    "alertText": "* Debe Contener una Letra Mayúscula"
                },
                "minUnNumero": {
                    "regex": /[0-9]/,
                    "alertText": "* Debe Contener un número"
                },
                "comparacionFechas": {
                    "alertText2": "* Requerid@ ",
                    "alertText": " inválida para comparar con "
                },
                "comparacionFechaActual": {
                    "alertText": "* Es inferior a la fecha Actual"
                },
                "validaMIME": {
                    "alertText": "* Tipo de Archivo NO Válido"
                },
                "verificarSerial": {
                    "alertText": "* Este SERIAL ya esta en el formulario"
                },
                "compararCampos": {
                    "alertText": " no es igual a "
                },
            };
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);


// Para Usarla validate[funcCall[compararCampos[#campoAcomparar]]] y debe ir como primera validacion
function compararCampos(field, rules, i, options) {

    var campoActual = '#' + field.context.id;
    var campoCompara = rules[i + 2];
    var lbl_campoActual = $(campoActual).parent().parent().find('label').text();
    var lbl_campoCompara = $(campoCompara).parent().parent().find('label').text();
    lbl_campoActual = lbl_campoActual.replace(':*', '');
    lbl_campoCompara = lbl_campoCompara.replace(':*', '');

    if ($(campoActual).val() === $(campoCompara).val()) {
        return true;
    } else {
        return lbl_campoActual + options.allrules.compararCampos.alertText + lbl_campoCompara;
    }


}
// Para Usarla validate[funcCall[verificarSerial]]
function verificarSerial(field, rules, i, options) {

    var aux = 0;
    $.each($('.serial'), function (k, v) {
        if ($(field).val() === $(v).val()) {
            aux++;
        }

    });

    if (aux <= 1) {
        return true;
    } else {
        return options.allrules.verificarSerial.alertText;
    }
}
// Para Usarla validate[funcCall[ajaxValidacionCliente]]
function ajaxValidacionCliente(field, rules, i, options) {
    var input = '#' + field.context.id;
    var mensaje = '';
    $.ajax({
        url: "index.php?modulo=clientes&accion=comprorbar_duplicado",
        cache: false,
        type: "POST",
        dataType: 'json',
        async: false,
        beforeSend: function () {

        },
        data: {numero_documento: $(input).val()},
        success: function (json) {
            if (json.id > 0) {
                if (confirm('se Encontro un cliente con este numero de Documento, Desea usarlo?')) {
                    $('#tipo_documento_id').select2('val', json.tipo_documento_id);
                    $('#nombre').val(json.nombre);
                } else {
                    $(input).val('');
                }
            }
        },
    });
//    return mensaje;
}
//Agregar el Input  class="validate[funcCall[validarMIME[image/jpeg|image/png|image/jpg]]]"
// Como parametros los mime que sean para validar 
function validarMIME(field, rules, i, options) {

    var fileInput = field[0].files[0];
    if (fileInput) {
        var flag = true;
        var mimes = rules[2].split('|');
        for (var i = 0; mimes.length > i; i++) {
            if (fileInput.type === mimes[i]) {
                flag = false;
            }
        }
        if (flag) {
            return options.allrules.validaMIME.alertText;
        }
    } else {
        return true;
    }
}

// Agregar el Input class="validate[funcCall[compararFecha[#fecha_creacion_desde]]]"
function compararFecha(field, rules, i, options) {

    var form = rules[i + 2];
    var input = '#' + field.context.id;
    var lbl_fecha1 = $(form).parent().parent().find('label').text();
    var lbl_fecha2 = $(input).parent().parent().find('label').text();
    lbl_fecha2 = lbl_fecha2.replace(':*', '');
    lbl_fecha1 = lbl_fecha1.replace(':*', '');
    var fecha1 = $(form).val();
    fecha1 = new Date(fecha1.replace(/-/g, '/'));
    var fecha2 = $(input).val();
    fecha2 = new Date(fecha2.replace(/-/g, '/'));
    if (fecha1 !== '') {
        if (fecha2 >= fecha1) {
            return true;
        }
        return  lbl_fecha1 + options.allrules.comparacionFechas.alertText + lbl_fecha2;
    }
    return options.allrules.comparacionFechas.alertText2 + lbl_fecha1;
}

// Agregar el Input class="validate[funcCall[comparaConFechaActual[#fecha_creacion_desde]]]"
function comparaConFechaActual(field, rules, i, options) {
    var input = '#' + field.context.id;
    var hoy = fechaActual();
    var fecha = $(input).val();
    if (fecha !== '') {
        if (hoy > fecha) {
            return options.allrules.comparacionFechaActual.alertText + ' (' + hoy + ') ';
        }
        return true;
    }
}

function fechaActual() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }

    return today = yyyy + '-' + mm + '-' + dd;
}
	