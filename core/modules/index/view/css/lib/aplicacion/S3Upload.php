<?php

/**
 * Clase que encapsula las funciones de subida de archivos con su
 * seguridad correspondiente
 * @author Brandon Sanchez
 *
 */
if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');

class S3Upload {

    private $carpeta = '';
    private $type = array();
    private $maxLength = 0;
    private $extension = array();
    private $mensajes = array('errores' => array(), 'success' => array('cargado' => 0, 'mensaje' => '', 'url' => ''));

    /**
     * Inicia la clase asignando la ruta de la carpeta para subir los archivos,
     * si la carpeta no existe la crea, y verifica los permisos de la misma
     * 
     * @param string $carpeta -> Ruta relativa a partir del archivo hacia la carpeta donde se subiran los archivos
     */
    function __construct($carpeta) {
        $this->asignarCarpeta($carpeta);
        $this->loadMimeTypes();
        $this->loadMaxSize();
    }

    /**
     * @todo Funcion para crear carpeta si no existe
     * 
     * @global object $aplicacion
     * @param string $carpeta -> Ruta de la carpeta asignada en el momento de instanciar la clase
     */
    private function asignarCarpeta($carpeta) {
        global $aplicacion;
        $dir_uploads = $aplicacion->getConfig()->getVariableConfig('aplicacion-upload-directorio');
        $carpeta = $dir_uploads . $carpeta;

        if (!is_dir($carpeta)) {
            if (!mkdir($carpeta)) {
                $this->mensajes['errores'][] = array('codigo' => '003', 'titulo' => 'Error de carpeta', 'mensaje' => 'La carpeta no existe "' . $carpeta . '" y no pudo ser creada.');
            } else {
                copy($dir_uploads . 'index.html', $carpeta);
                $this->carpeta = $carpeta;
            }
        } else {
            $this->carpeta = $carpeta;
        }
    }

    /**
     * @todo Asigna las extensiones permitidas, con ello se asigna directamente el mime/type. \
     * Si no se asigna ninguna Extension se da por hecho que todas son permitidas sin \
     * restriccion, sin embargo debe ser acorde a su mime/type.
     * 
     * @param string or Array $valor -> Contine las extensiones permitidas puede agregar varias en un array de la forma array('ext1', 'ext2', ...)
     */
    public function setExtension($valor) {
        if (is_array($valor)) {
            $this->extension = $valor;
        } else {
            $this->extension[] = $valor;
        }
    }

    /**
     * @todo Carga el tamaño maximo de archivo en bytes desde el archivo config.yml 
     * 
     * @global object $aplicacion
     */
    public function loadMaxSize() {
        global $aplicacion;
        $this->maxLength = $aplicacion->getConfig()->getVariableConfig('aplicacion-upload-size');
    }

