Para hacer uso de la libreria solo basta con instanciar la clase asi:

require_once 'edPDF/edpdf.php';
$edpdf = new edPDF();

luego puede hacer uso de las funciones directamente de edPDF o de fpdf.

ejemplo:

<?php
	require_once 'edPDF/edpdf.php';
	$edpdf = new edPDF();
	
	$edpdf->edPdfAddPage('miplantilla.pdf', 1); //en donde el primer
						    parametro es la ruta 
						    de la plantilla pdf, 
						    y el segundo parametro 
						    es la pagina que desea
						    importar desde la plantilla.
						    
	$this->edpdf->insertar("Texto que desea insertar", 14, 49, 'BIU', 26); //('texto', posicionX, posicionY, 'Estilo', tamaño_fuente);
	
	$this->edpdf->generarPDF('NombrePDF_Salida.pdf', 'I'); //I para ver en navegador, D para descarga
	
	/** Tambien puede usar insertarCell con los parametros que se explican en la clase lo que automaticamente
 	    dara saltos de linea a textos muy largos.
	**/
	
Revisar clase para conocer el resto de la documentacion.	
	