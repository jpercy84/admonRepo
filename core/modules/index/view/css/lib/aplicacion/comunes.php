<?php

function __P($elemento, $detener = true) {
    echo "<pre>";
    print_r($elemento);
    if ($detener) {
        die();
    }
}

function __V($elemento, $detener = true) {
    echo "<pre>";
    var_dump($elemento);
    if ($detener) {
        die();
    }
}

function __M($elemento, $detener = false) {
    echo '<span class="error">' . $elemento . '</span>';
    if ($detener) {
        die();
    }
}

function limpiarCadena($cadena) {
    $cadena = trim(ucwords(strtolower($cadena)));
    return $cadena;
}

function cHtml($val) {
    return htmlspecialchars($val, ENT_QUOTES, 'utf-8');
}

function _SERVER($vn = NULL) {
    if($vn === NULL) {
        return filter_input_array(INPUT_SERVER);
    } else {
        return filter_input(INPUT_SERVER, $vn);
    }
}