    /**
     * @todo Carga todos los mime/type disponibles en un array con su respectiva extension
     */
    public function loadMimeTypes() {
        $this->type = array("323" => "text/h323",
            "acx" => "application/internet-property-stream",
            "ai" => "application/postscript",
            "aif" => "audio/x-aiff",
            "aifc" => "audio/x-aiff",
            "aiff" => "audio/x-aiff",
            "asf" => "video/x-ms-asf",
            "asr" => "video/x-ms-asf",
            "asx" => "video/x-ms-asf",
            "au" => "audio/basic",
            "avi" => "video/x-msvideo",
            "axs" => "application/olescript",
            "bas" => "text/plain",
            "bcpio" => "application/x-bcpio",
            "bin" => "application/octet-stream",
            "bmp" => "image/bmp",
            "c" => "text/plain",
            "cat" => "application/vnd.ms-pkiseccat",
            "cdf" => "application/x-cdf",
            "cer" => "application/x-x509-ca-cert",
            "class" => "application/octet-stream",
            "clp" => "application/x-msclip",
            "cmx" => "image/x-cmx",
            "cod" => "image/cis-cod",
            "cpio" => "application/x-cpio",
            "crd" => "application/x-mscardfile",
            "crl" => "application/pkix-crl",
            "crt" => "application/x-x509-ca-cert",
            "csh" => "application/x-csh",
            "css" => "text/css",
            "dcr" => "application/x-director",
            "der" => "application/x-x509-ca-cert",
            "dir" => "application/x-director",
            "dll" => "application/x-msdownload",
            "dms" => "application/octet-stream",
            "doc" => "application/msword",
            "dot" => "application/msword",
            "dvi" => "application/x-dvi",
            "dxr" => "application/x-director",
            "eps" => "application/postscript",
            "etx" => "text/x-setext",
            "evy" => "application/envoy",
            "exe" => "application/octet-stream",
            "fif" => "application/fractals",
            "flr" => "x-world/x-vrml",
            "gif" => "image/gif",
            "gtar" => "application/x-gtar",
            "gz" => "application/x-gzip",
            "h" => "text/plain",
            "hdf" => "application/x-hdf",
            "hlp" => "application/winhlp",
            "hqx" => "application/mac-binhex40",
            "hta" => "application/hta",
            "htc" => "text/x-component",
            "htm" => "text/html",
            "html" => "text/html",
            "htt" => "text/webviewhtml",
            "ico" => "image/x-icon",
            "ief" => "image/ief",
            "iii" => "application/x-iphone",
            "ins" => "application/x-internet-signup",
            "isp" => "application/x-internet-signup",
            "jfif" => "image/pipeg",
            "jpe" => "image/jpeg",
            "jpeg" => "image/jpeg",
            "jpg" => "image/jpeg",
            "js" => "application/x-javascript",
            "latex" => "application/x-latex",
            "lha" => "application/octet-stream",
            "lsf" => "video/x-la-asf",
            "lsx" => "video/x-la-asf",
            "lzh" => "application/octet-stream",
            "m13" => "application/x-msmediaview",
            "m14" => "application/x-msmediaview",
            "m3u" => "audio/x-mpegurl",
            "man" => "application/x-troff-man",
            "mdb" => "application/x-msaccess",
            "me" => "application/x-troff-me",
            "mht" => "message/rfc822",
            "mhtml" => "message/rfc822",
            "mid" => "audio/mid",
            "mny" => "application/x-msmoney",
            "mov" => "video/quicktime",
            "movie" => "video/x-sgi-movie",
            "mp2" => "video/mpeg",
            "mp3" => "audio/mpeg",
            "mpa" => "video/mpeg",
            "mpe" => "video/mpeg",
            "mpeg" => "video/mpeg",
            "mpg" => "video/mpeg",
            "mpp" => "application/vnd.ms-project",
            "mpv2" => "video/mpeg",
            "ms" => "application/x-troff-ms",
            "mvb" => "application/x-msmediaview",
            "nws" => "message/rfc822",
            "oda" => "application/oda",
            "p10" => "application/pkcs10",
            "p12" => "application/x-pkcs12",
            "p7b" => "application/x-pkcs7-certificates",
            "p7c" => "application/x-pkcs7-mime",
            "p7m" => "application/x-pkcs7-mime",
            "p7r" => "application/x-pkcs7-certreqresp",
            "p7s" => "application/x-pkcs7-signature",
            "pbm" => "image/x-portable-bitmap",
            "pdf" => "application/pdf",
            "pfx" => "application/x-pkcs12",
            "pgm" => "image/x-portable-graymap",
            "pko" => "application/ynd.ms-pkipko",
            "pma" => "application/x-perfmon",
            "pmc" => "application/x-perfmon",
            "pml" => "application/x-perfmon",
            "pmr" => "application/x-perfmon",
            "pmw" => "application/x-perfmon",
            "png" => "image/png",
            "pnm" => "image/x-portable-anymap",
            "pot" => "application/vnd.ms-powerpoint",
            "ppm" => "image/x-portable-pixmap",
            "pps" => "application/vnd.ms-powerpoint",
            "ppt" => "application/vnd.ms-powerpoint",
            "prf" => "application/pics-rules",
            "ps" => "application/postscript",
            "pub" => "application/x-mspublisher",
            "qt" => "video/quicktime",
            "ra" => "audio/x-pn-realaudio",
            "ram" => "audio/x-pn-realaudio",
            "ras" => "image/x-cmu-raster",
            "rgb" => "image/x-rgb",
            "rmi" => "audio/mid",
            "roff" => "application/x-troff",
            "rtf" => "application/rtf",
            "rtx" => "text/richtext",
            "scd" => "application/x-msschedule",
            "sct" => "text/scriptlet",
            "setpay" => "application/set-payment-initiation",
            "setreg" => "application/set-registration-initiation",
            "sh" => "application/x-sh",
            "shar" => "application/x-shar",
            "sit" => "application/x-stuffit",
            "snd" => "audio/basic",
            "spc" => "application/x-pkcs7-certificates",
            "spl" => "application/futuresplash",
            "src" => "application/x-wais-source",
            "sst" => "application/vnd.ms-pkicertstore",
            "stl" => "application/vnd.ms-pkistl",
            "stm" => "text/html",
            "svg" => "image/svg+xml",
            "sv4cpio" => "application/x-sv4cpio",
            "sv4crc" => "application/x-sv4crc",
            "t" => "application/x-troff",
            "tar" => "application/x-tar",
            "tcl" => "application/x-tcl",
            "tex" => "application/x-tex",
            "texi" => "application/x-texinfo",
            "texinfo" => "application/x-texinfo",
            "tgz" => "application/x-compressed",
            "tif" => "image/tiff",
            "tiff" => "image/tiff",
            "tr" => "application/x-troff",
            "trm" => "application/x-msterminal",
            "tsv" => "text/tab-separated-values",
            "txt" => "text/plain",
            "uls" => "text/iuls",
            "ustar" => "application/x-ustar",
            "vcf" => "text/x-vcard",
            "vrml" => "x-world/x-vrml",
            "wav" => "audio/x-wav",
            "wcm" => "application/vnd.ms-works",
            "wdb" => "application/vnd.ms-works",
            "wks" => "application/vnd.ms-works",
            "wmf" => "application/x-msmetafile",
            "wps" => "application/vnd.ms-works",
            "wri" => "application/x-mswrite",
            "wrl" => "x-world/x-vrml",
            "wrz" => "x-world/x-vrml",
            "xaf" => "x-world/x-vrml",
            "xbm" => "image/x-xbitmap",
            "xla" => "application/vnd.ms-excel",
            "xlc" => "application/vnd.ms-excel",
            "xlm" => "application/vnd.ms-excel",
            "xls" => "application/vnd.ms-excel",
            "xlt" => "application/vnd.ms-excel",
            "xlw" => "application/vnd.ms-excel",
            "xof" => "x-world/x-vrml",
            "xpm" => "image/x-xpixmap",
            "xwd" => "image/x-xwindowdump",
            "z" => "application/x-compress",
            "zip" => "application/zip");
    }

    /**
     * @todo Funcion para verificar si hay filtro por extension o no
     * 
     * @return boolean
     */
    private function verificarExtension() {
        $flag = true;

        if (is_array($this->extension) && count($this->extension) == 0) {
            $flag = false;
        } else if ($this->extension == '') {
            $flag = false;
        }
        return $flag;
    }

    /**
     * @todo Funcion final para subir archivo
     * 
     * @param string $var -> nombre del input del archivo que cargará
     * @param boolean $hash -> Si el nombre debe generar un aleatorio
     * @return array -> Mensajes de error y/o success
     */
    public function subirArchivo($var, $hash = true) {
        if (isset($_FILES[$var]) && count($_FILES[$var]) > 0) {
            $destino = substr($this->carpeta, -1, 1) != '/' ? $this->carpeta . '/' : $this->carpeta;

            $tipo = $_FILES[$var]['type'];
            $peso = $_FILES[$var]['syze'];
            $nombre_tmp = $_FILES[$var]['tmp_name'];
            $nombre = $_FILES[$var]['name'];
            $extension = strtolower(end(explode('.', $nombre)));

            if ($this->verificarExtension()) {
                if (in_array($extension, $this->extension) === false) {
                    $this->mensajes['errores'][] = array('codigo' => '059', 'titulo' => 'Extensión invalida', 'mensaje' => 'El archivo no corresponde a ninguna de las extensiones permitidas: Extensión del archivo: ' . $extension . ', permitidas: ' . implode(', ', $this->extension));
                } else if ($tipo != $this->type[$extension] && $tipo != "application/octet-stream") {
                    $this->mensajes['errores'][] = array('codigo' => '219', 'titulo' => 'Tipo de archivo invalido', 'mensaje' => 'El tipo de archivo no es válido. Según la extensión (' . $extension . ') debe ser ' . $this->type[$extension] . ' y  se obtuvo ' . $tipo);
                }
            }

            if ($peso > $this->maxLength) {
                $this->mensajes['errores'][] = array('codigo' => '521', 'titulo' => 'Exceso de tamaño', 'mensaje' => 'El tamaño del archivo debe ser menor que ' . floor($this->maxLength / 1024) . ' y el archivo pesa ' . floor($peso / 1024));
            }

            if (empty($this->mensajes['errores'])) {
                if ($hash) {
                    $ruta_destino = $destino . $this->generarNombre($nombre);
                } else {
                    $ruta_destino = $destino . preg_replace("/ /", "_", $nombre);
                }
                if (move_uploaded_file($nombre_tmp, $ruta_destino)) {
                    $this->mensajes['success'] = array('cargado' => 1, 'mensaje' => 'El archivo se ha cargado satisfactoriamente.', 'url' => $ruta_destino);
                } else {
                    $this->mensajes['errores'][] = array('codigo' => '777', 'titulo' => 'Archivo no movido', 'mensaje' => 'No se ha cargado un archivo con la variable ' . $var . ' revise permisos en el directorio.');
                }
            }
        } else {
            $this->mensajes['errores'][] = array('codigo' => '000', 'titulo' => 'Archivo Invalido', 'mensaje' => 'No se ha cargado un archivo con la variable ' . $var);
        }

        return $this->mensajes;
    }

    /**
     * Funcion para generar nombre aleatorio siempre y cuando la variable $hash de Subir archivo este en true
     * 
     * @global object $aplicacion
     * @param string $nombre_archivo
     * @return string
     */
    private function generarNombre($nombre_archivo) {
        global $aplicacion;

        $rand = microtime() . '-' . mt_srand(time());
        $hash = crc32(md5($rand));
        $nombreTmp = explode('.', $nombre_archivo);
        $ext = '.' . array_pop($nombreTmp);
        $nombre = preg_replace("/ /", "_", $nombreTmp[0]) . '-' . $hash . $aplicacion->getUsuario()->getNombre() . $ext;

        return $nombre;
    }

}
